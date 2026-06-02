<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Kesehatan Kabupaten Sinjai</title>
    <!-- Google Fonts & Material Symbols -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen text-gray-800 flex flex-col">
    <!-- Header/Hero Section -->
    <div class="bg-teal-700 text-white pb-16 pt-20 px-4 shadow-inner relative overflow-hidden">
        <!-- Abstract shape background -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-10 pointer-events-none">
            <div class="absolute -top-[20%] -right-[10%] w-[50%] h-[150%] rounded-full bg-white blur-3xl transform rotate-12"></div>
            <div class="absolute -bottom-[20%] -left-[10%] w-[50%] h-[150%] rounded-full bg-teal-900 blur-3xl transform -rotate-12"></div>
        </div>
        
        <div class="max-w-6xl mx-auto text-center relative z-10">
            <div class="inline-flex items-center justify-center p-4 bg-teal-600/50 backdrop-blur-sm rounded-full mb-6 shadow-lg border border-teal-500/30">
                <span class="material-symbols-outlined text-4xl text-teal-50">health_and_safety</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4 tracking-tight text-white drop-shadow-sm">Portal Kesehatan Sinjai</h1>
            <p class="text-teal-50 text-lg md:text-xl max-w-2xl mx-auto mb-8 font-light">Pusat informasi dan layanan terpadu dari seluruh Pusat Kesehatan Masyarakat di wilayah Kabupaten Sinjai.</p>
        </div>
    </div>

    <!-- Cards Section -->
    <div class="max-w-7xl mx-auto px-4 -mt-10 pb-24 flex-1 w-full relative z-20">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach($pkms as $pkm): ?>
                <?php $primaryColor = $pkm['primary_color'] ?? '#0f766e'; ?>
                <a href="<?= base_url($pkm['pkm_slug']) ?>" class="group block bg-white rounded-xl shadow-md hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 transform hover:-translate-y-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                    <div class="h-2 w-full transition-colors duration-300 opacity-90" style="background-color: <?= esc($primaryColor) ?>"></div>
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-5">
                            <div class="w-14 h-14 rounded-full flex items-center justify-center shadow-sm" style="background-color: <?= esc($primaryColor) ?>15; color: <?= esc($primaryColor) ?>;">
                                <span class="material-symbols-outlined text-[28px]">local_hospital</span>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-teal-50 transition-colors">
                                <span class="material-symbols-outlined text-gray-400 group-hover:text-teal-600 transition-colors text-[20px]">arrow_forward</span>
                            </div>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-teal-700 transition-colors"><?= esc($pkm['pkm_nama']) ?></h2>
                        <p class="text-gray-500 text-sm line-clamp-2 leading-relaxed">Akses layanan kesehatan, informasi antrian, dan berita terkini dari <?= esc($pkm['pkm_nama']) ?>.</p>
                    </div>
                    <div class="px-6 py-3.5 bg-gray-50/80 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500 font-medium group-hover:bg-teal-50/50 transition-colors">
                        <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px] text-gray-400 group-hover:text-teal-600 transition-colors">language</span> Buka Portal</span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 text-gray-500 py-8 text-center text-sm">
        <p>&copy; <?= date('Y') ?> Dinas Kesehatan Kabupaten Sinjai. Hak Cipta Dilindungi.</p>
    </footer>
</body>
</html>
