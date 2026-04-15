 @extends('layouts.app')
 @section('title', 'Super Admin - Dashboard')

 @push('styles')
     <style>
         .sa-section {
             padding: 4rem 5%;
             background: var(--bg);
             min-height: 80vh;
         }

         .sa-stats {
             display: grid;
             grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
             gap: 1.5rem;
             margin-bottom: 2rem;
         }

         .sa-stat-card {
             background: #fff;
             border-radius: 16px;
             padding: 2rem;
             text-align: center;
             box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
             border: 1px solid var(--border);
         }

         .sa-stat-card h3 {
             font-size: 3rem;
             color: var(--primary);
             margin-bottom: 0.5rem;
         }

         .sa-stat-card p {
             color: var(--text-muted);
             font-weight: 600;
             text-transform: uppercase;
             font-size: 0.85rem;
             letter-spacing: 0.5px;
         }
     </style>
 @endpush

 @section('content')
     <section class="sa-section">
         <div style="margin-bottom: 2rem;">
             <h2 style="font-size: 2rem; color: var(--text-main);">Super Admin Dashboard</h2>
             <p style="color: var(--text-muted);">Overview sistem dan rekap data.</p>
         </div>

         <div class="sa-stats">
             <div class="sa-stat-card">
                 <h3>{{ count($users) }}</h3>
                 <p>Total User</p>
             </div>
             <div class="sa-stat-card">
                 <h3>{{ count($orders) }}</h3>
                 <p>Total Pesanan</p>
             </div>
             <div class="sa-stat-card">
                 @php
                     $totalComments = count($comments);
                     foreach ($comments as $c) {
                         $totalComments += count($c['replies'] ?? []);
                     }
                 @endphp
                 <h3>{{ $totalComments }}</h3>
                 <p>Total Komentar</p>
             </div>
         </div>
     </section>
 @endsection
