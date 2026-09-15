@php
    $hasSuccess = session('status') || session('success');
    $hasError = session('error') || (isset($errors) && $errors->any());
    $popupType = $hasSuccess ? 'success' : ($hasError ? 'error' : null);

    $popupTitle = '';
    $popupMessage = '';
    $popupList = [];

    if ($hasSuccess) {
        $popupTitle = 'Berhasil Dilakukan!';
        $popupMessage = session('status') ?? session('success');
    } elseif ($hasError) {
        $popupTitle = session('error') ? 'Terjadi Kesalahan!' : 'Periksa Kembali Formulir!';
        if (session('error')) {
            $popupMessage = session('error');
        } elseif (isset($errors) && $errors->any()) {
            $popupMessage = $errors->count() === 1
                ? $errors->first()
                : 'Ditemukan beberapa kesalahan pengisian:';
            $popupList = $errors->count() > 1 ? $errors->all() : [];
        }
    }
@endphp

{{-- ── FIXED 3D POP-UP BACKDROP ── --}}
<div id="popup3dBackdrop"
    class="{{ $popupType ? '' : 'hidden' }} fixed inset-0 z-[9999] flex items-center justify-center p-4"
    style="background: rgba(2,6,23,0.65); backdrop-filter: blur(12px); perspective: 1200px;">

    {{-- 3D Card --}}
    <div id="popup3dCard"
        class="relative w-full max-w-md bg-white rounded-[32px] p-7 sm:p-9 text-center select-none cursor-default"
        style="
            box-shadow: 0 30px 80px -10px rgba(0,0,0,0.4), 0 0 0 1px rgba(255,255,255,0.08), inset 0 1px 0 rgba(255,255,255,0.9);
            transform-style: preserve-3d;
            transform: scale(1) rotateX(0deg) rotateY(0deg);
            transition: transform 0.12s ease-out, opacity 0.25s ease;
         ">

        {{-- Top Edge Highlight --}}
        <div
            class="absolute inset-x-10 top-0 h-px bg-gradient-to-r from-transparent via-white to-transparent pointer-events-none rounded-full">
        </div>

        {{-- Particle Layer --}}
        <div id="popup3dParticles" class="absolute inset-0 overflow-visible pointer-events-none z-0 rounded-[32px]">
        </div>

        {{-- Close Button --}}
        <button id="popup3dCloseBtn"
            class="absolute top-4 right-4 w-9 h-9 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center transition z-20 cursor-pointer"
            style="transform: translateZ(20px);">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- Floating 3D Icon --}}
        <div class="relative z-10 flex justify-center mb-5" style="transform: translateZ(40px);">
            <div id="popup3dIconWrap" class="relative flex items-center justify-center w-20 h-20 rounded-3xl">
                {{-- Glow Aura --}}
                <div id="popup3dGlow" class="absolute -inset-3 rounded-3xl blur-2xl opacity-50 animate-pulse"></div>
                {{-- Face --}}
                <div id="popup3dIconFace"
                    class="relative z-10 w-full h-full rounded-3xl flex items-center justify-center shadow-inner border border-white/30">
                    <div id="popup3dIconSvg"></div>
                </div>
            </div>
        </div>

        {{-- Content --}}
        <div class="relative z-10 space-y-2" style="transform: translateZ(30px);">
            <span id="popup3dPill"
                class="inline-block px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest"></span>
            <h3 id="popup3dTitle"
                class="text-xl sm:text-2xl font-extrabold tracking-tight text-slate-900 leading-snug mt-1"></h3>
            <p id="popup3dMsg" class="text-xs sm:text-sm font-medium text-slate-600 leading-relaxed mt-1"></p>
            <ul id="popup3dList"
                class="hidden text-left mt-2 text-xs text-rose-700 bg-rose-50 rounded-2xl p-3 border border-rose-200 space-y-1 list-disc list-inside max-h-36 overflow-y-auto">
            </ul>
        </div>

        {{-- Action Button + Progress Bar --}}
        <div class="relative z-10 mt-6 pt-4 border-t border-slate-100 space-y-2" style="transform: translateZ(35px);">
            <button id="popup3dActionBtn"
                class="w-full py-3 px-6 rounded-2xl font-extrabold text-sm text-white flex items-center justify-center gap-2 transition-all duration-150 cursor-pointer"
                style="transform: translateY(0); box-shadow: 0 8px 25px -5px rgba(0,0,0,0.25);">
                <span id="popup3dBtnLabel">Mengerti, Lanjutkan</span>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>

            {{-- Countdown Progress --}}
            <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                <div id="popup3dProgress" class="h-full w-full rounded-full transition-none"></div>
            </div>
        </div>

    </div>
