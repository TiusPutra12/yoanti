<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

// Halaman Utama
Route::get('/', function () {
    $orders = json_decode(Storage::exists('orders.json') ? Storage::get('orders.json') : '[]', true) ?: [];
    $completedProjects = count(array_filter($orders, fn($o) => isset($o['status']) && strtolower($o['status']) === 'selesai'));
    
    $comments = json_decode(Storage::exists('comments.json') ? Storage::get('comments.json') : '[]', true) ?: [];
    $totalTestimonials = is_array($comments) ? count($comments) : 0;

    return view('welcome', compact('completedProjects', 'totalTestimonials'));
});

// Halaman Komentar
Route::get('/komentar', function () {
    $commentsContent = Storage::exists('comments.json') ? Storage::get('comments.json') : '[]';
    $comments = json_decode($commentsContent, true);
    // Sort array so newest is first
    if(is_array($comments)){
        $comments = array_reverse($comments);
    } else {
        $comments = [];
    }
    return view('komentar', compact('comments'));
});

// Proses Tambah Komentar Utama
Route::post('/komentar', function (Request $request) {
    if (!session()->has('user')) {
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu untuk berkomentar.');
    }

    if (isset(session('user')['role']) && session('user')['role'] === 'admin') {
        return back()->with('error', 'Admin tidak dapat menambahkan komentar utama.');
    }

    $request->validate([
        'comment' => 'required|string',
    ]);

    $commentsContent = Storage::exists('comments.json') ? Storage::get('comments.json') : '[]';
    $comments = json_decode($commentsContent, true);
    if (!is_array($comments)) $comments = [];

    $comments[] = [
        'id' => uniqid('cmt_'),
        'name' => session('user')['name'],
        'username' => session('user')['username'],
        'role' => session('user')['role'] ?? 'user',
        'comment' => $request->comment,
        'created_at' => now()->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i'),
        'replies' => []
    ];

    Storage::put('comments.json', json_encode($comments, JSON_PRETTY_PRINT));

    return back()->with('success', 'Komentar berhasil ditambahkan!');
});

// Proses Balas Komentar
Route::post('/komentar/reply', function (Request $request) {
    if (!session()->has('user')) return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
    $request->validate([
        'parent_id' => 'required',
        'reply_comment' => 'required|string',
    ]);

    $commentsContent = Storage::exists('comments.json') ? Storage::get('comments.json') : '[]';
    $comments = json_decode($commentsContent, true);
    if (!is_array($comments)) $comments = [];

    foreach ($comments as &$c) {
        if (isset($c['id']) && $c['id'] === $request->parent_id) {
            if (!isset($c['replies'])) $c['replies'] = [];
            $c['replies'][] = [
                'id' => uniqid('rep_'),
                'name' => session('user')['name'],
                'username' => session('user')['username'],
                'role' => session('user')['role'] ?? 'user',
                'comment' => $request->reply_comment,
                'created_at' => now()->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i'),
            ];
            break;
        }
    }

    Storage::put('comments.json', json_encode($comments, JSON_PRETTY_PRINT));
    return back()->with('success', 'Balasan berhasil ditambahkan!');
});

// Halaman Pesan Sekarang (Protected)
Route::get('/pesan', function () {
    if (!session()->has('user')) {
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu untuk pemesanan.');
    }
    if (isset(session('user')['role']) && session('user')['role'] === 'admin') {
        return redirect('/')->with('error', 'Admin tidak dapat memesan produk.');
    }
    return view('pesan');
});

// Proses Simpan Pesanan Sebelum ke WA
Route::post('/pesan/store', function (Request $request) {
    if (!session()->has('user')) return response()->json(['error' => 'Unauthorized'], 401);
    if (isset(session('user')['role']) && session('user')['role'] === 'admin') return response()->json(['error' => 'Forbidden'], 403);
    
    $ordersContent = Storage::exists('orders.json') ? Storage::get('orders.json') : '[]';
    $orders = json_decode($ordersContent, true);
    if (!is_array($orders)) $orders = [];

    $newOrder = [
        'id' => 'ORD-' . strtoupper(bin2hex(random_bytes(3))),
        'user_username' => session('user')['username'],
        'name' => $request->name,
        'company' => $request->company,
        'address' => $request->address,
        'programType' => $request->programType,
        'budget' => $request->budget,
        'description' => $request->description,
        'status' => 'pending', 
        'created_at' => now()->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i'),
    ];

    $orders[] = $newOrder;
    Storage::put('orders.json', json_encode($orders, JSON_PRETTY_PRINT));

    return response()->json(['success' => true, 'order' => $newOrder]);
});

