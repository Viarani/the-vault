@extends('layout')

@section('title', 'The Vault')

@push('styles')
    <style>
        .wrap { display: grid; grid-template-columns: 1fr 1fr; min-height: 100vh; }
        .left { padding: 40px 48px; display: flex; flex-direction: column; justify-content: center; gap: 22px; }
        .right { background: var(--t); border-left: 4px solid var(--i); display: flex; align-items: center; justify-content: center; padding: 24px; }
        .right svg { width: 100%; max-width: 320px; }
        .left .ttl { font-size: clamp(30px, 4.5vw, 52px); }

        .data { background: var(--i); padding: 12px 16px; }
        .data div { display: flex; justify-content: space-between; gap: 12px; color: var(--c);
                    text-transform: uppercase; letter-spacing: .06em; font-size: 15px; line-height: 1.9; }
        .data span:first-child { color: var(--t); }
        .data .locked { color: var(--o); }

        .story { font-size: 19px; }
        .cta { color: var(--o); font-size: 16px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; }

        #start { cursor: pointer; outline: none; }

        @media (max-width: 760px) {
            .wrap { grid-template-columns: 1fr; }
            .left { padding: 28px 18px; }
            .right { border-left: 0; border-top: 4px solid var(--i); }
        }
    </style>
@endpush

@section('content')
    <main class="wrap">
        <section class="left">
            <h1 class="ttl">The Vault</h1>

            <div class="data">
                <div><span>Pemilik</span><span>???</span></div>
                <div><span>Akses terakhir</span><span>[dihapus]</span></div>
                <div><span>Isi</span><span>tidak diketahui</span></div>
                <div><span>Status</span><span class="locked">terkunci</span></div>
            </div>

            <div class="box story">
                <p>Tidak ada yang mengetahui secara pasti apa yang tersimpan di dalam brankas ini. Catatan mengenai pemilik dan akses terakhirnya telah dihapus, sementara seluruh informasi di dalamnya masih terlindungi.</p>
                <p>Satu hal yang pasti: brankas ini tidak akan terbuka tanpa kode yang tepat. Mampukah kamu menemukan cara untuk mengaksesnya?</p>
            </div>

            <div class="cta blink">&#9654; Tekan START di brankas</div>
        </section>

        <section class="right">
            <svg viewBox="0 0 200 244" role="img" aria-label="Brankas dengan layar START">
                <use href="#safe"/>
                <a id="start" href="{{ url('/cara-bermain') }}" aria-label="Start">
                    <rect x="106" y="50" width="56" height="28" fill="transparent"/>
                    <text id="st" class="st blink" x="134" y="69">START</text>
                </a>
            </svg>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        // Saat kembali lewat tombol back, browser memulihkan halaman apa adanya
        // (teks masih "ACCESS"), jadi kembalikan ke START setiap halaman tampil.
        window.addEventListener('pageshow', function () {
            document.getElementById('st').textContent = 'START';
        });

        // Efek singkat "ACCESS" sebelum pindah ke halaman cara bermain.
        document.getElementById('start').addEventListener('click', function (e) {
            e.preventDefault();
            var tujuan = this.getAttribute('href');
            document.getElementById('st').textContent = 'ACCESS';
            setTimeout(function () { window.location.href = tujuan; }, 700);
        });
    </script>
@endpush