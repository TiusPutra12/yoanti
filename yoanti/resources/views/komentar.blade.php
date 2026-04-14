@extends('layouts.app')
@section('title', 'Komentar')

@push('styles')
<style>
    .comments-section {
        padding: 5rem 5%;
        background: var(--bg);
        min-height: 80vh;
    }

    .section-title {
        text-align: center;
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 3.5rem;
        color: var(--text-main);
        letter-spacing: -1px;
    }

    .comments-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .comment-card {
        background: #FFFFFF;
        padding: 2rem;
        border-radius: 24px;
        box-shadow: 0 12px 35px -10px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(226, 232, 240, 0.6);
        margin-bottom: 2rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .comment-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.08);
    }

    .comment-header {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        margin-bottom: 1.25rem;
    }

    .comment-avatar {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.2) 100%);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.25rem;
        box-shadow: inset 0 2px 4px rgba(255, 255, 255, 0.5);
    }
    
    .comment-avatar.admin {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.2) 100%);
        color: #10B981;
    }

    .comment-meta h4 {
        font-size: 1.1rem;
        color: var(--text-main);
        margin-bottom: 0.15rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-weight: 700;
    }

    .badge-admin {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        color: white;
        font-size: 0.7rem;
        padding: 0.2rem 0.5rem;
        border-radius: 6px;
        font-weight: 600;
        box-shadow: 0 2px 10px rgba(16, 185, 129, 0.3);
    }

    .comment-meta span {
        font-size: 0.85rem;
        color: #94A3B8;
    }

    .comment-body {
        background: #F8FAFC;
        padding: 1.25rem 1.5rem;
        border-radius: 0 16px 16px 16px;
        color: var(--text-main);
        line-height: 1.7;
        margin-bottom: 1.25rem;
        font-size: 1rem;
        border: 1px solid #E2E8F0;
    }

    .reply-btn {
        background: none;
        border: none;
        color: var(--primary);
        font-weight: 600;
        cursor: pointer;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.9rem;
        transition: background 0.2s;
        margin-left: -0.5rem;
    }

    .reply-btn:hover { 
        background: rgba(37, 99, 235, 0.05); 
    }

    .replies-container {
        margin-left: 1.5rem;
        margin-top: 1.5rem;
        padding-left: 1.5rem;
        border-left: 2px solid #E2E8F0;
    }

    .reply-card {
        margin-bottom: 1.5rem;
        padding-bottom: 0;
        border-bottom: none;
    }
    .reply-card:last-child {
        margin-bottom: 0;
    }

    .reply-avatar { width: 42px; height: 42px; font-size: 1rem; border-radius: 12px; }

    .reply-card .comment-body {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
    }

    /* Form input for new comment */
    .new-comment, .reply-form-container {
        background: #FFFFFF;
        border-radius: 20px;
    }
    .new-comment {
        padding: 2.5rem;
        box-shadow: 0 12px 35px -10px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(226, 232, 240, 0.6);
        margin-bottom: 3.5rem;
    }
    
    .reply-form-container {
        margin-top: 1rem;
        padding: 1.5rem;
        border: 1px solid var(--border);
        background: #F8FAFC;
        display: none;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
    }

    .form-group { margin-bottom: 1.25rem; }
    .form-control {
        width: 100%; padding: 1rem 1.25rem; border: 1.5px solid var(--border);
        border-radius: 12px; font-size: 1rem; transition: all 0.3s ease;
        background: #FFFFFF; color: var(--text-main);
    }
    textarea.form-control { min-height: 120px; resize: vertical; }
    .form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
</style>
@endpush

