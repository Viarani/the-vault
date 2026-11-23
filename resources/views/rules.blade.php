@extends('layout')

@section('title', 'Cara Bermain - The Vault')

@push('styles')
    <style>
        .r2 { position: relative; overflow: hidden; min-height: 100vh; padding: 36px 40px 0; display: flex; flex-direction: column; }
        .r2 .ttl { font-size: clamp(28px, 4.5vw, 46px); }
        .sub { margin: 12px 0 0; font-size: 18px; }

        .content { flex: 1; display: grid; grid-template-columns: 1.05fr 1fr; gap: 40px; margin-top: 28px; }
        .col-left, .col-right { display: flex; flex-direction: column; gap: 18px; }

        .statement { font-size: clamp(22px, 2.6vw, 30px); line-height: 1.6; font-weight: 500; }
        .crop { flex: 1; min-height: 300px; overflow: hidden; }
        .crop svg { width: min(100%, 540px); display: block; }

        .card { position: relative; }
        .card h3 { margin: 0 0 8px; font-family: var(--font-title); font-size: 10px; line-height: 1.8; color: var(--o); font-weight: 400; }
        .card p { font-size: 18px; }

        .demo { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; margin-top: 12px; }
        .row { display: flex; gap: 3px; }
        .cell { width: 38px; height: 38px; border: 3px solid var(--i); background: var(--p); display: flex; align-items: center;
                justify-content: center; font-weight: 700; font-size: 20px; }
        .cell.h { background: var(--t); }
        .cell.r { background: var(--o); }
        .arrow { font-family: var(--font-title); font-size: 14px; }

        .bar { margin-top: auto; margin-bottom: 32px; background: var(--i); color: var(--c); padding: 14px 18px;
               display: flex; align-items: center; justify-content: space-between; gap: 18px; flex-wrap: wrap; box-shadow: 5px 5px 0 var(--t); }
        .bar span { font-size: 20px; font-weight: 500; }

        .sp { position: absolute; display: block; }

        @media (max-width: 820px) {
            .r2 { padding: 24px 18px 0; }
            .content { grid-template-columns: 1fr; gap: 24px; }
            .crop { flex: none; height: 300px; }
            .crop svg { margin: 0 auto; }
            .bar { margin-top: 0; }
        }
    </style>
@endpush

@section('content')
    <main class="r2">
        <svg class="sp blink" style="right:48px;top:36px" width="16" height="16" viewBox="0 0 7 7" shape-rendering="crispEdges" aria-hidden="true"><rect x="3" y="0" width="1" height="7" fill="#76ABAE"/><rect x="0" y="3" width="7" height="1" fill="#76ABAE"/></svg>
        <svg class="sp" style="right:120px;top:90px" width="10" height="10" viewBox="0 0 7 7" shape-rendering="crispEdges" aria-hidden="true"><rect x="3" y="0" width="1" height="7" fill="#FF5722"/><rect x="0" y="3" width="7" height="1" fill="#FF5722"/></svg>
        <svg class="sp blink" style="left:48%;top:20px" width="10" height="10" viewBox="0 0 7 7" shape-rendering="crispEdges" aria-hidden="true"><rect x="3" y="0" width="1" height="7" fill="#303841"/><rect x="0" y="3" width="7" height="1" fill="#303841"/></svg>

        <header>
            <h1 class="ttl">CARA<br>BERMAIN</h1>
            <p class="sub">Baca sebentar sebelum membuka brankas</p>
        </header>

        <div class="content">
            <section class="col-left">
                <div class="statement">
                    Brankas ini hanya terbuka dengan kode yang <span class="hl">disandikan</span> dari sebuah kata, memakai sebuah <span class="hl">kunci</span>.
                </div>
                <div class="crop">
                    <svg viewBox="0 0 200 244" aria-hidden="true">
                        <use href="#safe"/>
                        <text class="st" x="134" y="69">START</text>
                    </svg>
                </div>
            </section>

            <section class="col-right">
                <article class="box card">
                    <h3>// 01 ALUR PERMAINAN</h3>
                    <p>Kamu akan menyelesaikan <span class="hl">4 tahap</span> berurutan. Tahap berikutnya terbuka setelah jawaban tahap sebelumnya benar.</p>
                </article>

                <article class="box card">
                    <h3>// 02 YANG PERLU KAMU TAHU</h3>
                    <p>Kamu diberi sebuah kata dan sebuah kunci. Sandi dibuat dengan bantuan <span class="hl">matriks</span> yang disusun dari kunci. Huruf I dan J dianggap sama. Bila buntu, buka buku aturan atau minta petunjuk.</p>
                </article>

                <article class="box card">
                    <h3>// 03 CONTOH KECIL</h3>
                    <p>Dua huruf yang berada di baris yang sama, masing-masing diganti huruf di sebelah kanannya.</p>
                    <div class="demo" aria-label="Contoh: MO menjadi ON">
                        <div class="row"><span class="cell h">M</span><span class="cell h">O</span><span class="cell">N</span><span class="cell">A</span><span class="cell">R</span></div>
                        <span class="arrow">&rarr;</span>
                        <div class="row"><span class="cell r">O</span><span class="cell r">N</span></div>
                    </div>
                </article>

                <div class="bar">
                    <span>Are you ready?</span>
                    <a class="btn p" href="{{ url('/main') }}">&#9654; READY!</a>
                </div>
            </section>
        </div>
    </main>
@endsection