</div>

{{-- ─── STYLES ─── --}}
<style>
    @keyframes p3dFloat {

        0%,
        100% {
            transform: translateY(0) rotateX(0) rotateY(0);
        }

        25% {
            transform: translateY(-10px) rotateX(-8deg) rotateY(10deg);
        }

        50% {
            transform: translateY(-14px) rotateX(6deg) rotateY(-8deg);
        }

        75% {
            transform: translateY(-7px) rotateX(-4deg) rotateY(-10deg);
        }
    }

    .p3d-float {
        animation: p3dFloat 3.8s ease-in-out infinite;
        transform-style: preserve-3d;
    }

    @keyframes p3dSpin {
        0% {
            transform: rotate(0deg) scale(1);
        }

        50% {
            transform: rotate(180deg) scale(1.2);
        }

        100% {
            transform: rotate(360deg) scale(1);
        }
    }

    .p3d-spin-icon {
        animation: p3dSpin 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }

    @keyframes p3dBounceIn {
        0% {
            transform: scale(0.4) translateY(60px) rotateX(25deg);
            opacity: 0;
        }

        60% {
            transform: scale(1.05) translateY(-8px) rotateX(-4deg);
            opacity: 1;
        }

        80% {
            transform: scale(0.97) translateY(3px) rotateX(2deg);
        }

        100% {
            transform: scale(1) translateY(0) rotateX(0);
            opacity: 1;
        }
    }

    .p3d-bounce-in {
        animation: p3dBounceIn 0.55s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }

    @keyframes p3dSlideOut {
        from {
            transform: scale(1) translateY(0) rotateX(0);
            opacity: 1;
        }

        to {
            transform: scale(0.75) translateY(40px) rotateX(20deg);
            opacity: 0;
        }
    }

    .p3d-slide-out {
        animation: p3dSlideOut 0.3s ease-in forwards;
    }

    @keyframes p3dFadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes p3dFadeOut {
        from {
            opacity: 1;
        }

        to {
            opacity: 0;
        }
    }

    @keyframes p3dParticle {
        0% {
            transform: translate(0, 0) scale(0) rotate(0deg);
            opacity: 1;
        }

        100% {
            transform: translate(var(--tx), var(--ty)) scale(1.4) rotate(var(--rot));
            opacity: 0;
        }
    }

    .p3d-particle {
        position: absolute;
        pointer-events: none;
        border-radius: 4px;
        animation: p3dParticle 1.2s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }

    #popup3dCard:hover {
        transform: scale(1.01);
    }
</style>

