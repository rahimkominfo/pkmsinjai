<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-container-max mx-auto px-margin-mobile md:px-gutter py-8">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 mb-8 text-on-surface-variant font-label-md text-label-md">
        <a class="hover:text-primary" href="<?= base_url(tenant()->pkm_slug) ?>">Beranda</a>
        <span class="material-symbols-outlined text-sm">chevron_right</span>
        <span class="text-primary font-bold">Berita Terkini</span>
    </nav>

    <!-- Page Header & Filters -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
        <div>
            <h1 class="font-headline-xl text-headline-xl mb-4 text-on-surface">Berita Terkini</h1>
            <div class="flex flex-wrap gap-2">
                <button class="px-6 py-2 bg-primary text-on-primary rounded-full font-label-md text-label-md">Semua</button>
            </div>
        </div>
        <div class="w-full md:w-80">
            <form action="<?= base_url(tenant()->pkm_slug . '/berita') ?>" method="GET" class="relative">
                <input name="q" value="<?= esc($searchQuery ?? '') ?>" class="w-full bg-surface-container-lowest border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg px-4 py-3 pr-12 font-body-md text-body-md transition-all" placeholder="Cari topik spesifik..." type="text"/>
                <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-outline hover:text-primary transition-colors bg-transparent border-none cursor-pointer p-0 flex items-center justify-center">
                    <span class="material-symbols-outlined">search</span>
                </button>
            </form>
        </div>
    </div>

    <!-- News Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">
        <?php if(!empty($list_berita)): ?>
            <?php foreach($list_berita as $berita): ?>
            <article class="group bg-surface-container-lowest rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <a href="<?= base_url(tenant()->pkm_slug . '/berita/detail/' . esc($berita['slug'])) ?>" class="block">
                    <div class="relative aspect-video overflow-hidden">
                        <img alt="<?= esc($berita['judul']) ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="<?= strpos($berita['gambar_utama'], 'http') === 0 ? esc($berita['gambar_utama']) : base_url(esc($berita['gambar_utama'])) ?>"/>
                        <span class="absolute top-4 left-4 bg-primary text-on-primary px-3 py-1 rounded-full font-label-md text-label-md"><?= esc($berita['nama_kategori'] ?? 'Informasi') ?></span>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-4 mb-3 text-caption font-caption text-on-surface-variant">
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">calendar_today</span> <?= date('d M Y', strtotime($berita['tanggal_publikasi'])) ?></span>
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">person</span> Admin</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md mb-3 text-on-surface group-hover:text-primary transition-colors leading-tight">
                            <?= esc($berita['judul']) ?>
                        </h3>
                        <p class="text-body-md font-body-md text-on-surface-variant line-clamp-3">
                            <?= esc($berita['abstrak']) ?>
                        </p>
                    </div>
                </a>
            </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Belum ada berita.</p>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
