<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>
<!-- Main Content Canvas -->
<main class="max-w-container-max mx-auto px-margin-mobile md:px-gutter py-stack-lg">
    <!-- Breadcrumb -->
    <nav aria-label="Breadcrumb" class="flex items-center text-on-surface-variant font-caption text-caption mb-stack-md">
        <a class="hover:text-primary transition-colors" href="<?= base_url() ?>">Beranda</a>
        <span class="material-symbols-outlined mx-2 text-[14px]">chevron_right</span>
        <span class="text-on-surface">Galeri Foto</span>
    </nav>
    <!-- Page Header -->
    <header class="mb-stack-lg">
        <h1 class="font-display-lg text-display-lg text-on-surface mb-stack-sm">Galeri Foto</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">Arsip visual dokumentasi pelayanan kesehatan, kegiatan posyandu, dan infrastruktur Puskesmas Balangnipa.</p>
    </header>
    <!-- Filters & Search -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-stack-md mb-stack-lg border-b border-outline-variant pb-stack-sm">
        <div class="flex gap-2 overflow-x-auto w-full md:w-auto pb-2 md:pb-0 scrollbar-hide">
            <button class="bg-primary-container text-on-primary-container font-label-md text-label-md px-4 py-2 rounded-full whitespace-nowrap">Semua</button>
            <button class="bg-surface-container text-on-surface font-label-md text-label-md px-4 py-2 rounded-full whitespace-nowrap hover:bg-surface-variant transition-colors border border-outline-variant">Pelayanan Medis</button>
            <button class="bg-surface-container text-on-surface font-label-md text-label-md px-4 py-2 rounded-full whitespace-nowrap hover:bg-surface-variant transition-colors border border-outline-variant">Posyandu</button>
            <button class="bg-surface-container text-on-surface font-label-md text-label-md px-4 py-2 rounded-full whitespace-nowrap hover:bg-surface-variant transition-colors border border-outline-variant">Infrastruktur</button>
            <button class="bg-surface-container text-on-surface font-label-md text-label-md px-4 py-2 rounded-full whitespace-nowrap hover:bg-surface-variant transition-colors border border-outline-variant">Promkes</button>
        </div>
        <div class="relative w-full md:w-64">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
            <input class="w-full pl-10 pr-4 py-2 rounded border border-outline-variant bg-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all font-body-md text-body-md text-on-surface placeholder:text-on-surface-variant" placeholder="Cari album..." type="text"/>
        </div>
    </div>
    <!-- Gallery Grid (Bento/Card Layout) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter mb-section-gap">
        <!-- Card 1 -->
        <article class="group cursor-pointer bg-surface rounded-xl overflow-hidden border border-outline-variant shadow-[0px_4px_20px_rgba(0,0,0,0.05)] hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="relative aspect-video overflow-hidden">
                <img alt="Pelayanan Pengobatan Gratis di Desa Terpencil" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDYi9eUkHKALdybg2sAfzw8JDUA12IxCwRAFnVYxDoXEtqTtXPnhCwAVJaIb1_phXo7n11pBdSAkuoSFArtWDLcbxphXkqvw9vk1_uWnQekIUq5_eSg_TQuLPrZ2uNjTJz0nwub7lpbCiV3UZzE7dsp1JA2n_RcPOmPz4zslEEvK1k4miMxvQqQ3L70Hv1yCDV5RhsAv8NMMKeTHXUGo4hApRvTgwigWV3UV5YChGWzJLRvHJj1wey1rK7QPOgERB9OZBwlX9i6e-q8"/>
                <div class="absolute top-4 left-4 bg-primary text-on-primary font-caption text-caption px-2 py-1 rounded">12 Foto</div>
            </div>
            <div class="p-stack-md">
                <h2 class="font-headline-md text-headline-md text-on-surface mb-stack-sm group-hover:text-primary transition-colors line-clamp-2">Pelayanan Pengobatan Gratis di Desa Terpencil</h2>
                <div class="flex items-center text-on-surface-variant font-caption text-caption gap-2">
                    <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                    <time datetime="2024-10-24">24 Okt 2024</time>
                </div>
            </div>
        </article>
        <!-- Card 2 -->
        <article class="group cursor-pointer bg-surface rounded-xl overflow-hidden border border-outline-variant shadow-[0px_4px_20px_rgba(0,0,0,0.05)] hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="relative aspect-video overflow-hidden">
                <img alt="Peresmian Poli Gigi dan KIA Baru" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAlkdQ2XyicL3A3VnrMp4ttnjaJvQmYXXe9FTFHH9KUSP8Gt86zVZ76ltlik36_0R3ZIzb8EzmIMjahDwaZzmO3zZle77G4JksaRTD6VLEEtr1TSNnrzUo3CBVDvnU0Xb8FsgS22nuA-ZMH3aNYid9TU_5DT0RJhKi5tGPTKSYMBGoiATHAMnlhluKTzWA2utW1tUA_Uj42q0sjQt2P3fPbv1tFAAXgXD9brxaQvc_ywc8WfZmeFNzrQrYLBqmP_kIbV2fePmg97sDU"/>
                <div class="absolute top-4 left-4 bg-surface-container-high text-on-surface font-caption text-caption px-2 py-1 rounded shadow-sm">24 Foto</div>
            </div>
            <div class="p-stack-md">
                <h2 class="font-headline-md text-headline-md text-on-surface mb-stack-sm group-hover:text-primary transition-colors line-clamp-2">Peresmian Gedung Poli Gigi dan KIA Baru</h2>
                <div class="flex items-center text-on-surface-variant font-caption text-caption gap-2">
                    <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                    <time datetime="2024-10-20">20 Okt 2024</time>
                </div>
            </div>
        </article>
        <!-- Card 3 -->
        <article class="group cursor-pointer bg-surface rounded-xl overflow-hidden border border-outline-variant shadow-[0px_4px_20px_rgba(0,0,0,0.05)] hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="relative aspect-video overflow-hidden">
                <img alt="Kegiatan Posyandu Balita Melati" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC5iWHRNMdZr9AxL1qL1Xz_-mffIEQ2_kOPf8Ezuw9A7rsYXJ6VEfW0I7uCwNq7wQGPlMdu_N2DKRD27m78BR-0eb1_DtAUZ0QLUYHRrt3cmejY41xOqkQyY1nrn1B5tPeRKDe0jFoX6wTZh8VvBjpG80XDs9H_Lqa6ZEa4f91nL-lnbn5Zm5JsKuvmy-TEQdqC2NsX62OMDyOn8vewSi-N5hAfhQQNhB_ZKtKZCseDxA-wtPWBIhJlCs2TU9UnfMANsW_aB8S5PM_Z"/>
                <div class="absolute top-4 left-4 bg-surface-container-high text-on-surface font-caption text-caption px-2 py-1 rounded shadow-sm">18 Foto</div>
            </div>
            <div class="p-stack-md">
                <h2 class="font-headline-md text-headline-md text-on-surface mb-stack-sm group-hover:text-primary transition-colors line-clamp-2">Kegiatan Posyandu Balita Melati Desa Suka Maju</h2>
                <div class="flex items-center text-on-surface-variant font-caption text-caption gap-2">
                    <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                    <time datetime="2024-10-15">15 Okt 2024</time>
                </div>
            </div>
        </article>
    </div>
    <!-- Pagination -->
    <div class="flex justify-center items-center gap-2 mb-section-gap font-label-md text-label-md">
        <button class="w-10 h-10 flex items-center justify-center rounded border border-outline-variant text-on-surface-variant hover:bg-surface-container transition-colors disabled:opacity-50" disabled="">
            <span class="material-symbols-outlined">chevron_left</span>
        </button>
        <button class="w-10 h-10 flex items-center justify-center rounded bg-primary text-on-primary font-bold">1</button>
        <button class="w-10 h-10 flex items-center justify-center rounded border border-outline-variant text-on-surface hover:bg-surface-container transition-colors">2</button>
        <button class="w-10 h-10 flex items-center justify-center rounded border border-outline-variant text-on-surface hover:bg-surface-container transition-colors">3</button>
        <span class="text-on-surface-variant px-2">...</span>
        <button class="w-10 h-10 flex items-center justify-center rounded border border-outline-variant text-on-surface hover:bg-surface-container transition-colors">12</button>
        <button class="w-10 h-10 flex items-center justify-center rounded border border-outline-variant text-on-surface hover:bg-surface-container transition-colors">
            <span class="material-symbols-outlined">chevron_right</span>
        </button>
    </div>
</main>
<?= $this->endSection() ?>
