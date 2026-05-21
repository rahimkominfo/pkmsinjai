<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>
<!-- Main Content Area -->
<main class="max-w-container-max mx-auto px-margin-mobile md:px-gutter py-stack-lg">
    <!-- Back Navigation -->
    <div class="mb-stack-lg">
        <a class="inline-flex items-center gap-2 text-on-surface-variant hover:text-primary font-label-md text-label-md transition-colors" href="<?= base_url('berita') ?>">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Kembali ke Berita
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter">
        <!-- Article Canvas (8 Columns) -->
        <article class="col-span-1 md:col-span-8 bg-surface-container-lowest p-6 md:p-8 rounded-xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-outline-variant">
            <!-- Category Chip -->
            <div class="mb-stack-md">
                <span class="inline-block bg-surface-container-high text-on-surface-variant font-label-md text-label-md px-3 py-1 rounded-full uppercase tracking-wider">Informasi</span>
            </div>
            <!-- Headline -->
            <h1 class="font-display-lg text-display-lg text-on-surface mb-stack-md leading-tight"><?= esc($artikel['judul']) ?></h1>
            <!-- Metadata -->
            <div class="flex items-center gap-4 text-on-surface-variant font-caption text-caption mb-stack-lg pb-stack-sm border-b border-outline-variant">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">person</span>
                    <span class="font-semibold">Admin</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">calendar_today</span>
                    <span><?= date('F d, Y', strtotime($artikel['tanggal_publikasi'])) ?></span>
                </div>
            </div>
            <!-- Main Image -->
            <?php if(!empty($artikel['gambar_utama'])): ?>
            <figure class="mb-stack-lg rounded-lg overflow-hidden relative aspect-video bg-surface-dim">
                <img alt="<?= esc($artikel['judul']) ?>" class="w-full h-full object-cover" src="<?= esc($artikel['gambar_utama']) ?>"/>
            </figure>
            <?php endif; ?>
            <!-- Article Body -->
            <div class="prose prose-lg max-w-none font-body-lg text-body-lg text-on-surface-variant space-y-6">
                <?= esc($artikel['konten']) ?>
            </div>
            <!-- Sharing Section -->
            <div class="mt-section-gap pt-stack-lg border-t border-outline-variant">
                <h4 class="font-headline-md text-headline-md text-on-surface mb-stack-md">Bagikan Artikel</h4>
                <div class="flex flex-wrap gap-4">
                    <button class="flex items-center gap-2 bg-[#25D366] hover:bg-[#128C7E] text-white px-4 py-2 rounded-lg font-label-md text-label-md transition-colors shadow-sm">
                        <svg class="w-5 h-5 fill-current" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"></path></svg>
                        Kirim ke WhatsApp
                    </button>
                    <button class="flex items-center gap-2 bg-surface-bright border border-outline hover:border-primary text-on-surface hover:text-primary px-4 py-2 rounded-lg font-label-md text-label-md transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-sm">link</span>
                        Salin URL
                    </button>
                </div>
            </div>
        </article>
        <!-- Sidebar (4 Columns) -->
        <aside class="col-span-1 md:col-span-4 space-y-stack-lg">
            <!-- Berita Terbaru Widget -->
            <div class="bg-surface-container-lowest p-6 rounded-xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-outline-variant">
                <h3 class="font-headline-md text-headline-md text-on-surface mb-stack-md flex items-center gap-2 border-b border-outline-variant pb-2">
                    <span class="material-symbols-outlined text-primary">schedule</span>
                    Berita Terbaru
                </h3>
                <ul class="space-y-4">
                    <?php if(!empty($berita_terbaru)): ?>
                        <?php foreach($berita_terbaru as $bt): ?>
                        <li class="group">
                            <a class="block" href="<?= base_url('berita/detail/' . esc($bt['slug'])) ?>">
                                <span class="font-caption text-caption text-primary font-semibold mb-1 block">
                                    <?= date('d M Y', strtotime($bt['tanggal_publikasi'])) ?>
                                </span>
                                <h4 class="font-body-md text-body-md font-semibold text-on-surface group-hover:text-primary transition-colors line-clamp-2">
                                    <?= esc($bt['judul']) ?>
                                </h4>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
            
            <!-- Berita Terpopuler Widget -->
            <!-- Placeholder for popular news if needed -->
            <div class="bg-surface-container-lowest p-6 rounded-xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-outline-variant">
                <h3 class="font-headline-md text-headline-md text-on-surface mb-stack-md flex items-center gap-2 border-b border-outline-variant pb-2">
                    <span class="material-symbols-outlined text-primary">trending_up</span>
                    Berita Terpopuler
                </h3>
                <p class="text-body-md font-body-md text-on-surface-variant">Belum ada data cukup.</p>
            </div>
        </aside>
    </div>
</main>
<?= $this->endSection() ?>
