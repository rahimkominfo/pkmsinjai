<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Status Antrian Section (View Cell) -->
<?= view_cell('App\Cells\AntrianCell::render') ?>

<!-- Hero Carousel Section -->
<section class="relative h-[450px] md:h-[600px] w-full overflow-hidden bg-surface-dim">
    <!-- Carousel Slide (Active) -->
    <div class="absolute inset-0">
        <img alt="Hero News" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDl9lBDZGj4FMKYjn8qNjMMXKLrsn2yarly_C7FkwYi91u8pi_0fzrCkeqFusCTDW8LSLG67jA91XFDXlpS8ZQG3n95aZ1Jkst2ONGDWdcfa4Xb2P-U-ity3rBIW6-rrqUKpJQfS0KVjpizvkfeu2sd18n_Qyd1vdFP2fVuxEk8InA9H59wa-4iO0cMfKKT8Qtv3NgDzFOrgoZGE7Ij9cUpr_BePChJnoqF6586JTyPH8jwcYlcKYogOPMBPLOYz4mT_JlqaS07LdwP"/>
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
        <!-- Content Overlay -->
        <div class="absolute inset-0 flex flex-col justify-end pb-16 md:pb-24">
            <div class="max-w-container-max mx-auto px-margin-mobile md:px-gutter w-full">
                <div class="max-w-3xl">
                    <span class="inline-block bg-primary text-on-primary px-3 py-1 rounded-full text-label-md font-label-md mb-4 shadow-lg">Layanan Unggulan</span>
                    <h1 class="text-white font-headline-xl text-3xl md:text-5xl mb-4 leading-tight drop-shadow-md">
                        Puskesmas Balangnipa Hadirkan Layanan Kesehatan Digital Terpadu
                    </h1>
                    <p class="text-white/90 font-body-lg text-lg hidden md:block mb-6 line-clamp-2 drop-shadow-sm">
                        Kami berkomitmen memberikan pelayanan prima. Kini daftar antrean dan cek riwayat kesehatan dapat dilakukan dengan mudah dari rumah.
                    </p>
                    <button class="bg-white text-primary px-6 py-3 rounded-lg font-label-md text-label-md hover:bg-surface-container transition-colors shadow-md">
                        Baca Selengkapnya
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Navigation Arrows -->
    <div class="absolute inset-0 flex items-center justify-between px-4 md:px-8">
        <button class="w-12 h-12 flex items-center justify-center rounded-full bg-white/20 hover:bg-white/40 backdrop-blur-md text-white transition-all">
            <span class="material-symbols-outlined">chevron_left</span>
        </button>
        <button class="w-12 h-12 flex items-center justify-center rounded-full bg-white/20 hover:bg-white/40 backdrop-blur-md text-white transition-all">
            <span class="material-symbols-outlined">chevron_right</span>
        </button>
    </div>
</section>