// Halaman Pesanan Saya untuk User
Route::get('/pesanan-saya', function () {
    if (!session()->has('user') || session('user')['role'] === 'admin') {
        return redirect('/')->with('error', 'Akses ditolak.');
    }
    
    $ordersContent = Storage::exists('orders.json') ? Storage::get('orders.json') : '[]';
    $orders = json_decode($ordersContent, true);
    if (!is_array($orders)) $orders = [];
    
    $myOrders = array_filter($orders, function($o) {
        return $o['user_username'] === session('user')['username'];
    });
    
    $myOrders = array_reverse($myOrders);

    return view('pesanan-saya', compact('myOrders'));
});

// Halaman Admin: Dashboard Permintaan
Route::get('/admin/permintaan', function () {
    if (!session()->has('user') || session('user')['role'] !== 'admin') {
        return redirect('/')->with('error', 'Akses ditolak. Anda bukan admin.');
    }
    
    $ordersContent = Storage::exists('orders.json') ? Storage::get('orders.json') : '[]';
    $orders = json_decode($ordersContent, true);
    if(is_array($orders)) {
        $orders = array_reverse($orders);
    } else {
        $orders = [];
    }

    return view('admin.dashboard', compact('orders'));
});

// Admin Update Status Pesanan (Permintaan)
Route::post('/admin/permintaan/status', function (Request $request) {
    if (!session()->has('user') || session('user')['role'] !== 'admin') {
        return back()->with('error', 'Akses ditolak.');
    }

    $request->validate([
        'order_id' => 'required',
        'status' => 'required'
    ]);

    $ordersContent = Storage::exists('orders.json') ? Storage::get('orders.json') : '[]';
    $orders = json_decode($ordersContent, true);
    if (!is_array($orders)) $orders = [];

    $updated = false;
    foreach ($orders as &$order) {
        if ($order['id'] === $request->order_id) {
            $order['status'] = $request->status;
            $updated = true;
            break;
        }
    }

    if ($updated) {
        Storage::put('orders.json', json_encode($orders, JSON_PRETTY_PRINT));
        return back()->with('success', 'Status permintaan berhasil diperbarui!');
    }

    return back()->with('error', 'Permintaan tidak ditemukan.');
});

// Logika Auth: GET & POST Login
Route::get('/login', function () {
    if (session()->has('user')) return redirect('/');
    
    // Seed admin & superadmin if not exist
    $usersContent = Storage::exists('users.json') ? Storage::get('users.json') : '[]';
    $users = json_decode($usersContent, true);
    if (!is_array($users)) $users = [];
    
    $adminExists = collect($users)->contains('username', 'admin');
    $superAdminExists = collect($users)->contains('username', 'superadmin');

    $updatedUsers = false;
    if (!$adminExists) {
        $users[] = [
            'name' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'role' => 'admin'
        ];
        $updatedUsers = true;
    }
    if (!$superAdminExists) {
        $users[] = [
            'name' => 'Super Administrator',
            'username' => 'superadmin',
            'password' => Hash::make('sp123456789'),
            'role' => 'superadmin'
        ];
        $updatedUsers = true;
    }

    if ($updatedUsers) {
        Storage::put('users.json', json_encode($users, JSON_PRETTY_PRINT));
    }

    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $usersContent = Storage::exists('users.json') ? Storage::get('users.json') : '[]';
    $users = json_decode($usersContent, true);
    if(is_array($users)) {
        foreach ($users as $user) {
            if ($user['username'] === $request->username && Hash::check($request->password, $user['password'])) {
                if(!isset($user['role'])) $user['role'] = 'user'; // fallback for existing
                session(['user' => $user]);
                return redirect('/')->with('success', 'Selamat datang, ' . $user['name'] . '!');
            }
        }
    }

    return back()->with('error', 'Username atau password salah.');
});

// Logika Auth: GET & POST Register
Route::get('/register', function () {
    if (session()->has('user')) return redirect('/');
    return view('register');
});

Route::get('/terms', function () {
    return view('terms');
});

Route::get('/privacy', function () {
    return view('privacy');
});

