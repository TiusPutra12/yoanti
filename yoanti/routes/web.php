<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

if (!function_exists('addNotification')) {
    function addNotification($targetUsername, $type, $title, $message) {
        $notifsContent = Storage::exists('notifications.json') ? Storage::get('notifications.json') : '[]';
        $notifs = json_decode($notifsContent, true);
        if (!is_array($notifs)) $notifs = [];
        
        if ($targetUsername === '@admins') {
            $usersContent = Storage::exists('users.json') ? Storage::get('users.json') : '[]';
            $users = json_decode($usersContent, true);
            if (is_array($users)) {
                foreach ($users as $u) {
                    if (isset($u['role']) && in_array($u['role'], ['admin', 'superadmin'])) {
                        $notifs[] = [
                            'id' => uniqid('notif_'),
                            'username' => $u['username'],
                            'type' => $type,
                            'title' => $title,
                            'message' => $message,
                            'is_read' => false,
                            'created_at' => now()->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i')
                        ];
                    }
                }
            }
        } else {
            $notifs[] = [
                'id' => uniqid('notif_'),
                'username' => $targetUsername,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'is_read' => false,
                'created_at' => now()->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i')
            ];
        }
        
        Storage::put('notifications.json', json_encode($notifs, JSON_PRETTY_PRINT));
    }
}

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

    if (function_exists('addNotification')) {
        addNotification('@admins', 'comment', 'Komentar Baru', session('user')['name'] . ' menambahkan testimoni baru.');
    }

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

    $parentOwner = null;
    foreach ($comments as &$c) {
        if (isset($c['id']) && $c['id'] === $request->parent_id) {
            $parentOwner = $c['username'] ?? null;
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
    
    if (function_exists('addNotification')) {
        addNotification('@admins', 'comment', 'Balasan Komentar', session('user')['name'] . ' membalas sebuah komentar.');
        if ($parentOwner && $parentOwner !== session('user')['username']) {
            addNotification($parentOwner, 'comment', 'Balasan Baru', session('user')['name'] . ' membalas komentar Anda.');
        }
    }

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

    if (function_exists('addNotification')) {
        addNotification('@admins', 'order', 'Permintaan Project Baru', session('user')['name'] . ' membuat permintaan project kustom melalui form pemesanan.');
    }

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

// Halaman Pengaturan Akun
Route::get('/pengaturan-akun', function () {
    if (!session()->has('user')) return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
    return view('pengaturan-akun');
});

// Proses Update Pengaturan Akun
Route::post('/pengaturan-akun/update', function (Request $request) {
    if (!session()->has('user')) return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
    
    $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255',
        'current_password' => 'required|string',
        'new_password' => 'nullable|string|min:6',
        'profession' => 'nullable|string|max:255',
        'skills' => 'nullable|string|max:255',
        'workplace' => 'nullable|string|max:255',
        'payment_method' => 'nullable|string|max:255'
    ]);

    $usersContent = Storage::exists('users.json') ? Storage::get('users.json') : '[]';
    $users = json_decode($usersContent, true);
    if (!is_array($users)) $users = [];

    $currentUser = session('user');
    $userIndex = -1;
    foreach ($users as $index => $u) {
        if ($u['username'] === $currentUser['username']) {
            $userIndex = $index;
            break;
        }
    }

    if ($userIndex === -1) return back()->with('error', 'User tidak ditemukan.');

    // Verifikasi password lama
    if (!Hash::check($request->current_password, $users[$userIndex]['password'])) {
        return back()->with('error', 'Password saat ini salah.');
    }

    // Cek username bentrok
    if ($request->username !== $currentUser['username']) {
        foreach ($users as $u) {
            if ($u['username'] === $request->username) {
                return back()->with('error', 'Username sudah digunakan oleh orang lain.');
            }
        }
    }

    $oldUsername = $currentUser['username'];
    $newUsername = $request->username;
    $newName = $request->name;

    // Update data di users.json
    $users[$userIndex]['name'] = $newName;
    $users[$userIndex]['username'] = $newUsername;
    if ($request->has('profession')) $users[$userIndex]['profession'] = $request->profession;
    if ($request->has('skills')) $users[$userIndex]['skills'] = $request->skills;
    if ($request->has('workplace')) $users[$userIndex]['workplace'] = $request->workplace;
    if ($request->has('payment_method')) $users[$userIndex]['payment_method'] = $request->payment_method;
    
    if ($request->filled('new_password')) {
        $users[$userIndex]['password'] = Hash::make($request->new_password);
    }

    Storage::put('users.json', json_encode($users, JSON_PRETTY_PRINT));

    // Jika username/nama berubah, sinkronisasi cascading
    if ($oldUsername !== $newUsername || $currentUser['name'] !== $newName) {
        // 1. Products
        if (Storage::exists('products.json')) {
            $prods = json_decode(Storage::get('products.json'), true);
            $changed = false;
            if (is_array($prods)) {
                foreach ($prods as &$p) {
                    if (isset($p['username']) && $p['username'] === $oldUsername) {
                        $p['username'] = $newUsername;
                        $p['name'] = $newName;
                        $changed = true;
                    }
                }
                if ($changed) Storage::put('products.json', json_encode($prods, JSON_PRETTY_PRINT));
            }
        }
        
        // 2. Orders
        if (Storage::exists('orders.json')) {
            $ords = json_decode(Storage::get('orders.json'), true);
            $changed = false;
            if (is_array($ords)) {
                foreach ($ords as &$o) {
                    if (isset($o['user_username']) && $o['user_username'] === $oldUsername) {
                        $o['user_username'] = $newUsername;
                        $o['name'] = $newName;
                        $changed = true;
                    }
                    if (isset($o['provider_username']) && $o['provider_username'] === $oldUsername) {
                        $o['provider_username'] = $newUsername;
                        $changed = true;
                    }
                }
                if ($changed) Storage::put('orders.json', json_encode($ords, JSON_PRETTY_PRINT));
            }
        }

        // 3. Comments (recursive)
        if (Storage::exists('comments.json')) {
            $comms = json_decode(Storage::get('comments.json'), true);
            $changed = false;
            if (is_array($comms)) {
                foreach ($comms as &$c) {
                    if (isset($c['username']) && $c['username'] === $oldUsername) {
                        $c['username'] = $newUsername;
                        $c['name'] = $newName;
                        $changed = true;
                    }
                    if (isset($c['replies']) && is_array($c['replies'])) {
                        foreach ($c['replies'] as &$r) {
                            if (isset($r['username']) && $r['username'] === $oldUsername) {
                                $r['username'] = $newUsername;
                                $r['name'] = $newName;
                                $changed = true;
                            }
                        }
                    }
                }
                if ($changed) Storage::put('comments.json', json_encode($comms, JSON_PRETTY_PRINT));
            }
        }

        // 4. Notifications
        if (Storage::exists('notifications.json')) {
            $notifs = json_decode(Storage::get('notifications.json'), true);
            $changed = false;
            if (is_array($notifs)) {
                foreach ($notifs as &$n) {
                    if (isset($n['username']) && $n['username'] === $oldUsername) {
                        $n['username'] = $newUsername;
                        $changed = true;
                    }
                }
                if ($changed) Storage::put('notifications.json', json_encode($notifs, JSON_PRETTY_PRINT));
            }
        }
    }

    // Update Session
    $updatedSession = session('user');
    $updatedSession['name'] = $newName;
    $updatedSession['username'] = $newUsername;
    if ($request->has('profession')) $updatedSession['profession'] = $request->profession;
    if ($request->has('skills')) $updatedSession['skills'] = $request->skills;
    if ($request->has('workplace')) $updatedSession['workplace'] = $request->workplace;
    if ($request->has('payment_method')) $updatedSession['payment_method'] = $request->payment_method;
    session(['user' => $updatedSession]);

    return back()->with('success', 'Pengaturan akun berhasil diperbarui.');
});