@section('content')
    <section class="comments-section">
        <h2 class="section-title">Komentar & Ulasan Klien</h2>
        <div class="comments-container">
            
            <div class="new-comment">
                <h3 style="margin-bottom: 1.5rem; font-size: 1.25rem;">Tinggalkan Komentar</h3>
                
                @if(session()->has('user'))
                    @if(isset(session('user')['role']) && session('user')['role'] === 'admin')
                    <div style="text-align: center; padding: 2rem; border: 1px dashed var(--border); border-radius: 12px; background: #F8FAFC;">
                        <p style="margin-bottom: 0; color: var(--text-muted); font-size: 1.05rem;">Admin hanya dapat membalas komentar klien.</p>
                    </div>
                    @else
                    <form action="{{ url('/komentar') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" value="{{ session('user')['name'] }} ({{ session('user')['role'] ?? 'User' }})" disabled style="background-color: #F1F5F9; border-color: #E2E8F0;">
                        </div>
                        <div class="form-group">
                            <textarea name="comment" class="form-control" placeholder="Tulis komentar atau pertanyaan Anda..." required></textarea>
                        </div>
                        <button type="submit" class="btn-primary" style="width: 100%;">Kirim Komentar</button>
                    </form>
                    @endif
                @else
                <div style="text-align: center; padding: 3rem 2rem; border: 1px dashed var(--border); border-radius: 16px; background: #F8FAFC;">
                    <p style="margin-bottom: 1.5rem; color: var(--text-muted); font-size: 1.05rem;">Anda harus login untuk meninggalkan komentar.</p>
                    <a href="{{ url('/login') }}" class="btn-primary">Login Sekarang</a>
                </div>
                @endif
            </div>

            @forelse($comments ?? [] as $c)
            <div class="comment-card">
                <!-- Parent Comment -->
                <div class="comment-header">
                    <div class="comment-avatar {{ (isset($c['role']) && $c['role']==='admin') ? 'admin' : '' }}">
                        {{ strtoupper(substr($c['name'], 0, 1)) }}
                    </div>
                    <div class="comment-meta">
                        <h4>
                            {{ $c['name'] }}
                            @if(isset($c['role']) && $c['role'] === 'admin')
                                <span class="badge-admin">Admin</span>
                            @endif
                        </h4>
                        <span>{{ $c['created_at'] }}</span>
                    </div>
                </div>
                <div class="comment-body">
                    {{ htmlspecialchars($c['comment']) }}
                </div>
                
                @if(session()->has('user'))
                <button class="reply-btn" onclick="toggleReply('{{ $c['id'] ?? '' }}')">Balas</button>

                <!-- Reply Form -->
                <div class="reply-form-container" id="reply-form-{{ $c['id'] ?? '' }}">
                    <form action="{{ url('/komentar/reply') }}" method="POST">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $c['id'] ?? '' }}">
                        <div class="form-group" style="margin-bottom: 0.5rem;">
                            <textarea name="reply_comment" class="form-control" style="min-height: 80px;" placeholder="Tulis balasan..." required></textarea>
                        </div>
                        <button type="submit" class="btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Kirim Balasan</button>
                    </form>
                </div>
                @endif

                <!-- Replies List -->
                @if(isset($c['replies']) && count($c['replies']) > 0)
                <div class="replies-container">
                    @foreach($c['replies'] as $r)
                    <div class="reply-card">
                        <div class="comment-header" style="margin-bottom: 0.5rem;">
                            <div class="comment-avatar reply-avatar {{ (isset($r['role']) && $r['role']==='admin') ? 'admin' : '' }}">
                                {{ strtoupper(substr($r['name'], 0, 1)) }}
                            </div>
                            <div class="comment-meta">
                                <h4>
                                    {{ $r['name'] }}
                                    @if(isset($r['role']) && $r['role'] === 'admin')
                                        <span class="badge-admin">Admin</span>
                                    @endif
                                </h4>
                                <span>{{ $r['created_at'] }}</span>
                            </div>
                        </div>
                        <div class="comment-body" style="margin-bottom: 0;">
                            {{ htmlspecialchars($r['comment']) }}
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

            </div>
            @empty
            <div style="text-align: center; padding: 3rem; color: var(--text-muted);">
                Belum ada perbincangan. Jadilah yang pertama berkomentar!
            </div>
            @endforelse

        </div>
    </section>

    @push('scripts')
    <script>
        function toggleReply(id) {
            if(!id) return;
            const form = document.getElementById('reply-form-' + id);
            if(form.style.display === 'block') {
                form.style.display = 'none';
            } else {
                form.style.display = 'block';
            }
        }
    </script>
    @endpush
@endsection