Route::post('/register', function (Request $request) {
    $request->validate([
        'role' => 'required|in:job_provider,job_seeker',
        'name' => 'required',
        'username' => 'required',
        'password' => 'required|min:4',
        'profession' => 'required|string',
        'skills' => 'required|string',
        'workplace' => 'nullable|string',
        'payment_method' => 'required|string',
        'terms' => 'accepted' // This ensures the checkbox is checked
    ]);

    $usersContent = Storage::exists('users.json') ? Storage::get('users.json') : '[]';
    $users = json_decode($usersContent, true);
    if (!is_array($users)) $users = [];

    // Check if username exists
    foreach ($users as $u) {
        if ($u['username'] === $request->username) {
            return back()->with('error', 'Username sudah digunakan, silakan pilih yang lain.')->withInput();
        }
    }

    $users[] = [
        'name' => $request->name,
        'username' => $request->username,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'profession' => $request->profession,
        'skills' => $request->skills,
        'workplace' => $request->workplace,
        'payment_method' => $request->payment_method
    ];

    Storage::put('users.json', json_encode($users, JSON_PRETTY_PRINT));

    return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
});

// Logika Logout
Route::get('/logout', function () {
    session()->forget('user');
    return redirect('/')->with('success', 'Anda telah berhasil logout.');
});

// Halaman SuperAdmin
Route::prefix('superadmin')->group(function () {
    $superadminCheck = function () {
        if (!session()->has('user') || session('user')['role'] !== 'superadmin') {
            abort(redirect('/')->with('error', 'Akses ditolak. Anda bukan superadmin.'));
        }
    };

    Route::get('/dashboard', function () use ($superadminCheck) {
        $superadminCheck();
        $orders = json_decode(Storage::exists('orders.json') ? Storage::get('orders.json') : '[]', true) ?: [];
        $users = json_decode(Storage::exists('users.json') ? Storage::get('users.json') : '[]', true) ?: [];
        $comments = json_decode(Storage::exists('comments.json') ? Storage::get('comments.json') : '[]', true) ?: [];

        return view('superadmin.dashboard', compact('orders', 'users', 'comments'));
    });

    Route::get('/pesanan', function () use ($superadminCheck) {
        $superadminCheck();
        $orders = json_decode(Storage::exists('orders.json') ? Storage::get('orders.json') : '[]', true) ?: [];
        return view('superadmin.pesanan', compact('orders'));
    });

    Route::post('/pesanan/delete', function (Request $request) use ($superadminCheck) {
        $superadminCheck();
        $orders = json_decode(Storage::exists('orders.json') ? Storage::get('orders.json') : '[]', true) ?: [];
        $orders = array_values(array_filter($orders, fn($o) => $o['id'] !== $request->id));
        Storage::put('orders.json', json_encode($orders, JSON_PRETTY_PRINT));
        return back()->with('success', 'Pesanan berhasil dihapus.');
    });

    Route::get('/user', function () use ($superadminCheck) {
        $superadminCheck();
        $users = json_decode(Storage::exists('users.json') ? Storage::get('users.json') : '[]', true) ?: [];
        return view('superadmin.user', compact('users'));
    });

    Route::post('/user/delete', function (Request $request) use ($superadminCheck) {
        $superadminCheck();
        if ($request->username === 'superadmin') return back()->with('error', 'Superadmin tidak bisa dihapus.');
        $users = json_decode(Storage::exists('users.json') ? Storage::get('users.json') : '[]', true) ?: [];
        $users = array_values(array_filter($users, fn($u) => $u['username'] !== $request->username));
        Storage::put('users.json', json_encode($users, JSON_PRETTY_PRINT));
        return back()->with('success', 'User berhasil dihapus.');
    });

    Route::get('/komentar', function () use ($superadminCheck) {
        $superadminCheck();
        $comments = json_decode(Storage::exists('comments.json') ? Storage::get('comments.json') : '[]', true) ?: [];
        return view('superadmin.komentar', compact('comments'));
    });

    Route::post('/komentar/delete', function (Request $request) use ($superadminCheck) {
        $superadminCheck();
        $comments = json_decode(Storage::exists('comments.json') ? Storage::get('comments.json') : '[]', true) ?: [];
        
        if ($request->type === 'main') {
            $comments = array_values(array_filter($comments, fn($c) => $c['id'] !== $request->id));
        } else if ($request->type === 'reply') {
            foreach ($comments as &$c) {
                if (isset($c['replies'])) {
                    $c['replies'] = array_values(array_filter($c['replies'], fn($r) => $r['id'] !== $request->id));
                }
            }
        }

        Storage::put('comments.json', json_encode($comments, JSON_PRETTY_PRINT));
        return back()->with('success', 'Komentar berhasil dihapus.');
    });
});
