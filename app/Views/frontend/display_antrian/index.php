<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <!-- Google Fonts & Material Symbols -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
    <!-- Use Inter for standard text, and a more display-oriented font like Roboto Mono or Outfit for numbers if desired, but Inter is great -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <style {csp-style-nonce}>
        :root {
            --tenant-primary: <?= (!empty(tenant('primary_color'))) ? esc(tenant('primary_color')) : '#0ea5e9' ?>;
        }
        body {
            /* Pure black/dark grey for OLED TVs */
            background-color: #0f172a; 
            color: #f8fafc;
            overflow: hidden; /* Prevent scrolling on TV */
            font-family: 'Inter', sans-serif;
        }
        .header-bg {
            background: linear-gradient(90deg, rgba(15,23,42,1) 0%, rgba(30,41,59,1) 100%);
            border-bottom: 2px solid var(--tenant-primary);
        }
        .marquee-container {
            background-color: var(--tenant-primary);
            color: #ffffff;
            overflow: hidden;
            white-space: nowrap;
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 60px;
            display: flex;
            align-items: center;
            font-size: 1.5rem;
            font-weight: 600;
            box-shadow: 0 -4px 15px rgba(0,0,0,0.5);
            z-index: 50;
        }
        .marquee-content {
            display: inline-block;
            padding-left: 100%;
            animation: marquee 25s linear infinite;
        }
        @keyframes marquee {
            0% { transform: translate(0, 0); }
            100% { transform: translate(-100%, 0); }
        }
        .card-antrian {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }
        /* Highlight Animation */
        @keyframes pulse-glow {
            0% { box-shadow: 0 0 0 0 rgba(var(--highlight-rgb), 0.7); border-color: rgba(var(--highlight-rgb), 1); transform: scale(1); }
            50% { box-shadow: 0 0 40px 10px rgba(var(--highlight-rgb), 0.5); border-color: rgba(var(--highlight-rgb), 1); transform: scale(1.02); }
            100% { box-shadow: 0 0 0 0 rgba(var(--highlight-rgb), 0); border-color: rgba(255, 255, 255, 0.1); transform: scale(1); }
        }
        @keyframes text-flash {
            0% { opacity: 1; }
            25% { opacity: 0.3; }
            50% { opacity: 1; }
            75% { opacity: 0.3; }
            100% { opacity: 1; }
        }
        .is-calling {
            animation: pulse-glow 3s cubic-bezier(0.4, 0, 0.2, 1);
            border-width: 2px;
        }
        .is-calling .nomor-text {
            animation: text-flash 3s ease-in-out;
            color: #ffffff;
            text-shadow: 0 0 20px rgba(var(--highlight-rgb), 0.8);
        }
        /* Grid adjustments for TV */
        .tv-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            padding: 2rem;
            height: calc(100vh - 160px); /* 100px header, 60px footer */
            align-content: center;
        }
        .time-display {
            font-variant-numeric: tabular-nums;
        }
        .header-title {
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        .tenant-primary-text {
            color: var(--tenant-primary);
        }
        .nomor-antrian-size {
            font-size: clamp(60px, 7vw, 130px);
            white-space: nowrap;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header class="header-bg h-[100px] flex items-center justify-between px-8 shadow-xl relative z-10">
        <div class="flex items-center gap-6">
            <?php if(tenant('logo')): ?>
                <img src="<?= base_url(esc(tenant('logo'))) ?>" alt="Logo" class="w-20 h-20 object-contain drop-shadow-md">
            <?php else: ?>
                <img src="<?= base_url('assets/img/logo_sinjai.png') ?>" alt="Logo" class="w-20 h-20 object-contain drop-shadow-md">
            <?php endif; ?>
            
            <div class="flex flex-col">
                <h1 class="text-4xl md:text-5xl font-black tracking-tight text-white uppercase header-title">
                    ANTRIAN <span class="tenant-primary-text"><?= esc(tenant('pkm_nama')) ?></span>
                </h1>
                <p class="text-xl text-slate-300 font-medium tracking-wide mt-1">Sistem Antrian Digital Terpadu</p>
            </div>
        </div>

        <div class="text-right flex flex-col items-end justify-center">
            <div id="realtime-time" class="text-5xl font-bold text-white tracking-wider time-display drop-shadow-md">00:00:00</div>
            <div id="realtime-date" class="text-xl text-slate-300 font-semibold mt-1 uppercase">Senin, 1 Januari 2026</div>
        </div>
    </header>

    <!-- Main Content Grid -->
    <main class="tv-grid" id="antrian-container">
        <!-- Cards will be injected here via JS -->
        <div class="col-span-3 flex items-center justify-center h-full">
            <div class="text-center animate-pulse">
                <span class="material-symbols-outlined text-[80px] text-slate-600">sync</span>
                <p class="text-2xl font-semibold text-slate-400 mt-4">Memuat data antrian...</p>
            </div>
        </div>
    </main>

    <!-- Marquee Footer -->
    <footer class="marquee-container">
        <div class="marquee-content">
            <?= esc($marquee_text) ?>
        </div>
    </footer>

    <!-- Audio Player (Hidden) -->
    <!-- You can add an audio file here for the chime sound when queue updates -->
    <audio id="chime-sound" preload="auto">
        <!-- Add a generic ding sound if available in your assets -->
        <!-- <source src="<?= base_url('assets/audio/ding.mp3') ?>" type="audio/mpeg"> -->
    </audio>

    <script {csp-script-nonce}>
    document.addEventListener('DOMContentLoaded', function() {
        // Clock functionality
        function updateClock() {
            const now = new Date();
            
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('realtime-time').textContent = `${hours}:${minutes}:${seconds}`;

            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
            const dayName = days[now.getDay()];
            const date = now.getDate();
            const monthName = months[now.getMonth()];
            const year = now.getFullYear();
            
            document.getElementById('realtime-date').textContent = `${dayName}, ${date} ${monthName} ${year}`;
        }
        
        setInterval(updateClock, 1000);
        updateClock();

        // Queue Fetching Logic
        let previousData = {};
        const container = document.getElementById('antrian-container');
        // Base API URL (Safe construction)
        const apiUrl = '<?= base_url(tenant()->pkm_slug . '/api/antrian') ?>';
        
        // Helper to convert hex to rgb for the CSS variable
        function hexToRgb(hex) {
            let result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
            return result ? `${parseInt(result[1], 16)}, ${parseInt(result[2], 16)}, ${parseInt(result[3], 16)}` : '14, 165, 233';
        }

        function createCard(item, isNewUpdate) {
            const rgbColor = hexToRgb(item.color);
            const animationClass = isNewUpdate ? 'is-calling' : '';
            
            return `
                <div class="card-antrian rounded-3xl flex flex-col overflow-hidden h-full ${animationClass}" id="card-${item.id}" data-color="${item.color}" data-rgb="${rgbColor}">
                    <div class="px-6 py-5 bg-slate-800/80 flex justify-between items-center border-b border-slate-700/50">
                        <div class="flex items-center gap-3">
                            <div class="w-4 h-4 rounded-full shadow-lg dot-color"></div>
                            <h2 class="text-3xl font-bold text-white tracking-wide uppercase">${item.title}</h2>
                        </div>
                    </div>
                    
                    <div class="flex-1 flex flex-col items-center justify-center p-6 relative">
                        <!-- Background Watermark/Icon -->
                        <div class="absolute inset-0 flex items-center justify-center opacity-5 pointer-events-none">
                            <span class="material-symbols-outlined text-[200px]">confirmation_number</span>
                        </div>
                        
                        <p class="text-2xl text-slate-400 font-semibold uppercase tracking-widest mb-2 z-10">${item.loket}</p>
                        <div class="nomor-text nomor-antrian-size font-black leading-none tracking-tighter text-white z-10 attr-color">
                            ${item.nomor}
                        </div>
                    </div>
                    
                    <div class="bg-slate-900/90 py-4 px-6 text-center border-t border-slate-700/50">
                        <p class="text-xl text-slate-300 font-medium">
                            <span class="material-symbols-outlined text-lg inline-block align-text-bottom mr-1">person</span>
                            Petugas: <span class="text-white font-bold">${item.petugas}</span>
                        </p>
                    </div>
                </div>
            `;
        }

        async function fetchAntrian() {
            try {
                const response = await fetch(apiUrl);
                if (!response.ok) return;
                
                const json = await response.json();
                if (json.status !== 'success') return;
                
                const currentData = json.data;
                let html = '';
                let hasChanges = false;
                
                if (currentData.length === 0) {
                    html = `
                        <div class="col-span-3 flex flex-col items-center justify-center h-full opacity-50">
                            <span class="material-symbols-outlined text-[100px] text-slate-500 mb-4">inbox</span>
                            <p class="text-3xl font-semibold text-slate-400">Tidak ada loket yang aktif</p>
                        </div>
                    `;
                } else {
                    // Check for changes and build HTML
                    currentData.forEach(item => {
                        let isNewUpdate = false;
                        
                        // Check if the number has changed compared to our previous fetch
                        if (previousData[item.id] && previousData[item.id].nomor !== item.nomor) {
                            isNewUpdate = true;
                            hasChanges = true;
                        }
                        
                        html += createCard(item, isNewUpdate);
                        previousData[item.id] = item; // Update tracker
                    });
                }
                
                // If it's the very first load, we don't animate everything
                if (Object.keys(previousData).length === 0) {
                    hasChanges = false;
                }
                
                // Update DOM
                container.innerHTML = html;
                
                // CSP-Safe: Apply dynamic inline styles using native DOM properties
                const cards = container.querySelectorAll('.card-antrian');
                cards.forEach(card => {
                    const color = card.getAttribute('data-color');
                    const rgb = card.getAttribute('data-rgb');
                    
                    card.style.setProperty('--highlight-rgb', rgb);
                    card.style.borderTop = `8px solid ${color}`;
                    
                    const dot = card.querySelector('.dot-color');
                    if (dot) dot.style.backgroundColor = color;
                    
                    const numText = card.querySelector('.attr-color');
                    if (numText) numText.style.color = color;
                });
                
                // Play sound if there was a change
                if (hasChanges) {
                    const chime = document.getElementById('chime-sound');
                    if (chime && chime.readyState >= 2) {
                        chime.play().catch(e => console.log('Audio play failed:', e));
                    }
                }
                
            } catch (error) {
                console.error('Error fetching antrian:', error);
            }
        }

        // Fetch immediately, then every 3 seconds
        fetchAntrian();
        setInterval(fetchAntrian, 3000);
    });
    </script>
</body>
</html>