{{-- ─── CONTROLLER SCRIPT ─── --}}
<script>
    (function () {
        var backdrop = document.getElementById('popup3dBackdrop');
        var card = document.getElementById('popup3dCard');
        var closeBtn = document.getElementById('popup3dCloseBtn');
        var actionBtn = document.getElementById('popup3dActionBtn');
        var titleEl = document.getElementById('popup3dTitle');
        var msgEl = document.getElementById('popup3dMsg');
        var listEl = document.getElementById('popup3dList');
        var pillEl = document.getElementById('popup3dPill');
        var iconWrap = document.getElementById('popup3dIconWrap');
        var iconGlow = document.getElementById('popup3dGlow');
        var iconFace = document.getElementById('popup3dIconFace');
        var iconSvg = document.getElementById('popup3dIconSvg');
        var progressEl = document.getElementById('popup3dProgress');
        var particles = document.getElementById('popup3dParticles');

        var progressTimer = null;
        var autoClose = null;
        var isOpen = false;

        /* ── Sound (Web Audio API) ── */
        function playSound(success) {
            try {
                var Ctx = window.AudioContext || window.webkitAudioContext;
                if (!Ctx) return;
                var ctx = new Ctx(), t = ctx.currentTime;
                var notes = success
                    ? [523.25, 659.25, 783.99, 1046.5]
                    : [380, 270];
                notes.forEach(function (freq, i) {
                    var osc = ctx.createOscillator();
                    var gain = ctx.createGain();
                    var ts = t + i * (success ? 0.08 : 0.13);
                    osc.type = success ? 'sine' : 'triangle';
                    osc.frequency.setValueAtTime(freq, ts);
                    gain.gain.setValueAtTime(0.18, ts);
                    gain.gain.exponentialRampToValueAtTime(0.0001, ts + 0.45);
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.start(ts);
                    osc.stop(ts + 0.5);
                });
            } catch (e) { }
        }

        /* ── Particles ── */
        function spawnParticles(success) {
            particles.innerHTML = '';
            var count = success ? 30 : 18;
            var colors = success
                ? ['#10b981', '#06b6d4', '#f59e0b', '#3b82f6', '#ec4899', '#a855f7', '#22c55e']
                : ['#f43f5e', '#fb7185', '#e11d48', '#fca5a5', '#ef4444'];

            for (var i = 0; i < count; i++) {
                var p = document.createElement('div');
                p.className = 'p3d-particle';
                var angle = Math.random() * Math.PI * 2;
                var dist = 80 + Math.random() * 180;
                p.style.cssText = [
                    '--tx:' + (Math.cos(angle) * dist) + 'px',
                    '--ty:' + (Math.sin(angle) * dist - 20) + 'px',
                    '--rot:' + (Math.random() * 720 - 360) + 'deg',
                    'width:' + (8 + Math.random() * 8) + 'px',
                    'height:' + (8 + Math.random() * 8) + 'px',
                    'background:' + colors[Math.floor(Math.random() * colors.length)],
                    'left:50%',
                    'top:28%',
                    'border-radius:' + (Math.random() > 0.5 ? '50%' : '4px'),
                    'animation-delay:' + (Math.random() * 0.15) + 's',
                ].join(';');
                particles.appendChild(p);
            }
        }

        /* ── 3D Mouse Tilt ── */
        function onMouseMove(e) {
            if (!isOpen) return;
            var r = card.getBoundingClientRect();
            var rx = ((r.height / 2 - (e.clientY - r.top)) / (r.height / 2)) * 10;
            var ry = (((e.clientX - r.left) - r.width / 2) / (r.width / 2)) * 12;
            card.style.transform = 'scale(1) rotateX(' + rx + 'deg) rotateY(' + ry + 'deg)';
        }
        function onMouseLeave() {
            if (!isOpen) return;
            card.style.transform = 'scale(1) rotateX(0deg) rotateY(0deg)';
        }
        card.addEventListener('mousemove', onMouseMove);
        card.addEventListener('mouseleave', onMouseLeave);

        /* ── Progress Bar ── */
        function startProgress(duration) {
            var start = Date.now();
            progressEl.style.transition = 'none';
            progressEl.style.width = '100%';

            if (progressTimer) clearInterval(progressTimer);
            progressTimer = setInterval(function () {
                var pct = Math.max(0, 100 - ((Date.now() - start) / duration) * 100);
                progressEl.style.width = pct + '%';
                if (pct <= 0) clearInterval(progressTimer);
            }, 50);
        }

        /* ── CLOSE ── */
        function close3d() {
            if (!isOpen) return;
            isOpen = false;
            clearInterval(progressTimer);
            clearTimeout(autoClose);

            card.classList.remove('p3d-bounce-in');
            card.classList.add('p3d-slide-out');
            backdrop.style.animation = 'p3dFadeOut 0.3s ease forwards';

            setTimeout(function () {
                backdrop.classList.add('hidden');
                backdrop.style.animation = '';
                card.classList.remove('p3d-slide-out');
            }, 310);
        }

        closeBtn.addEventListener('click', close3d);
        actionBtn.addEventListener('click', close3d);
        backdrop.addEventListener('click', function (e) { if (e.target === backdrop) close3d(); });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && isOpen) close3d(); });

        /* ── PUBLIC TRIGGER ── */
        window.trigger3dPopup = function (opts) {
            var success = opts.type === 'success';
            var dur = opts.duration || (success ? 6000 : 7000);

            /* Set content */
            titleEl.textContent = opts.title || (success ? 'Berhasil Dilakukan!' : 'Terjadi Kesalahan!');
            msgEl.textContent = opts.message || '';

            var list = Array.isArray(opts.list) ? opts.list : [];
            if (list.length) {
                listEl.innerHTML = list.map(function (i) { return '<li>' + i + '</li>'; }).join('');
                listEl.classList.remove('hidden');
            } else {
                listEl.innerHTML = '';
                listEl.classList.add('hidden');
            }

            /* Apply theme */
            if (success) {
                pillEl.className = 'inline-block px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-emerald-100 text-emerald-800 border border-emerald-300';
                pillEl.textContent = '✅  SUKSES TERVERIFIKASI';

                iconWrap.className = 'relative p3d-float flex items-center justify-center w-20 h-20 rounded-3xl bg-gradient-to-br from-emerald-500 to-teal-500 shadow-2xl shadow-emerald-500/40';
                iconGlow.className = 'absolute -inset-3 rounded-3xl blur-2xl opacity-50 animate-pulse bg-emerald-400';
                iconFace.className = 'relative z-10 w-full h-full rounded-3xl flex items-center justify-center border border-white/30 bg-gradient-to-b from-white/25 to-transparent';
                iconSvg.innerHTML = '<svg class="p3d-spin-icon w-10 h-10 text-white drop-shadow-lg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>';

                actionBtn.style.background = 'linear-gradient(135deg, #059669, #0d9488)';
                actionBtn.style.boxShadow = '0 8px 25px -5px rgba(5,150,105,0.5), 0 0 0 1px rgba(5,150,105,0.2)';
                progressEl.style.background = 'linear-gradient(90deg, #10b981, #06b6d4)';
            } else {
                pillEl.className = 'inline-block px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-rose-100 text-rose-800 border border-rose-300';
                pillEl.textContent = '🚨  PERHATIAN';

                iconWrap.className = 'relative p3d-float flex items-center justify-center w-20 h-20 rounded-3xl bg-gradient-to-br from-rose-500 to-red-600 shadow-2xl shadow-rose-500/40';
                iconGlow.className = 'absolute -inset-3 rounded-3xl blur-2xl opacity-50 animate-pulse bg-rose-400';
                iconFace.className = 'relative z-10 w-full h-full rounded-3xl flex items-center justify-center border border-white/30 bg-gradient-to-b from-white/25 to-transparent';
                iconSvg.innerHTML = '<svg class="p3d-spin-icon w-10 h-10 text-white drop-shadow-lg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>';

                actionBtn.style.background = 'linear-gradient(135deg, #e11d48, #dc2626)';
                actionBtn.style.boxShadow = '0 8px 25px -5px rgba(225,29,72,0.5), 0 0 0 1px rgba(225,29,72,0.2)';
                progressEl.style.background = 'linear-gradient(90deg, #f43f5e, #ef4444)';
            }

            /* Show */
            backdrop.classList.remove('hidden');
            backdrop.style.animation = 'p3dFadeIn 0.25s ease forwards';
            card.classList.remove('p3d-slide-out', 'p3d-bounce-in');
            card.style.opacity = '1';
            card.style.transform = 'scale(1) rotateX(0deg) rotateY(0deg)';

            void card.offsetWidth; // force reflow
            card.classList.add('p3d-bounce-in');

            isOpen = true;
            playSound(success);
            spawnParticles(success);
            startProgress(dur);
            if (autoClose) clearTimeout(autoClose);
            autoClose = setTimeout(close3d, dur);
        };

        /* ── Auto-trigger from PHP session ── */
        @if($popupType)
            document.addEventListener('DOMContentLoaded', function () {
                window.trigger3dPopup({
                    type: {!! json_encode($popupType) !!},
                    title: {!! json_encode($popupTitle) !!},
                    message: {!! json_encode($popupMessage) !!},
                    list: {!! json_encode($popupList) !!},
                    duration: {{ $popupType === 'success' ? 6000 : 7000 }}
            });
            });
        @endif

})();
</script>