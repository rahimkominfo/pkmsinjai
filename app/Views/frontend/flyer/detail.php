<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-surface-container-lowest border-b border-outline-variant/30">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-gutter py-4 flex items-center gap-2 overflow-x-auto whitespace-nowrap scrollbar-hide">
        <a href="<?= base_url(tenant()->pkm_slug) ?>" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-[20px]">home</span>
            <span class="font-label-md text-label-md">Beranda</span>
        </a>
        <span class="material-symbols-outlined text-outline-variant text-[18px]">chevron_right</span>
        <span class="text-on-surface font-label-md text-label-md truncate"><?= esc($flyer['judul']) ?></span>
    </div>
</div>

<main class="max-w-container-max mx-auto px-margin-mobile md:px-gutter py-8 md:py-12">
    <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
        <!-- Content Area -->
        <div class="lg:flex-1">
            <div class="bg-surface rounded-2xl overflow-hidden shadow-sm border border-outline-variant/30">
                <!-- Image Display -->
                <div class="relative group bg-surface-container-low flex justify-center items-center p-4">
                    <img src="<?= strpos($flyer['gambar_url'], 'http') === 0 ? esc($flyer['gambar_url']) : base_url(esc($flyer['gambar_url'])) ?>" 
                         alt="<?= esc($flyer['judul']) ?>" 
                         class="max-w-full h-auto rounded-lg shadow-md"
                         onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';">
                </div>
                
                <!-- Info Area -->
                <div class="p-6 md:p-8">
                    <?php if(!empty($flyer['label'])): ?>
                        <span class="inline-block bg-primary text-on-primary text-[12px] font-bold tracking-wider uppercase px-3 py-1 rounded-full mb-4 shadow-sm">
                            <?= esc($flyer['label']) ?>
                        </span>
                    <?php endif; ?>
                    
                    <h1 class="font-headline-lg text-headline-lg text-3xl md:text-4xl mb-6 leading-tight">
                        <?= esc($flyer['judul']) ?>
                    </h1>

                    <div class="flex items-center gap-4 py-6 border-y border-outline-variant/30">
                        <div class="flex flex-col">
                            <span class="text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wider">Tanggal Publikasi</span>
                            <span class="text-on-surface font-body-lg text-body-lg"><?= date('d F Y', strtotime($flyer['created_at'])) ?></span>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="<?= strpos($flyer['gambar_url'], 'http') === 0 ? esc($flyer['gambar_url']) : base_url(esc($flyer['gambar_url'])) ?>" 
                           target="_blank"
                           class="bg-primary text-on-primary px-6 py-3 rounded-xl font-label-md text-label-md hover:bg-primary/90 transition-all flex items-center gap-2 shadow-md hover:shadow-lg">
                            <span class="material-symbols-outlined">zoom_in</span>
                            Lihat Full Resolution
                        </a>
                        <button onclick="shareFlyer()" class="bg-surface-container text-on-surface px-6 py-3 rounded-xl font-label-md text-label-md hover:bg-surface-container-high transition-all flex items-center gap-2 border border-outline-variant/30">
                            <span class="material-symbols-outlined">share</span>
                            Bagikan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <aside class="w-full lg:w-[380px] space-y-8">
            <!-- Other Flyers -->
            <div class="bg-surface rounded-2xl p-6 shadow-sm border border-outline-variant/30">
                <h2 class="font-headline-sm text-headline-sm mb-6 pb-2 border-b-2 border-primary inline-block">Media Lainnya</h2>
                <div class="space-y-6">
                    <?php if(!empty($other_flyers)): ?>
                        <?php foreach($other_flyers as $other): ?>
                        <a href="<?= base_url(tenant()->pkm_slug . '/flayer/' . esc($other['uuid'])) ?>" class="flex gap-4 group">
                            <div class="w-24 h-24 rounded-xl overflow-hidden shrink-0 bg-surface-container-low">
                                <img src="<?= strpos($other['gambar_url'], 'http') === 0 ? esc($other['gambar_url']) : base_url(esc($other['gambar_url'])) ?>" 
                                     alt="<?= esc($other['judul']) ?>" 
                                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                            </div>
                            <div class="flex flex-col justify-center">
                                <h3 class="font-label-lg text-label-lg leading-tight group-hover:text-primary transition-colors line-clamp-2 mb-1">
                                    <?= esc($other['judul']) ?>
                                </h3>
                                <span class="text-on-surface-variant font-caption text-caption">
                                    <?= date('d M Y', strtotime($other['created_at'])) ?>
                                </span>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-on-surface-variant font-body-md text-body-md italic text-center py-4">Tidak ada media lainnya.</p>
                    <?php endif; ?>
                </div>
                
                <div class="mt-8">
                    <a href="<?= base_url(tenant()->pkm_slug . '/flayer') ?>" class="w-full py-3 bg-surface-container-low hover:bg-surface-container transition-colors text-primary font-label-md text-label-md rounded-xl border border-outline-variant/30 text-center block">
                        Lihat Semua Media
                    </a>
                </div>
            </div>
        </aside>
    </div>
</main>

<script {csp-script-nonce}>
function shareFlyer() {
    if (navigator.share) {
        navigator.share({
            title: '<?= esc($flyer['judul']) ?>',
            text: 'Lihat media promosi kesehatan dari <?= esc(tenant()->pkm_nama) ?>',
            url: window.location.href
        }).catch(console.error);
    } else {
        // Fallback: Copy to clipboard
        const el = document.createElement('textarea');
        el.value = window.location.href;
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);
        alert('Link berhasil disalin ke clipboard!');
    }
}
</script>

<?= $this->endSection() ?>