// Halaman Admin: Dashboard Permintaan
Route::get('/admin/permintaan', function () {
    if (!session()->has('user') || session('user')['role'] !== 'admin') {
        return redirect('/')->with('error', 'Akses ditolak. Anda bukan admin.');
    }
    
    $ordersContent = Storage::exists('orders.json') ? Storage::get('orders.json') : '[]';
    $orders = json_decode($ordersContent, true);
    if(is_array($orders)) {
        $filteredOrders = array_filter($orders, function($o) {
            return !isset($o['provider_username']);
        });
        $orders = array_reverse($filteredOrders);
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
        
        if (function_exists('addNotification') && isset($order['user_username'])) {
            addNotification($order['user_username'], 'order', 'Pembaruan Pesanan', 'Status pesanan Anda telah diperbarui menjadi: ' . $request->status);
        }

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
                
                if ($user['role'] === 'superadmin') {
                    return redirect('/superadmin/dashboard')->with('success', 'Selamat datang, ' . $user['name'] . '!');
                } else if ($user['role'] === 'job_provider') {
                    return redirect('/penyedia/dashboard')->with('success', 'Selamat datang, ' . $user['name'] . '!');
                }

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

// Rute Notifikasi
Route::post('/notifikasi/read', function () {
    if (!session()->has('user')) return response()->json(['success' => false]);
    
    $notifsContent = Storage::exists('notifications.json') ? Storage::get('notifications.json') : '[]';
    $notifs = json_decode($notifsContent, true);
    if (!is_array($notifs)) $notifs = [];
    
    $updated = false;
    foreach ($notifs as &$n) {
        if ($n['username'] === session('user')['username'] && !$n['is_read']) {
            $n['is_read'] = true;
            $updated = true;
        }
    }
    
    if ($updated) {
        Storage::put('notifications.json', json_encode($notifs, JSON_PRETTY_PRINT));
    }
    return response()->json(['success' => true]);
});

// Pembelian Produk
Route::post('/produk/beli', function (Request $request) {
    if (!session()->has('user') || session('user')['role'] !== 'job_seeker') {
        return back()->with('error', 'Hanya pencari jasa yang dapat membeli produk ini.');
    }

    $request->validate([
        'product_id' => 'required',
        'product_title' => 'required',
        'provider_username' => 'required',
        'order_notes' => 'nullable|string'
    ]);

    $ordersContent = Storage::exists('orders.json') ? Storage::get('orders.json') : '[]';
    $orders = json_decode($ordersContent, true);
    if (!is_array($orders)) $orders = [];

    $newOrder = [
        'id' => 'ORD-PROD-' . strtoupper(bin2hex(random_bytes(3))),
        'user_username' => session('user')['username'],
        'provider_username' => $request->provider_username, 
        'product_id' => $request->product_id,
        'name' => session('user')['name'],
        'company' => '-',
        'address' => '-',
        'programType' => $request->product_title,
        'budget' => $request->product_price ?? '-',
        'description' => 'Membeli produk portofolio: ' . $request->product_title . '. Catatan tambahan: ' . ($request->order_notes ?: '-'),
        'status' => 'pending', 
        'created_at' => now()->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i'),
    ];

    $orders[] = $newOrder;
    Storage::put('orders.json', json_encode($orders, JSON_PRETTY_PRINT));

    // Notifikasi
    if (function_exists('addNotification')) {
        addNotification(session('user')['username'], 'order', 'Pesanan Dibuat', 'Pesanan Anda untuk "' . $request->product_title . '" sedang diproses.');
        addNotification($request->provider_username, 'order', 'Pesanan Baru', session('user')['name'] . ' memesan produk "' . $request->product_title . '".');
        addNotification('@admins', 'order', 'Pesanan Portofolio Baru', session('user')['name'] . ' memesan produk dari ' . $request->provider_username);
    }

    return back()->with('success', 'Pesanan berhasil dibuat! Penyedia jasa akan segera menghubungi Anda.');
});

// Halaman Produk (Katalog portofolio)
Route::get('/produk', function () {
    $productsContent = Storage::exists('products.json') ? Storage::get('products.json') : '[]';
    $products = json_decode($productsContent, true);
    if (!is_array($products)) $products = [];
    $products = array_reverse($products);
    
    return view('produk', compact('products'));
});

// Grup Rute Penyedia Jasa
Route::prefix('penyedia')->group(function () {
    $providerCheck = function () {
        if (!session()->has('user') || session('user')['role'] !== 'job_provider') {
            abort(redirect('/')->with('error', 'Akses ditolak. Anda bukan penyedia jasa.'));
        }
    };

    Route::get('/dashboard', function () use ($providerCheck) {
        $providerCheck();
        $productsContent = Storage::exists('products.json') ? Storage::get('products.json') : '[]';
        $allProducts = json_decode($productsContent, true);
        if (!is_array($allProducts)) $allProducts = [];
        
        $myProducts = array_filter($allProducts, function($p) {
            return $p['username'] === session('user')['username'];
        });
        $myProducts = array_reverse($myProducts);

        return view('penyedia.dashboard', compact('myProducts'));
    });

    Route::get('/produk/create', function () use ($providerCheck) {
        $providerCheck();
        return view('penyedia.produk_create');
    });

    Route::post('/produk/store', function (Request $request) use ($providerCheck) {
        $providerCheck();
        
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('img'), $imageName);

        $productsContent = Storage::exists('products.json') ? Storage::get('products.json') : '[]';
        $products = json_decode($productsContent, true);
        if (!is_array($products)) $products = [];

        $products[] = [
            'id' => uniqid('prod_'),
            'username' => session('user')['username'],
            'name' => session('user')['name'],
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'image' => 'img/' . $imageName,
            'created_at' => now()->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i')
        ];

        Storage::put('products.json', json_encode($products, JSON_PRETTY_PRINT));

        return redirect('/penyedia/dashboard')->with('success', 'Produk berhasil ditambahkan!');
    });

    Route::post('/produk/delete', function (Request $request) use ($providerCheck) {
        $providerCheck();
        
        $productsContent = Storage::exists('products.json') ? Storage::get('products.json') : '[]';
        $products = json_decode($productsContent, true);
        if (!is_array($products)) $products = [];

        $newProducts = [];
        $deleted = false;
        foreach ($products as $p) {
            if ($p['id'] === $request->id && $p['username'] === session('user')['username']) {
                $deleted = true;
                // hapus gambar jika bukan default atau kosong
                if(isset($p['image']) && strpos($p['image'], 'img/') === 0) {
                    $imagePath = public_path($p['image']);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
            } else {
                $newProducts[] = $p;
            }
        }

        if ($deleted) {
            Storage::put('products.json', json_encode(array_values($newProducts), JSON_PRETTY_PRINT));
            return back()->with('success', 'Produk berhasil dihapus!');
        }
        
        return back()->with('error', 'Produk gagal dihapus atau bukan milik Anda.');
    });

    Route::get('/pesanan', function () use ($providerCheck) {
        $providerCheck();
        $ordersContent = Storage::exists('orders.json') ? Storage::get('orders.json') : '[]';
        $orders = json_decode($ordersContent, true);
        if (!is_array($orders)) $orders = [];
        
        $myOrders = array_filter($orders, function($o) {
            return isset($o['provider_username']) && $o['provider_username'] === session('user')['username'];
        });
        $myOrders = array_reverse($myOrders);

        return view('penyedia.pesanan', compact('myOrders'));
    });

    Route::post('/pesanan/status', function (Request $request) use ($providerCheck) {
        $providerCheck();
        
        $request->validate([
            'order_id' => 'required',
            'status' => 'required|in:Diterima,Ditolak'
        ]);

        $ordersContent = Storage::exists('orders.json') ? Storage::get('orders.json') : '[]';
        $orders = json_decode($ordersContent, true);
        if (!is_array($orders)) $orders = [];

        $updated = false;
        $orderInfo = null;
        foreach ($orders as &$o) {
            if ($o['id'] === $request->order_id && isset($o['provider_username']) && $o['provider_username'] === session('user')['username']) {
                $o['status'] = $request->status;
                $orderInfo = $o;
                $updated = true;
                break;
            }
        }

        if ($updated) {
            Storage::put('orders.json', json_encode($orders, JSON_PRETTY_PRINT));
            
            if (function_exists('addNotification') && $orderInfo) {
                addNotification($orderInfo['user_username'], 'order', 'Status Pesanan ' . $request->status, 'Penyedia Jasa telah ' . strtolower($request->status) . ' pesanan Anda untuk produk "' . $orderInfo['programType'] . '".');
                addNotification('@admins', 'order', 'Pesanan Portofolio ' . $request->status, 'Penyedia Jasa (' . session('user')['username'] . ') telah ' . strtolower($request->status) . ' pesanan dari ' . $orderInfo['user_username'] . '.');
            }
            
            return back()->with('success', 'Status pesanan berhasil diperbarui menjadi ' . $request->status);
        }

        return back()->with('error', 'Pesanan tidak ditemukan atau Anda tidak memiliki akses.');
    });
});
