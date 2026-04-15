@extends('layouts.app')
@section('title', 'Testimoni')

@push('styles')
    <style>
        .comments-page {
            padding: clamp(2rem, 6vw, 4rem) clamp(1rem, 5%, 2rem);
            background: #F8FAFC;
            min-height: calc(100dvh - var(--nav-height));
        }

        .page-header {
            text-align: center;
            margin-bottom: clamp(2rem, 5vw, 3rem);
        }

        .page-header .badge {
            display: inline-block;
            background: var(--primary-light);
            color: var(--primary);
            padding: 0.3rem 0.85rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 0.75rem;
        }

        .page-header h1 {
            font-size: clamp(1.75rem, 4vw, 2.5rem);
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            color: var(--text-muted);
            font-size: clamp(0.875rem, 2vw, 1rem);
        }

        .comments-wrap {
            max-width: 760px;
            margin: 0 auto;
        }

        /* Comment Form Card */
        .comment-form-card {
            background: #fff;
            padding: clamp(1.25rem, 4vw, 2rem);
            border-radius: 20px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
        }

        .comment-form-card h2 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 1.25rem;
            letter-spacing: -0.01em;
        }

        .form-control {
            width: 100%;
            padding: 0.9rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            background: #F8FAFC;
            color: var(--text-main);
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .form-control::placeholder {
            color: #A0AEC0;
        }

        .user-display {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            background: #F8FAFC;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            margin-bottom: 0.75rem;
        }

        .user-display-avatar {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .user-display-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .admin-notice {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 1.25rem;
            background: #F0FDF4;
            border: 1px solid #BBF7D0;
            border-radius: 12px;
            font-size: 0.875rem;
            color: #16A34A;
            font-weight: 500;
        }

        .guest-cta {
            text-align: center;
            padding: 1.5rem 1rem;
        }

        .guest-cta p {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        /* Comment Card */
        .comment-card {
            background: #fff;
            padding: clamp(1.1rem, 4vw, 1.75rem);
            border-radius: 20px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.25rem;
            transition: box-shadow 0.2s;
        }

        .comment-card:hover {
            box-shadow: var(--shadow-md);
        }

        .comment-header {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            margin-bottom: 1rem;
        }

        .avatar {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .avatar.admin-avatar {
            background: #ECFDF5;
            color: #10B981;
        }

        .comment-meta h4 {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .badge-admin {
            background: #10B981;
            color: #fff;
            font-size: 0.65rem;
            padding: 0.15rem 0.5rem;
            border-radius: 5px;
            font-weight: 700;
            letter-spacing: 0.03em;
        }

        .comment-date {
            font-size: 0.78rem;
            color: #94A3B8;
            margin-top: 0.1rem;
        }

        .comment-body {
            padding: 1rem 1.1rem;
            background: #F8FAFC;
            border-radius: 4px 14px 14px 14px;
            color: var(--text-main);
            line-height: 1.65;
            border: 1px solid var(--border);
            font-size: 0.9rem;
        }

        .reply-btn {
            color: var(--primary);
            font-weight: 700;
            font-size: 0.8rem;
            background: none;
            border: none;
            padding: 0.4rem 0;
            cursor: pointer;
            margin-top: 0.6rem;
            display: flex;
            align-items: center;
            gap: 0.35rem;
            font-family: 'Inter', sans-serif;
            transition: opacity 0.2s;
        }

        .reply-btn:hover {
            opacity: 0.75;
        }

        /* Replies */
        .replies-wrap {
            margin-top: 1.1rem;
            margin-left: clamp(0.5rem, 3vw, 1.25rem);
            padding-left: clamp(0.75rem, 3vw, 1.25rem);
            border-left: 2px solid #E2E8F0;
        }

        .reply-item {
            margin-bottom: 1rem;
        }

        .reply-item .avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            font-size: 0.9rem;
        }

        .reply-item .comment-meta h4 {
            font-size: 0.875rem;
        }

        /* Reply Form */
        .reply-form-wrap {
            display: none;
            margin-top: 0.9rem;
        }

        .reply-form-wrap textarea {
            min-height: 80px;
            resize: none;
            margin-bottom: 0.5rem;
        }

        .btn-reply-submit {
            padding: 0.55rem 1.25rem;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 700;
        }

        /* Empty state */
        .empty-comments {
            text-align: center;
            padding: clamp(3rem, 8vw, 4rem) 1rem;
            color: var(--text-muted);
        }

        .empty-comments svg {
            margin-bottom: 1rem;
            opacity: 0.4;
        }

        .empty-comments p {
            font-size: 0.9rem;
        }

        @media (max-width: 480px) {
            .comment-card {
                border-radius: 16px;
            }

            .form-control {
                font-size: 16px;
                /* Prevent iOS zoom */
            }
        }
    </style>
@endpush

@section('content')
    <div class="comments-page">
        <div class="page-header">
            <span class="badge">Komunitas</span>
            <h1>Testimoni & Diskusi</h1>
            <p>Apa kata mereka yang telah bekerja bersama kami</p>
        </div>

        <div class="comments-wrap">
            <!-- Write Comment -->
            <div class="comment-form-card">
                <h2>💬 Tulis Komentar</h2>
                @if (session()->has('user'))
                    @if (isset(session('user')['role']) && session('user')['role'] === 'admin')
                        <div class="admin-notice">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                            Mode admin: Anda hanya dapat membalas komentar klien.
                        </div>
                    @else
                        <form action="{{ url('/komentar') }}" method="POST">
                            @csrf
                            <div class="user-display">
                                <div class="user-display-avatar">{{ strtoupper(substr(session('user')['name'], 0, 1)) }}
                                </div>
                                <span class="user-display-name">{{ session('user')['name'] }}</span>
                            </div>
                            <textarea name="comment" class="form-control" rows="3"
                                placeholder="Bagikan pengalaman Anda bekerja bersama kami..." required style="margin-bottom: 0.75rem;"></textarea>
                            <button type="submit" class="btn-primary"
                                style="padding: 0.7rem 1.5rem; border-radius: 12px; font-size: 0.9rem;">
                                Kirim Komentar
                            </button>
                        </form>
                    @endif
                @else
                    <div class="guest-cta">
                        <p>Masuk untuk bergabung dalam diskusi dan berbagi pengalaman Anda.</p>
                        <a href="{{ url('/login') }}" class="btn-primary"
                            style="padding: 0.75rem 2rem; border-radius: 12px; font-size: 0.9rem;">
                            Masuk Sekarang
                        </a>
                    </div>
                @endif
            </div>

            <!-- Comments List -->
            @forelse($comments ?? [] as $c)
                <div class="comment-card">
                    <div class="comment-header">
                        <div class="avatar {{ isset($c['role']) && $c['role'] === 'admin' ? 'admin-avatar' : '' }}">
                            {{ strtoupper(substr($c['name'], 0, 1)) }}
                        </div>
                        <div class="comment-meta">
                            <h4>
                                {{ $c['name'] }}
                                @if (isset($c['role']) && $c['role'] === 'admin')
                                    <span class="badge-admin">Admin</span>
                                @endif
                            </h4>
                            <span class="comment-date">{{ $c['created_at'] }}</span>
                        </div>
                    </div>

                    <div class="comment-body">{{ $c['comment'] }}</div>

                    @if (session()->has('user'))
                        <button class="reply-btn" onclick="toggleReply('{{ $c['id'] }}')">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 17 4 12 9 7"></polyline>
                                <path d="M20 18v-2a4 4 0 0 0-4-4H4"></path>
                            </svg>
                            Balas
                        </button>
                        <div class="reply-form-wrap" id="reply-form-{{ $c['id'] }}">
                            <form action="{{ url('/komentar/reply') }}" method="POST">
                                @csrf
                                <input type="hidden" name="parent_id" value="{{ $c['id'] }}">
                                <textarea name="reply_comment" class="form-control" placeholder="Tulis balasan..." required></textarea>
                                <button type="submit" class="btn-primary btn-reply-submit">Kirim Balasan</button>
                            </form>
                        </div>
                    @endif

                    @if (isset($c['replies']) && count($c['replies']) > 0)
                        <div class="replies-wrap">
                            @foreach ($c['replies'] as $r)
                                <div class="reply-item">
                                    <div class="comment-header">
                                        <div
                                            class="avatar {{ isset($r['role']) && $r['role'] === 'admin' ? 'admin-avatar' : '' }}">
                                            {{ strtoupper(substr($r['name'], 0, 1)) }}
                                        </div>
                                        <div class="comment-meta">
                                            <h4>
                                                {{ $r['name'] }}
                                                @if (isset($r['role']) && $r['role'] === 'admin')
                                                    <span class="badge-admin">Admin</span>
                                                @endif
                                            </h4>
                                            <span class="comment-date">{{ $r['created_at'] }}</span>
                                        </div>
                                    </div>
                                    <div class="comment-body" style="background: #fff;">{{ $r['comment'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div class="empty-comments">
                    <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                    <p>Jadilah yang pertama meninggalkan komentar di sini!</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleReply(id) {
            const form = document.getElementById('reply-form-' + id);
            const isVisible = form.style.display === 'block';
            document.querySelectorAll('.reply-form-wrap').forEach(el => el.style.display = 'none');
            if (!isVisible) form.style.display = 'block';
        }
    </script>
@endpush