<div class="max-w-container-max mx-auto px-margin-mobile md:px-gutter pt-12 pb-section-gap">
    
    <!-- Statistik Kesehatan Section (View Cell) -->
    <?= view_cell('App\Cells\StatistikCell::render') ?>

    <!-- News Grid Section -->
    <section class="mb-section-gap">
        <h2 class="font-headline-lg text-headline-lg mb-stack-lg border-b-2 border-primary inline-block pb-2">Kabar & Edukasi Kesehatan</h2>
        <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter">
            <!-- Featured News -->
            <article class="md:col-span-8 group relative overflow-hidden rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-[0px_10px_30px_rgba(0,0,0,0.1)] hover:-translate-y-1 transition-all duration-300 border border-outline-variant/50">
                <div class="aspect-video w-full overflow-hidden relative">
                    <img alt="Featured News" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBzDdYpLefQYDVWdfCL-ZdpsrLIvSnQZfjbGd5C01UKL9kVqEEex6IavgHM_xu11ciEGXWi7zOaVRPmUmvfxhk526QD6Q_tYclkvyl5uAV-LRUnrWln5YAIGl3n6-qZlkXNqsG7tTjbWw14Jf0AF8dU_Bp6L9COssFuvxkHP9ifEzgVn--pOp9uzlNVIQsKjk21dFLmx-b2bnN4eK3hLUk9pAVh03krHJHYVt28uKYOcQ6pzdpF1GVPBhJiii9LFTxnN-ce2h-RDMEG"/>
                    <div class="absolute top-4 left-4 bg-primary text-on-primary font-label-md text-label-md px-3 py-1 rounded-full shadow-md">
                        Edukasi
                    </div>
                </div>
                <div class="p-6">
                    <p class="font-caption text-caption text-on-surface-variant mb-2">2 Jam yang lalu • Oleh Tim Promkes</p>
                    <h3 class="font-headline-xl text-headline-xl mb-4 group-hover:text-primary transition-colors line-clamp-2">
                        Pentingnya Asupan Gizi Seimbang untuk Mencegah Stunting pada Balita
                    </h3>
                    <p class="font-body-lg text-body-lg text-on-surface-variant line-clamp-3">
                        Puskesmas Balangnipa kembali mengadakan penyuluhan gizi seimbang di berbagai posyandu. Langkah ini diambil sebagai upaya percepatan penurunan angka stunting di wilayah kerja kami.
                    </p>
                </div>
            </article>
            <!-- Secondary News List -->
            <div class="md:col-span-4 flex flex-col gap-6">
                <article class="flex gap-4 group cursor-pointer">
                    <div class="w-1/3 aspect-square rounded-lg overflow-hidden shrink-0">
                        <img alt="Secondary News 1" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDPNCgJ4daHKMR8s-jOYqZoiYS_kdFFE1pW2sSiP49ox5_9dud45ijwHCVryJeZ4WeCIGb1Kv1bI7AqsBZNqbyilwJvKkS5TfMjuHGsC6A4a10BwRHrkA5_5jjq7sg1rHRPphOgqHrsjAKYSOVIk3DsH2JP6-izjECNvG9Rl2bnCaZfx_HmYTm_sUnXP4myOMwIwchrMaByQxlzOrWtd7SfkXws4DKSHjcIMSNdyTeMvxVtah-YmZD1RopRWBqRbw5b5hmJMEUcFr7t"/>
                    </div>
                    <div class="flex flex-col justify-center">
                        <span class="font-caption text-caption text-primary font-semibold mb-1">Informasi Layanan</span>
                        <h4 class="font-headline-md text-headline-md text-base leading-tight group-hover:text-primary transition-colors line-clamp-3">
                            Jadwal Pelayanan Imunisasi Dasar Lengkap Bulan Ini
                        </h4>
                    </div>
                </article>
                <!-- Add more news as needed -->
                <button class="mt-auto py-3 px-4 w-full bg-surface-container-low hover:bg-surface-container transition-colors text-primary font-label-md text-label-md rounded border border-outline-variant/30 text-center">
                    Lihat Semua Berita Terkini
                </button>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="mb-section-gap">
        <div class="flex justify-between items-end mb-stack-lg">
            <h2 class="font-headline-lg text-headline-lg border-b-2 border-primary inline-block pb-2">Galeri Foto</h2>
            <a class="text-primary hover:text-on-primary-fixed-variant transition-colors font-label-md text-label-md flex items-center gap-1" href="#">
                Lebih Banyak
                <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Gallery Card -->
            <div class="group relative rounded-xl overflow-hidden cursor-pointer shadow-sm hover:shadow-[0px_8px_24px_rgba(0,0,0,0.12)] transition-all duration-300">
                <div class="aspect-[4/3] w-full">
                    <img alt="Gallery 1" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDl9lBDZGj4FMKYjn8qNjMMXKLrsn2yarly_C7FkwYi91u8pi_0fzrCkeqFusCTDW8LSLG67jA91XFDXlpS8ZQG3n95aZ1Jkst2ONGDWdcfa4Xb2P-U-ity3rBIW6-rrqUKpJQfS0KVjpizvkfeu2sd18n_Qyd1vdFP2fVuxEk8InA9H59wa-4iO0cMfKKT8Qtv3NgDzFOrgoZGE7Ij9cUpr_BePChJnoqF6586JTyPH8jwcYlcKYogOPMBPLOYz4mT_JlqaS07LdwP"/>
                </div>
                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-inverse-surface/90 via-inverse-surface/40 to-transparent"></div>
                <div class="absolute bottom-0 left-0 w-full p-6 text-on-primary">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-on-primary" style="font-size: 16px;">photo_library</span>
                        <span class="font-caption text-caption opacity-90">12 Foto</span>
                    </div>
                    <h3 class="font-headline-md text-headline-md text-lg leading-tight group-hover:underline underline-offset-4">
                        Dokumentasi Kegiatan Posyandu Balita & Lansia
                    </h3>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection() ?>
