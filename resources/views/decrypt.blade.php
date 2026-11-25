@extends('layout')

@section('title', 'Surat - The Vault')

@push('styles')
    <style>
        .hud { position: sticky; top: 0; z-index: 5; height: 56px; background: var(--i); color: var(--c); padding: 0 20px;
               display: flex; justify-content: space-between; align-items: center; }
        .hud a { font-family: var(--font-title); font-size: 12px; color: var(--c); text-decoration: none; }
        .locks { display: flex; gap: 8px; }

        .stage { min-height: calc(100vh - 56px); padding: 32px 24px; max-width: 820px; margin: 0 auto;
                 display: flex; flex-direction: column; justify-content: center; scroll-margin-top: 56px; }
        .stage + .stage { border-top: 3px dashed #8A9099; }
        .lab { font-family: var(--font-title); font-size: 10px; color: var(--o); margin-bottom: 10px; }
        .stage h2 { font-size: 26px; margin: 0 0 16px; line-height: 1.4; }
        .info { margin-bottom: 14px; }
        .chips { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px; }
        .chip { border: 3px solid var(--i); background: var(--p); padding: 2px 12px; font-size: 17px; }

        /* surat */
        .letter { background: var(--p); border: 3px solid var(--i); box-shadow: 5px 5px 0 var(--t); padding: 14px 18px; max-width: 520px; margin-bottom: 24px; }
        .kop { font-family: var(--font-title); font-size: 9px; color: var(--o); }
        .jdl { font-family: var(--font-title); font-size: clamp(14px, 2.4vw, 20px); margin: 12px 0; word-break: break-all; letter-spacing: 2px; }
        .ln { height: 6px; background: #D9D2C3; margin: 7px 0; }
        .ln.s { width: 60%; }
        .kn { margin-top: 10px; font-size: 18px; }

        .grid { display: grid; grid-template-columns: repeat(5, 42px); gap: 3px; width: max-content; }
        .cell, .grid input { width: 42px; height: 42px; border: 3px solid var(--i); background: var(--p); text-align: center;
                             font: 22px var(--font-body); text-transform: uppercase; padding: 0;
                             display: flex; align-items: center; justify-content: center; }
        .cell.h { background: var(--t); }
        input:focus { outline: 3px solid var(--o); outline-offset: 0; }
        .row3 { display: flex; gap: 32px; flex-wrap: wrap; align-items: flex-start; }
        .pr { display: flex; align-items: center; gap: 8px; padding: 2px 8px; font-size: 24px; }
        .pr.on { background: var(--t); }
        .pr input { width: 38px; height: 38px; border: 3px solid var(--i); background: var(--p); text-align: center;
                    font: 20px var(--font-body); text-transform: uppercase; padding: 0; }
        .inp { border: 3px solid var(--i); background: var(--p); padding: 10px 14px; font: 20px var(--font-body);
               width: 100%; max-width: 460px; text-transform: uppercase; }
        .opts { display: grid; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); gap: 12px; max-width: 520px; }
        .opts .btn { text-align: center; }

        .msg { margin: 16px 0 12px; font-size: 18px; }
        .msg:empty { display: none; }
        .msg.bad { color: var(--o); border: 3px solid var(--o); padding: 8px 12px; }
        .msg.ok { background: var(--t); padding: 8px 12px; }
        .btns { display: flex; gap: 12px; flex-wrap: wrap; }
        .hint { font-size: 18px; margin-top: 14px; }
        .stage.done input { pointer-events: none; opacity: .75; }

        #modal { position: fixed; inset: 0; background: rgba(48, 56, 65, .78); display: none; align-items: center; justify-content: center; padding: 16px; z-index: 10; }
        #modal.on { display: flex; }
        .mbox { max-width: 560px; max-height: 90vh; overflow: auto; background: var(--c); border: 4px solid var(--i); box-shadow: 6px 6px 0 var(--i); padding: 22px; }
        .mbox h3 { margin: 0 0 14px; font-family: var(--font-title); font-size: 12px; color: var(--o); font-weight: 400; }
        .mbox p { margin: 0 0 12px; }

        .end { text-align: center; align-items: center; }
        .end .ttl { font-size: clamp(24px, 4vw, 34px); margin-bottom: 20px; }
        .end .btns { justify-content: center; }
        .btn svg { vertical-align: -3px; margin-right: 8px; }
    </style>
@endpush

@section('content')
    <svg width="0" height="0" style="position:absolute" aria-hidden="true">
        <defs>
            <symbol id="lc" viewBox="0 0 16 16" shape-rendering="crispEdges"><rect x="5" y="1" width="6" height="2" fill="currentColor"/><rect x="4" y="3" width="2" height="4" fill="currentColor"/><rect x="10" y="3" width="2" height="4" fill="currentColor"/><rect x="2" y="7" width="12" height="8" fill="currentColor"/><rect x="7" y="10" width="2" height="3" fill="#303841"/></symbol>
            <symbol id="lo" viewBox="0 0 16 16" shape-rendering="crispEdges"><rect x="5" y="0" width="6" height="2" fill="currentColor"/><rect x="4" y="2" width="2" height="5" fill="currentColor"/><rect x="2" y="7" width="12" height="8" fill="currentColor"/><rect x="7" y="10" width="2" height="3" fill="#303841"/></symbol>
        </defs>
    </svg>

    <header class="hud">
        <a href="{{ url('/') }}">The Vault</a>
        <span class="locks" id="locks"></span>
    </header>

    <main id="stages" data-home="{{ url('/') }}"></main>

    <div id="modal">
        <div class="mbox">
            <h3>BUKU ATURAN</h3>
            <p>Membaca sandi berarti membalik prosesnya. Tiap pasangan huruf punya tiga kemungkinan:</p>
            <p><span class="hl">Sebaris:</span> ganti tiap huruf dengan huruf di sebelah kirinya. Dari ujung kiri, kembali ke kolom paling kanan pada baris yang sama.</p>
            <p><span class="hl">Sekolom:</span> ganti tiap huruf dengan huruf di atasnya. Dari ujung atas, kembali ke baris paling bawah pada kolom yang sama.</p>
            <p><span class="hl">Persegi panjang:</span> anggap kedua huruf sebagai sudut persegi panjang. Tiap huruf diganti huruf di sudut lain pada barisnya sendiri.</p>
            <button class="btn p" data-close>TUTUP</button>
        </div>
    </div>
@endsection

@push('scripts')
    @verbatim
    <script>
        /* ===== DATA SURAT: ganti sesuai kebutuhan kelompok =====
           Kunci 5-7 huruf, judul surat 1 kata, tanpa huruf J. */
        const KEYS   = ['CIPHER', 'ENIGMA', 'SECRET', 'PUZZLE', 'DECODE',
                        'RIDDLE', 'LOCKER', 'CRYPTIC', 'HIDDEN', 'VAULTS'];
        const TITLES = ['GALAXIES', 'NEBULAE', 'PLANETS', 'ASTEROID', 'UNIVERSE',
                        'STARDUST', 'ECLIPSE', 'COSMOS', 'SUPERNOVA', 'CONSTELLATION'];

        /* ===== Playfair ===== */
        const matrix = k => [...new Set((k + 'ABCDEFGHIKLMNOPQRSTUVWXYZ').replace(/J/g, 'I'))].join('');

        function digraphs(w) {
            w = w.replace(/J/g, 'I');
            const r = [];
            for (let i = 0; i < w.length;) {
                const a = w[i], b = w[i + 1];
                if (!b || a === b) { r.push(a + 'X'); i++; } else { r.push(a + b); i += 2; }
            }
            return r;
        }

        // dir = +1 untuk enkripsi (kanan/bawah), dir = 4 untuk dekripsi (kiri/atas)
        function shift(p, m, dir) {
            const [a, b] = [...p].map(c => m.indexOf(c));
            const ra = a / 5 | 0, ca = a % 5, rb = b / 5 | 0, cb = b % 5;
            if (ra === rb) return m[ra * 5 + (ca + dir) % 5] + m[rb * 5 + (cb + dir) % 5];
            if (ca === cb) return m[((ra + dir) % 5) * 5 + ca] + m[((rb + dir) % 5) * 5 + cb];
            return m[ra * 5 + cb] + m[rb * 5 + ca];
        }

        function relation(p) {
            const [a, b] = [...p].map(c => G.m.indexOf(c));
            return (a / 5 | 0) === (b / 5 | 0) ? 'sebaris' : a % 5 === b % 5 ? 'sekolom' : 'persegi';
        }

        /* ===== Util ===== */
        let G;
        const $ = s => document.querySelector(s);
        const pick = a => a[Math.random() * a.length | 0];
        const shuffle = a => a.map(x => [Math.random(), x]).sort((p, q) => p[0] - q[0]).map(p => p[1]);
        const val = el => el.value.toUpperCase().replace(/J/g, 'I');

        function setHud(n) {
            $('#locks').innerHTML = [1, 2, 3, 4].map(i => {
                const c = i < n ? ['lo', '#76ABAE'] : i === n ? ['lc', '#FF5722'] : ['lc', '#6B7280'];
                return `<svg width="24" height="24" style="color:${c[1]}"><use href="#${c[0]}"/></svg>`;
            }).join('');
        }

        /* ===== Game ===== */
        const TITLES_UI = ['', 'Susun matriks 5×5', 'Pecah teks sandi menjadi pasangan huruf', 'Dekripsi tiap pasangan', 'Pilih judul surat'];

        function newGame() {
            let w;
            do { w = pick(TITLES); } while (G && w === G.word);
            const key = pick(KEYS), m = matrix(key), plain = digraphs(w);
            const cipher = plain.map(p => shift(p, m, 1));
            const options = shuffle([w, ...shuffle(TITLES.filter(t => t !== w)).slice(0, 3)]);
            G = { key, word: w, m, plain, cipher, options, bad: {}, sel: null };
            $('#stages').innerHTML = '';
            scrollTo(0, 0);
            addStage(1);
        }

        const letter = () => `<div class="letter"><div class="kop">SURAT TERSEGEL</div>
            <div class="jdl">${G.cipher.join('')}</div><div class="ln"></div><div class="ln s"></div>
            <div class="kn">KUNCI: ${G.key}</div></div>`;

        function body(n) {
            if (n === 1) return `<div class="info">Isi satu huruf per kotak. Huruf I dan J dianggap sama.</div>
                <div class="grid">${'<input class="c" maxlength="1" autocomplete="off">'.repeat(25)}</div>`;
            if (n === 2) return `<div class="info">Pecah judul surat menjadi pasangan huruf, pisahkan dengan spasi.</div>
                <input class="inp" id="i2" autocomplete="off" placeholder="ketik di sini...">`;
            if (n === 3) return `<div class="row3">
                <div class="grid" id="g3">${[...G.m].map(c => `<div class="cell">${c}</div>`).join('')}</div>
                <div>${G.cipher.map((p, i) => `<div class="pr" data-i="${i}">${p}<input class="c" maxlength="1" autocomplete="off"><input class="c" maxlength="1" autocomplete="off"></div>`).join('')}</div>
                </div><div class="hint" id="h3"></div>`;
            return `<div class="info">Hasil dekripsimu (huruf X bisa jadi hanya huruf tambahan):</div>
                <div class="chips">${G.plain.map(p => `<span class="chip" style="background:var(--t)">${p}</span>`).join('')}</div>
                <div class="info">Apa judul surat ini?</div>
                <div class="opts">${G.options.map(o => `<button class="btn" data-opt="${o}">${o}</button>`).join('')}</div>`;
        }

        function addStage(n) {
            const s = document.createElement('section');
            s.className = 'stage';
            s.id = 's' + n;
            s.innerHTML = `<div class="lab">TAHAP ${n} / 4</div><h2>${TITLES_UI[n]}</h2>${letter()}
                ${body(n)}<div class="msg" id="m${n}"></div>
                ${n < 4 ? `<div class="btns"><button class="btn p" data-ck="${n}">PERIKSA</button>${n === 3
                    ? '<button class="btn" data-book>BUKU ATURAN</button><button class="btn" id="hb" data-hint style="display:none">PETUNJUK</button>' : ''}</div>` : ''}`;
            $('#stages').appendChild(s);
            setHud(n);
            s.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        function pass(n) {
            const s = $('#s' + n), m = $('#m' + n);
            s.classList.add('done');
            s.querySelectorAll('input,button').forEach(x => x.disabled = true);
            m.className = 'msg ok';
            m.textContent = 'Tepat!';
            setTimeout(() => n < 4 ? addStage(n + 1) : summary(), 700);
        }

        function fail(n) {
            G.bad[n] = (G.bad[n] || 0) + 1;
            const m = $('#m' + n);
            m.className = 'msg bad';
            m.textContent = 'Belum tepat, coba lagi';
            if (n === 3 && G.bad[3] >= 3) $('#hb').style.display = '';
        }

        function check(n) {
            const s = $('#s' + n);
            let ok = false;
            if (n === 1) ok = [...s.querySelectorAll('input.c')].map(val).join('') === G.m;
            if (n === 2) ok = val($('#i2')).replace(/[^A-Z ]/g, ' ').trim().split(/\s+/).join(' ') === G.cipher.join(' ');
            if (n === 3) ok = [...s.querySelectorAll('.pr')].every((r, i) => [...r.querySelectorAll('input')].map(val).join('') === G.plain[i]);
            ok ? pass(n) : fail(n);
        }

        function sel(i) {
            G.sel = i;
            document.querySelectorAll('.pr').forEach(r => r.classList.toggle('on', +r.dataset.i === i));
            const p = G.cipher[i];
            document.querySelectorAll('#g3 .cell').forEach(c => c.classList.toggle('h', p.includes(c.textContent)));
        }

        function hint() {
            const h = $('#h3');
            if (G.sel === null) { h.textContent = 'Pilih satu pasangan dulu (klik kotak jawabannya).'; return; }
            const p = G.cipher[G.sel];
            h.textContent = `Pasangan ${p}: kedua huruf ` + {
                sebaris: 'berada di baris yang sama.',
                sekolom: 'berada di kolom yang sama.',
                persegi: 'membentuk persegi panjang.'
            }[relation(p)];
        }

        function summary() {
            setHud(5);
            const home = $('#stages').dataset.home;
            const s = document.createElement('section');
            s.className = 'stage end';
            s.innerHTML = `<h2 class="ttl">SURAT TERBACA</h2>
                <div class="letter"><div class="kop">JUDUL SURAT</div><div class="jdl">${G.word}</div></div>
                <div class="box" style="max-width:520px;margin:6px 0 18px">Selamat, kamu telah mengenkripsi dan mendekripsi pesan menggunakan <span class="hl">Playfair Cipher</span>.</div>
                <div class="btns">
                    <button class="btn p" data-again>&#9654; MAIN LAGI</button>
                    <a class="btn" href="${home}" aria-label="Kembali ke halaman awal">
                        <svg width="20" height="20" viewBox="0 0 16 16" shape-rendering="crispEdges" fill="currentColor" aria-hidden="true">
                            <rect x="7" y="1" width="2" height="2"/><rect x="5" y="3" width="6" height="2"/>
                            <rect x="3" y="5" width="10" height="2"/><rect x="1" y="7" width="14" height="2"/>
                            <rect x="3" y="9" width="10" height="6"/><rect x="7" y="11" width="2" height="4" fill="#EFE8DD"/>
                        </svg>HOME
                    </a>
                </div>`;
            $('#stages').appendChild(s);
            s.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        document.addEventListener('click', e => {
            const t = e.target;
            const ck = t.closest('[data-ck]');
            if (ck) check(+ck.dataset.ck);
            const op = t.closest('[data-opt]');
            if (op) op.dataset.opt === G.word ? pass(4) : fail(4);
            if (t.closest('[data-book]')) $('#modal').classList.add('on');
            if (t.closest('[data-close]') || t.id === 'modal') $('#modal').classList.remove('on');
            if (t.closest('[data-hint]')) hint();
            if (t.closest('[data-again]')) newGame();
        });

        document.addEventListener('focusin', e => {
            const r = e.target.closest('.pr');
            if (r) sel(+r.dataset.i);
        });

        document.addEventListener('input', e => {
            const t = e.target;
            if (t.classList.contains('c') && t.value) {
                const a = [...t.closest('.stage').querySelectorAll('input.c')];
                const nx = a[a.indexOf(t) + 1];
                if (nx) nx.focus();
            }
        });

        newGame();
    </script>
    @endverbatim
@endpush