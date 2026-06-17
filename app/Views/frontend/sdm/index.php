<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<main class="max-w-[1200px] mx-auto px-4 md:px-8 py-12">
    <!-- Breadcrumb -->
    <nav aria-label="Breadcrumb" class="flex items-center text-on-surface-variant font-caption text-caption mb-8">
        <a class="hover:text-primary transition-colors" href="<?= base_url(tenant()->pkm_slug) ?>">Beranda</a>
        <span class="material-symbols-outlined mx-2 text-[14px]">chevron_right</span>
        <span class="text-on-surface">SDM Puskesmas</span>
    </nav>

    <!-- Header Section -->
    <header class="mb-12 text-center md:text-left flex flex-col md:flex-row items-center md:items-start justify-between gap-6">
        <div>
            <div class="flex items-center justify-center md:justify-start gap-3 mb-4 text-[#0ea5e9]">
                <span class="material-symbols-outlined text-[40px]">medical_services</span>
                <h1 class="font-display-lg text-3xl md:text-4xl font-bold text-on-surface">Sumber Daya Manusia</h1>
            </div>
            <h2 class="text-xl md:text-2xl text-on-surface-variant"><?= esc(tenant('pkm_nama')) ?></h2>
            <p class="mt-4 text-on-surface-variant max-w-2xl mx-auto md:mx-0">
                Mengenal lebih dekat tenaga medis dan staf profesional yang berdedikasi dalam memberikan pelayanan kesehatan terbaik untuk Anda.
            </p>
        </div>
        
        <!-- Stats -->
        <div class="bg-surface p-6 rounded-2xl border border-outline-variant shadow-sm flex flex-col items-center justify-center min-w-[160px]">
            <span class="material-symbols-outlined text-[#10b981] text-[32px] mb-2">groups</span>
            <span class="text-3xl font-bold text-on-surface"><?= number_format($total_pegawai) ?></span>
            <span class="text-on-surface-variant text-sm mt-1">Total Pegawai</span>
        </div>
    </header>

    <!-- Search & Filter Form -->
    <form action="" method="GET" class="mb-12 bg-surface p-4 md:p-6 rounded-2xl border border-outline-variant shadow-sm flex flex-col md:flex-row gap-4">
        <!-- Search Input -->
        <div class="flex-1 relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline-variant">search</span>
            <input type="text" name="search" value="<?= esc($search ?? '') ?>" placeholder="Cari nama atau jabatan..." 
                   class="w-full pl-12 pr-4 py-3 bg-surface border border-outline-variant rounded-xl focus:border-[#0ea5e9] focus:ring-1 focus:ring-[#0ea5e9] outline-none transition-all">
        </div>
        
        <!-- Filter Dropdown -->
        <div class="md:w-64 relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline-variant">filter_list</span>
            <select name="unit_poli" class="w-full pl-12 pr-4 py-3 bg-surface border border-outline-variant rounded-xl focus:border-[#10b981] focus:ring-1 focus:ring-[#10b981] outline-none transition-all appearance-none cursor-pointer">
                <option value="">Semua Unit / Poli</option>
                <?php foreach ($list_unit as $unit): ?>
                    <option value="<?= esc($unit) ?>" <?= ($selected_unit === $unit) ? 'selected' : '' ?>><?= esc($unit) ?></option>
                <?php endforeach; ?>
            </select>
            <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline-variant pointer-events-none">expand_more</span>
        </div>
        
        <button type="submit" class="bg-[#0ea5e9] hover:bg-[#0284c7] text-white px-6 py-3 rounded-xl font-medium transition-colors flex items-center justify-center gap-2">
            Terapkan
        </button>
        <?php if (!empty($search) || !empty($selected_unit)): ?>
        <a href="<?= base_url(tenant()->pkm_slug . '/sdm-pkm') ?>" class="bg-surface-variant hover:bg-surface-container text-on-surface-variant px-6 py-3 rounded-xl font-medium transition-colors flex items-center justify-center text-center">
            Reset
        </a>
        <?php endif; ?>
    </form>

    <!-- SDM Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php if (!empty($list_sdm)): ?>
            <?php foreach ($list_sdm as $pegawai): ?>
                <div class="bg-white rounded-[20px] border border-outline-variant shadow-[0_4px_12px_rgba(0,0,0,0.03)] hover:shadow-xl hover:-translate-y-2 transition-all duration-300 p-6 flex flex-col items-center text-center">
                    
                    <!-- Avatar -->
                    <div class="w-24 h-24 mb-5 rounded-full overflow-hidden border-4 border-[#eff6ff] shadow-sm relative bg-surface-variant flex items-center justify-center">
                        <?php if (!empty($pegawai['foto_pegawai'])): ?>
                            <img src="<?= strpos($pegawai['foto_pegawai'], 'http') === 0 ? esc($pegawai['foto_pegawai']) : base_url(esc($pegawai['foto_pegawai'])) ?>" 
                                 alt="<?= esc($pegawai['nama_lengkap']) ?>" 
                                 class="w-full h-full object-cover">
                        <?php else: ?>
                            <span class="material-symbols-outlined text-[48px] text-on-surface-variant opacity-50">person</span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Name -->
                    <h3 class="text-lg font-bold text-gray-800 mb-3 leading-tight"><?= esc($pegawai['nama_lengkap']) ?></h3>
                    
                    <div class="mt-auto w-full flex flex-col gap-2">
                        <!-- Profession Badge (Blue) -->
                        <div class="inline-flex items-center justify-center gap-1.5 bg-[#f0f9ff] text-[#0ea5e9] px-3 py-1.5 rounded-lg text-sm font-medium">
                            <span class="material-symbols-outlined text-[16px]">badge</span>
                            <?= esc($pegawai['profesi_jabatan']) ?>
                        </div>
                        
                        <!-- Unit Badge (Green) -->
                        <div class="inline-flex items-center justify-center gap-1.5 bg-[#ecfdf5] text-[#10b981] px-3 py-1.5 rounded-lg text-sm font-medium">
                            <span class="material-symbols-outlined text-[16px]">domain</span>
                            <?= esc($pegawai['unit_poli']) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-1 md:col-span-2 lg:col-span-4 bg-surface rounded-2xl border border-outline-variant p-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-surface-variant text-on-surface-variant mb-4">
                    <span class="material-symbols-outlined text-[32px]">search_off</span>
                </div>
                <h3 class="text-xl font-bold text-on-surface mb-2">Data tidak ditemukan</h3>
                <p class="text-on-surface-variant">Tidak ada data pegawai yang sesuai dengan kriteria pencarian Anda.</p>
            </div>
        <?php endif; ?>
    </div>
</main>
<?= $this->endSection() ?>
