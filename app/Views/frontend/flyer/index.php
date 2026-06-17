<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-surface-container-lowest border-b border-outline-variant/30">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-gutter py-4 flex items-center gap-2 overflow-x-auto whitespace-nowrap scrollbar-hide">
        <a href="<?= base_url(tenant()->pkm_slug) ?>" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-[20px]">home</span>
            <span class="font-label-md text-label-md">Beranda</span>
        </a>
        <span class="material-symbols-outlined text-outline-variant text-[18px]">chevron_right</span>
        <span class="text-on-surface font-label-md text-label-md">Media Promosi Kesehatan</span>
    </div>
</div>

<main class="max-w-container-max mx-auto px-margin-mobile md:px-gutter py-12">
    <div class="mb-12 text-center">
        <h1 class="font-headline-lg text-headline-lg text-4xl mb-4">Media Promosi Kesehatan</h1>
        <p class="text-on-surface-variant font-body-lg text-body-lg max-w-2xl mx-auto">
            Dapatkan berbagai informasi dan edukasi kesehatan melalui media visual kami untuk pola hidup yang lebih sehat.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <?php if(!empty($flyers)): ?>
            <?php foreach($flyers as $flyer): ?>
                <a href="<?= base_url(tenant()->pkm_slug . '/flayer/' . esc($flyer['uuid'])) ?>" class="group relative block aspect-[3/4] bg-surface rounded-xl overflow-hidden border-4 border-surface shadow-lg hover:shadow-xl transition-all duration-300">
                    <!-- Image Container -->
                    <div class="w-full h-full overflow-hidden bg-surface-container-low">
                        <img src="<?= strpos($flyer['gambar_url'], 'http') === 0 ? esc($flyer['gambar_url']) : base_url(esc($flyer['gambar_url'])) ?>" 
                             alt="<?= esc($flyer['judul']) ?>" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                             onerror="this.onerror=null;this.src='<?= base_url('assets/img/placeholder.jpg') ?>';" />
                    </div>
                    
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                        <div class="p-6 w-full transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                            <?php if(!empty($flyer['label'])): ?>
                                <span class="inline-block bg-primary text-on-primary text-[11px] font-bold tracking-wider uppercase px-2 py-1 rounded mb-2 shadow-sm"><?= esc($flyer['label']) ?></span>
                            <?php endif; ?>
                            <h3 class="text-white font-headline-sm text-headline-sm font-bold line-clamp-2 drop-shadow-md">
                                <?= esc($flyer['judul']) ?>
                            </h3>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full text-center py-20 bg-surface-container-lowest rounded-2xl border-2 border-dashed border-outline-variant">
                <span class="material-symbols-outlined text-[64px] text-outline mb-4">web_stories</span>
                <p class="font-headline-sm text-headline-sm text-on-surface-variant">Belum ada media promosi yang tersedia.</p>
                <a href="<?= base_url(tenant()->pkm_slug) ?>" class="mt-6 inline-block text-primary font-label-md hover:underline">Kembali ke Beranda</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?= $this->endSection() ?>
