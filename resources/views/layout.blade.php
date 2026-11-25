<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'The Vault')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DotGothic16&family=Press+Start+2P&display=swap" rel="stylesheet">

    <style>
        :root {
            --c: #EFE8DD;   /* latar utama */
            --t: #76ABAE;   /* teal */
            --i: #303841;   /* abu gelap */
            --o: #FF5722;   /* oranye */
            --p: #F6F1E8;   /* krem terang untuk kotak */
            --k: #111;      /* border hitam judul */
            --font-title: "Press Start 2P", monospace;
            --font-body: "DotGothic16", "Courier New", monospace;
        }
        * { box-sizing: border-box; }
        body { margin: 0; background: var(--c); color: var(--i); font: 18px/1.7 var(--font-body); }
        button { font: inherit; color: inherit; }
        svg text { font-family: var(--font-title); }

        .ttl { font-family: var(--font-title); color: var(--o); font-weight: 700; line-height: 1.3; margin: 0;
               -webkit-text-stroke: 7px var(--k); paint-order: stroke fill; }
        .box { border: 3px solid var(--i); background: var(--p); padding: 16px; }
        .box p { margin: 0 0 12px; }
        .box p:last-child { margin: 0; }
        .btn { font-family: var(--font-body); font-size: 18px; font-weight: 700; border: 3px solid var(--i);
               box-shadow: 3px 3px 0 var(--i); background: var(--c); padding: 8px 14px; cursor: pointer; text-decoration: none; color: var(--i); display: inline-block; }
        .btn.p { background: var(--o); }
        .btn:active { transform: translate(2px, 2px); box-shadow: 1px 1px 0 var(--i); }
        .hl { background: var(--t); padding: 1px 5px; }
        .st { font-size: 10px; font-weight: 700; fill: var(--o); text-anchor: middle; }
        .blink { animation: bl 1.2s steps(1) infinite; }
        @keyframes bl { 0%, 60% { opacity: 1; } 61%, 100% { opacity: .15; } }
        @media (prefers-reduced-motion: reduce) { .blink { animation: none; } }
    </style>
    @stack('styles')
</head>
<body>

    {{-- Brankas piksel: dipakai ulang di beberapa halaman lewat <use href="#safe"> --}}
    <svg width="0" height="0" style="position:absolute" aria-hidden="true">
        <defs>
            <symbol id="safe" viewBox="0 0 200 244" shape-rendering="crispEdges">
                <rect x="20" y="232" width="160" height="8" fill="#5E8F92"/>
                <rect x="10" y="10" width="180" height="210" fill="#6B7280"/>
                <rect x="14" y="14" width="172" height="202" fill="#C9CDD2"/>
                <rect x="22" y="22" width="156" height="186" fill="#AEB4BB"/>
                <rect x="28" y="28" width="144" height="174" fill="#D7DADF"/>
                <rect x="28" y="28" width="144" height="4" fill="#EEF0F2"/>
                <rect x="28" y="28" width="4" height="174" fill="#EEF0F2"/>
                <rect x="168" y="28" width="4" height="174" fill="#9AA0A8"/>
                <rect x="28" y="198" width="144" height="4" fill="#9AA0A8"/>
                <rect x="34" y="34" width="6" height="6" fill="#6B7280"/>
                <rect x="160" y="34" width="6" height="6" fill="#6B7280"/>
                <rect x="34" y="190" width="6" height="6" fill="#6B7280"/>
                <rect x="160" y="190" width="6" height="6" fill="#6B7280"/>
                <rect x="4" y="52" width="10" height="26" fill="#8A9099"/>
                <rect x="4" y="152" width="10" height="26" fill="#8A9099"/>
                <rect x="40" y="96" width="30" height="8" fill="#6B7280"/>
                <rect x="40" y="96" width="8" height="40" fill="#6B7280"/>
                <rect x="40" y="128" width="30" height="8" fill="#6B7280"/>
                <rect x="100" y="44" width="68" height="136" fill="#262C33"/>
                <rect x="100" y="44" width="68" height="136" fill="none" stroke="#303841" stroke-width="2"/>
                <rect x="106" y="50" width="56" height="28" fill="#303841" stroke="#EFE8DD" stroke-width="2"/>
                @foreach (['1','2','3','4','5','6','7','8','9','*','0','#'] as $i => $d)
                    @php($x = 106 + ($i % 3) * 18)
                    @php($y = 88 + intdiv($i, 3) * 22)
                    <rect x="{{ $x }}" y="{{ $y }}" width="16" height="18" fill="#EFE8DD"/>
                    <text x="{{ $x + 8 }}" y="{{ $y + 13 }}" text-anchor="middle" font-size="9" font-weight="700" fill="#303841">{{ $d }}</text>
                @endforeach
                <rect x="22" y="220" width="30" height="10" fill="#6B7280"/>
                <rect x="148" y="220" width="30" height="10" fill="#6B7280"/>
            </symbol>
        </defs>
    </svg>

    @yield('content')

    @stack('scripts')
</body>
</html>