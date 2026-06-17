<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<!-- PKM Hero Banner (Responsive) -->
<?php if (!empty(tenant('header_img'))): ?>
<section class="relative h-[250px] md:h-[450px] w-full overflow-hidden">
    <picture>
        <!-- Mobile Image -->
        <?php if (!empty(tenant('header_img_mobile'))): ?>
            <source media="(max-width: 767px)" srcset="<?= base_url(tenant('header_img_mobile')) ?>">
        <?php endif; ?>
        <!-- Desktop Image (Default) -->
        <img src="<?= base_url(tenant('header_img')) ?>" alt="<?= esc(tenant('pkm_nama')) ?>" class="w-full h-full object-cover">
    </picture>
    
    <!-- Overlay -->
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent flex items-end">
        <div class="max-w-container-max mx-auto px-margin-mobile md:px-gutter w-full pb-8 md:pb-12">
            <h1 class="text-white font-headline-xl text-3xl md:text-6xl drop-shadow-lg mb-2 leading-tight"><?= esc(tenant('pkm_nama')) ?></h1>
            <?php if (!empty(tenant('pkm_motto'))): ?>
                <p class="text-white/90 text-base md:text-xl font-light tracking-wide italic drop-shadow-md">"<?= esc(tenant('pkm_motto')) ?>"</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Status Antrian Section (View Cell) -->
<?= view_cell('App\Cells\AntrianCell::render') ?>

<!-- Hero & Flyer Section -->
<section class="max-w-container-max mx-auto px-margin-mobile md:px-gutter mt-6 mb-8">
    <div class="flex flex-col lg:flex-row gap-6 h-auto lg:h-[500px] xl:h-[550px]">
        <!-- Hero Carousel -->
        <div class="flex-1 relative h-[400px] lg:h-full rounded-2xl overflow-hidden shadow-lg bg-surface-dim group" id="hero-carousel">
            <!-- Carousel Slides -->
            <?php if (!empty($hero_artikel)): ?>
                <?php foreach ($hero_artikel as $index => $hero): ?>
                <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out carousel-slide <?= $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' ?>">
                    <img alt="<?= esc($hero['judul']) ?>" class="w-full h-full object-cover" src="<?= strpos($hero['gambar_utama'], 'http') === 0 ? esc($hero['gambar_utama']) : base_url(esc($hero['gambar_utama'])) ?>"/>
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                    <!-- Content Overlay -->
                    <div class="absolute inset-0 flex flex-col justify-end p-6 md:p-10 lg:p-12">
                        <div class="max-w-3xl">
                            <span class="inline-block bg-primary text-on-primary px-3 py-1 rounded-full text-[11px] font-bold tracking-wider uppercase mb-3 md:mb-4 shadow-md"><?= esc($hero['nama_kategori'] ?? 'Berita') ?></span>
                            <h1 class="text-white font-headline-lg text-2xl md:text-4xl lg:text-5xl mb-3 md:mb-4 leading-tight drop-shadow-md line-clamp-3">
                                <?= esc($hero['judul']) ?>
                            </h1>
                            <p class="text-white/90 font-body-md md:font-body-lg text-base md:text-lg hidden md:block mb-6 line-clamp-2 drop-shadow-sm">
                                <?= esc($hero['abstrak']) ?>
                            </p>
                            <a href="<?= base_url(tenant()->pkm_slug . '/berita/detail/' . esc($hero['slug'])) ?>" class="inline-block bg-white text-primary px-5 py-2.5 md:px-6 md:py-3 rounded-lg font-label-md text-label-md hover:bg-surface-container transition-colors shadow-md">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- Navigation Arrows -->
            <?php if (!empty($hero_artikel) && count($hero_artikel) > 1): ?>
            <div class="absolute inset-0 flex items-center justify-between px-4 z-20 pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <button onclick="prevSlide()" class="pointer-events-auto w-10 h-10 md:w-12 md:h-12 flex items-center justify-center rounded-full bg-black/30 hover:bg-black/50 backdrop-blur-md text-white transition-all">
                    <span class="material-symbols-outlined">chevron_left</span>
                </button>
                <button onclick="nextSlide()" class="pointer-events-auto w-10 h-10 md:w-12 md:h-12 flex items-center justify-center rounded-full bg-black/30 hover:bg-black/50 backdrop-blur-md text-white transition-all">
                    <span class="material-symbols-outlined">chevron_right</span>
                </button>
            </div>
            
            <!-- Carousel Indicators -->
            <div class="absolute bottom-6 right-6 lg:bottom-12 lg:right-12 z-20 flex gap-2">
                <?php foreach ($hero_artikel as $index => $hero): ?>
                    <button onclick="goToSlide(<?= $index ?>)" class="carousel-dot w-2 h-2 md:w-3 md:h-3 rounded-full transition-all <?= $index === 0 ? 'bg-primary scale-125' : 'bg-white/50 hover:bg-white/80' ?>"></button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- PKM Flyer Utama -->
        <?php if (!empty(tenant()->pkm_flyer)): ?>
        <div class="w-full lg:w-[320px] xl:w-[400px] h-[400px] lg:h-full rounded-2xl overflow-hidden shadow-lg relative group shrink-0 bg-surface-container-low border-4 border-surface">
            <img src="<?= strpos(tenant()->pkm_flyer, 'http') === 0 ? esc(tenant()->pkm_flyer) : base_url(esc(tenant()->pkm_flyer)) ?>" 
                 alt="Flyer Promosi Utama" 
                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                 onerror="this.onerror=null; this.parentElement.style.display='none';">
        </div>
        <?php endif; ?>
    </div>
</section>

<div class="max-w-container-max mx-auto px-margin-mobile md:px-gutter pt-12 pb-section-gap">
    
    <!-- Statistik Kesehatan Section (View Cell) -->
    <?= view_cell('App\Cells\StatistikCell::render') ?>

    <!-- News Grid Section -->
    <section class="mb-section-gap">
        <h2 class="font-headline-lg text-headline-lg mb-stack-lg border-b-2 border-primary inline-block pb-2">Berita Terkini</h2>
        <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter">
            <!-- Featured News -->
            <?php if (!empty($berita_terbaru) && isset($berita_terbaru[0])): ?>
            <article class="md:col-span-8 group relative overflow-hidden rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-[0px_10px_30px_rgba(0,0,0,0.1)] hover:-translate-y-1 transition-all duration-300 border border-outline-variant/50">
                <a href="<?= base_url(tenant()->pkm_slug . '/berita/detail/' . esc($berita_terbaru[0]['slug'])) ?>" class="block">
                    <div class="aspect-video w-full overflow-hidden relative">
                        <img alt="<?= esc($berita_terbaru[0]['judul']) ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="<?= strpos($berita_terbaru[0]['gambar_utama'], 'http') === 0 ? esc($berita_terbaru[0]['gambar_utama']) : base_url(esc($berita_terbaru[0]['gambar_utama'])) ?>"/>
                        <div class="absolute top-4 left-4 bg-primary text-on-primary font-label-md text-label-md px-3 py-1 rounded-full shadow-md">
                            <?= esc($berita_terbaru[0]['nama_kategori'] ?? 'Terbaru') ?>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="font-caption text-caption text-on-surface-variant mb-2">
                            <?= date('d M Y', strtotime($berita_terbaru[0]['tanggal_publikasi'])) ?>
                        </p>
                        <h3 class="font-headline-xl text-headline-xl mb-4 group-hover:text-primary transition-colors line-clamp-2">
                            <?= esc($berita_terbaru[0]['judul']) ?>
                        </h3>
                        <p class="font-body-lg text-body-lg text-on-surface-variant line-clamp-3">
                            <?= esc($berita_terbaru[0]['abstrak']) ?>
                        </p>
                    </div>
                </a>
            </article>
            <?php endif; ?>

            <!-- Secondary News List -->
            <div class="md:col-span-4 flex flex-col gap-6">
                <?php for($i = 1; $i < count($berita_terbaru); $i++): ?>
                <article class="flex gap-4 group cursor-pointer">
                    <a href="<?= base_url(tenant()->pkm_slug . '/berita/detail/' . esc($berita_terbaru[$i]['slug'])) ?>" class="flex gap-4 w-full">
                        <div class="w-1/3 aspect-square rounded-lg overflow-hidden shrink-0">
                            <img alt="<?= esc($berita_terbaru[$i]['judul']) ?>" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" src="<?= strpos($berita_terbaru[$i]['gambar_utama'], 'http') === 0 ? esc($berita_terbaru[$i]['gambar_utama']) : base_url(esc($berita_terbaru[$i]['gambar_utama'])) ?>"/>
                        </div>
                        <div class="flex flex-col justify-center">
                            <span class="font-caption text-caption text-primary font-semibold mb-1">
                                <?= date('d M Y', strtotime($berita_terbaru[$i]['tanggal_publikasi'])) ?>
                            </span>
                            <h4 class="font-headline-md text-headline-md text-base leading-tight group-hover:text-primary transition-colors line-clamp-3">
                                <?= esc($berita_terbaru[$i]['judul']) ?>
                            </h4>
                        </div>
                    </a>
                </article>
                <?php endfor; ?>
                
                <a href="<?= base_url(tenant()->pkm_slug . '/berita') ?>" class="mt-auto py-3 px-4 w-full bg-surface-container-low hover:bg-surface-container transition-colors text-primary font-label-md text-label-md rounded border border-outline-variant/30 text-center block">
                    Lihat Semua Berita
                </a>
            </div>
        </div>
    </section>

    <!-- Media Promosi Kesehatan Section -->
    <section class="mb-section-gap">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-stack-lg">
            <div class="flex-1">
                <h2 class="font-headline-lg text-headline-lg border-b-2 border-primary inline-block pb-2">Media Promosi Kesehatan</h2>
            </div>
            <div class="flex items-center gap-3">
                <a href="<?= tenant_url('flayer') ?>" class="bg-primary text-on-primary px-6 py-2.5 rounded-full font-label-lg text-label-lg hover:bg-primary-container hover:text-on-primary-container transition-all shadow-sm flex items-center gap-2 group">
                    Lihat Semua Flyer
                    <span class="material-symbols-outlined text-lg transition-transform group-hover:translate-x-1">arrow_forward</span>
                </a>
                <div class="flex items-center gap-2">
                    <button id="prev-flyer" class="w-11 h-11 rounded-full border border-outline-variant text-primary hover:bg-primary hover:text-on-primary hover:border-primary transition-all flex items-center justify-center disabled:opacity-30 disabled:pointer-events-none">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </button>
                    <button id="next-flyer" class="w-11 h-11 rounded-full border border-outline-variant text-primary hover:bg-primary hover:text-on-primary hover:border-primary transition-all flex items-center justify-center disabled:opacity-30 disabled:pointer-events-none">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>
                </div>
            </div>
        </div>
        
        <div id="flyer-carousel" class="flex overflow-x-auto scroll-smooth snap-x snap-mandatory gap-6 pb-6 -mx-4 px-4 md:mx-0 md:px-0 scrollbar-hide">
            <?php if(!empty($flyer_promosi)): ?>
                <?php foreach($flyer_promosi as $flyer): ?>
                    <div class="flex-none w-[280px] md:w-[320px] snap-start">
                        <a href="<?= tenant_url('flayer/' . esc($flyer['uuid'])) ?>" class="group relative block aspect-[3/4] bg-surface rounded-2xl overflow-hidden border-4 border-surface shadow-lg hover:shadow-xl transition-all duration-300">
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
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="w-full text-center py-16 bg-surface-container-lowest rounded-2xl border-2 border-dashed border-outline-variant">
                    <span class="material-symbols-outlined text-[56px] text-outline mb-3">web_stories</span>
                    <p class="font-body-lg text-body-lg text-on-surface-variant">Belum ada media promosi kesehatan yang dipublikasikan.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="mb-section-gap">
        <div class="flex justify-between items-end mb-stack-lg">
            <h2 class="font-headline-lg text-headline-lg border-b-2 border-primary inline-block pb-2">Galeri Foto</h2>
            <a class="text-primary hover:text-on-primary-fixed-variant transition-colors font-label-md text-label-md flex items-center gap-1" href="<?= base_url(tenant()->pkm_slug . '/galeri') ?>">
                Lebih Banyak
                <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if(!empty($galeri_terbaru)): ?>
                <?php foreach(array_slice($galeri_terbaru, 0, 3) as $gal): ?>
                <!-- Gallery Card -->
                <div class="group relative rounded-xl overflow-hidden cursor-pointer shadow-sm hover:shadow-[0px_8px_24px_rgba(0,0,0,0.12)] transition-all duration-300" onclick='openGalleryModal(<?= htmlspecialchars(json_encode($gal['photos']), ENT_QUOTES, 'UTF-8') ?>)'>
                    <div class="aspect-[4/3] w-full">
                        <img alt="<?= esc($gal['judul']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" src="<?= esc($gal['sampul_url']) ?>"/>
                    </div>
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-inverse-surface/90 via-inverse-surface/40 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 w-full p-6 text-on-primary">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="material-symbols-outlined text-on-primary" style="font-size: 16px;">photo_library</span>
                            <span class="font-caption text-caption opacity-90"><?= esc($gal['jumlah_foto']) ?> Foto</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-lg leading-tight group-hover:underline underline-offset-4">
                            <?= esc($gal['judul']) ?>
                        </h3>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Belum ada galeri.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Link Terkait Section -->
    <section class="mb-section-gap">
        <div class="flex justify-between items-end mb-stack-lg">
            <h2 class="font-headline-lg text-headline-lg border-b-2 border-primary inline-block pb-2">Link Terkait</h2>
            <div class="hidden md:flex gap-2">
                <button id="btn-prev-link" class="w-10 h-10 flex items-center justify-center rounded-full bg-surface-container hover:bg-surface-container-highest text-on-surface transition-colors shadow-sm" aria-label="Previous">
                    <span class="material-symbols-outlined">chevron_left</span>
                </button>
                <button id="btn-next-link" class="w-10 h-10 flex items-center justify-center rounded-full bg-surface-container hover:bg-surface-container-highest text-on-surface transition-colors shadow-sm" aria-label="Next">
                    <span class="material-symbols-outlined">chevron_right</span>
                </button>
            </div>
        </div>

        <?php
        $link_terkait = [
            ['nama' => 'BPJS Kesehatan', 'url' => 'https://www.bpjs-kesehatan.go.id', 'logo' => 'assets/link_terkait/bpjs.png'],
            ['nama' => 'Satu Sehat', 'url' => 'https://satusehat.kemkes.go.id/', 'logo' => 'assets/link_terkait/satu_sehat.jpeg'],
            ['nama' => 'Dinas Kesehatan', 'url' => 'https://dinkes.sinjaikab.go.id/', 'logo' => 'assets/link_terkait/dinkes.png'],
            ['nama' => 'Humas Sinjai', 'url' => 'https://humas.sinjaikab.go.id/v1/', 'logo' => 'assets/link_terkait/humas.png'],
            ['nama' => 'Sinjaikab', 'url' => 'https://sinjaikab.go.id/web/', 'logo' => 'assets/link_terkait/sinjai.png'],
        ];
        ?>

        <div class="relative group" id="link-carousel-container">
            
            <div id="link-carousel" class="flex overflow-x-auto snap-x snap-mandatory gap-4 md:gap-6 pb-6 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none] scroll-smooth">
                <?php foreach ($link_terkait as $index => $link): ?>
                <!-- Card -->
                <div class="snap-start shrink-0 w-full sm:w-[calc(50%-0.5rem)] md:w-[calc(33.333%-1rem)] lg:w-[calc(25%-1.125rem)]">
                    <div class="bg-white/60 backdrop-blur-md rounded-[20px] p-6 border border-white/50 shadow-[0_8px_32px_0_rgba(31,38,135,0.07)] hover:shadow-[0_8px_32px_0_rgba(31,38,135,0.15)] hover:-translate-y-1 hover:scale-[1.03] transition-all duration-300 flex flex-col items-center text-center h-full group/card relative overflow-hidden">
                        <!-- Glassmorphism gradient accent -->
                        <div class="absolute -top-10 -right-10 w-24 h-24 bg-primary/10 rounded-full blur-2xl group-hover/card:bg-primary/20 transition-colors"></div>
                        
                        <div class="w-20 h-20 md:w-24 md:h-24 mb-4 bg-white rounded-full p-2 shadow-sm flex items-center justify-center overflow-hidden border border-outline-variant/30 z-10">
                            <img src="<?= base_url(esc($link['logo'])) ?>" alt="<?= esc($link['nama']) ?>" class="w-full h-full object-contain mix-blend-multiply group-hover/card:scale-110 transition-transform duration-300">
                        </div>
                        <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold mb-4 line-clamp-2 z-10"><?= esc($link['nama']) ?></h3>
                        <a href="<?= esc($link['url']) ?>" target="_blank" rel="noopener noreferrer" class="mt-auto px-5 py-2.5 bg-surface-container text-primary hover:bg-primary hover:text-on-primary rounded-full font-label-md text-label-md transition-colors flex items-center gap-2 shadow-sm hover:shadow-md z-10">
                            Kunjungi Website
                            <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Indicators -->
            <div class="flex justify-center gap-2 mt-2" id="link-dots">
                <?php foreach ($link_terkait as $index => $link): ?>
                <button class="link-dot w-2 h-2 md:w-2.5 md:h-2.5 rounded-full transition-all duration-300 <?= $index === 0 ? 'bg-primary w-6' : 'bg-outline-variant hover:bg-primary/50' ?>" aria-label="Go to slide <?= $index + 1 ?>" data-index="<?= $index ?>"></button>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>

<script {csp-script-nonce}>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.carousel-slide');
    const dots = document.querySelectorAll('.carousel-dot');
    let slideInterval;

    function showSlide(index) {
        if (!slides.length) return;
        
        // Hide all slides
        slides.forEach(slide => {
            slide.classList.remove('opacity-100', 'z-10');
            slide.classList.add('opacity-0', 'z-0');
        });
        if(dots.length) {
            dots.forEach(dot => {
                dot.classList.remove('bg-primary', 'scale-125');
                dot.classList.add('bg-white/50');
            });
        }

        // Loop index
        if (index >= slides.length) currentSlide = 0;
        else if (index < 0) currentSlide = slides.length - 1;
        else currentSlide = index;

        // Show current slide
        slides[currentSlide].classList.remove('opacity-0', 'z-0');
        slides[currentSlide].classList.add('opacity-100', 'z-10');
        if(dots.length) {
            dots[currentSlide].classList.remove('bg-white/50');
            dots[currentSlide].classList.add('bg-primary', 'scale-125');
        }
    }

    function nextSlide() {
        showSlide(currentSlide + 1);
        resetInterval();
    }

    function prevSlide() {
        showSlide(currentSlide - 1);
        resetInterval();
    }

    function goToSlide(index) {
        showSlide(index);
        resetInterval();
    }

    function resetInterval() {
        clearInterval(slideInterval);
        startInterval();
    }

    function startInterval() {
        if (slides.length > 1) {
            slideInterval = setInterval(() => {
                showSlide(currentSlide + 1);
            }, 5000); // 5 seconds autoplay
        }
    }

    // Start autoplay on load
    startInterval();
</script>

<!-- Gallery Modal -->
<div id="gallery-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/95 backdrop-blur-sm opacity-0 transition-opacity duration-300">
    <div class="relative w-full h-full flex flex-col items-center justify-center p-4">
        <!-- Close Button -->
        <button onclick="closeGalleryModal()" class="absolute top-6 right-6 text-white hover:text-primary transition-colors p-2 bg-white/10 hover:bg-white/20 rounded-full z-10">
            <span class="material-symbols-outlined text-[28px]">close</span>
        </button>
        
        <!-- Navigation Left -->
        <button id="modal-prev-btn" onclick="prevGalleryImage()" class="absolute left-4 md:left-8 text-white hover:text-primary transition-colors p-3 bg-white/5 hover:bg-white/20 rounded-full z-10">
            <span class="material-symbols-outlined text-[36px]">chevron_left</span>
        </button>

        <!-- Main Image Area -->
        <div class="max-w-5xl w-full max-h-[85vh] flex flex-col items-center justify-center gap-4 relative">
            <img id="modal-image" src="" class="max-w-full max-h-[75vh] object-contain rounded-lg shadow-2xl transition-all duration-300" alt="Gallery Image">
            <p id="modal-caption" class="text-white text-center font-body-lg text-lg px-4 md:px-16 min-h-[2rem]"></p>
            <p id="modal-counter" class="absolute bottom-[-2.5rem] text-white/50 font-label-md tracking-widest"></p>
        </div>

        <!-- Navigation Right -->
        <button id="modal-next-btn" onclick="nextGalleryImage()" class="absolute right-4 md:right-8 text-white hover:text-primary transition-colors p-3 bg-white/5 hover:bg-white/20 rounded-full z-10">
            <span class="material-symbols-outlined text-[36px]">chevron_right</span>
        </button>
    </div>
</div>

<script {csp-script-nonce}>
    let currentGalleryPhotos = [];
    let currentPhotoIndex = 0;
    const galleryModal = document.getElementById('gallery-modal');
    const modalImage = document.getElementById('modal-image');
    const modalCaption = document.getElementById('modal-caption');
    const modalCounter = document.getElementById('modal-counter');

    function openGalleryModal(photos) {
        if (!photos || photos.length === 0) return;
        currentGalleryPhotos = photos;
        currentPhotoIndex = 0;
        
        updateModalContent();
        
        galleryModal.classList.remove('hidden');
        // trigger reflow for transition
        void galleryModal.offsetWidth;
        galleryModal.classList.remove('opacity-0');
        galleryModal.classList.add('flex');
        document.body.style.overflow = 'hidden'; // prevent scrolling
    }

    function closeGalleryModal() {
        galleryModal.classList.add('opacity-0');
        setTimeout(() => {
            galleryModal.classList.add('hidden');
            galleryModal.classList.remove('flex');
            document.body.style.overflow = '';
        }, 300);
    }

    function updateModalContent() {
        const photo = currentGalleryPhotos[currentPhotoIndex];
        
        // simple fade effect on image change
        modalImage.style.opacity = '0';
        setTimeout(() => {
            modalImage.src = photo.gambar_url;
            modalCaption.textContent = photo.caption || '';
            modalCounter.textContent = `${currentPhotoIndex + 1} / ${currentGalleryPhotos.length}`;
            modalImage.style.opacity = '1';
        }, 150);
    }

    function nextGalleryImage() {
        if (currentPhotoIndex < currentGalleryPhotos.length - 1) {
            currentPhotoIndex++;
        } else {
            currentPhotoIndex = 0; // loop back to first
        }
        updateModalContent();
    }

    function prevGalleryImage() {
        if (currentPhotoIndex > 0) {
            currentPhotoIndex--;
        } else {
            currentPhotoIndex = currentGalleryPhotos.length - 1; // loop to last
        }
        updateModalContent();
    }

    // Close on escape key and handle arrow keys for navigation
    document.addEventListener('keydown', function(event) {
        if (!galleryModal.classList.contains('hidden')) {
            if (event.key === "Escape") {
                closeGalleryModal();
            } else if (event.key === "ArrowRight") {
                nextGalleryImage();
            } else if (event.key === "ArrowLeft") {
                prevGalleryImage();
            }
        }
    });
</script>

<script {csp-script-nonce}>
function initFlyerCarousel() {
    const flyerCarousel = document.getElementById('flyer-carousel');
    if (!flyerCarousel) return;

    const btnNext = document.getElementById('next-flyer');
    const btnPrev = document.getElementById('prev-flyer');

    function getCardWidth() {
        const cardElement = flyerCarousel.children[0];
        if (!cardElement) return 0;
        const style = window.getComputedStyle(flyerCarousel);
        const gap = parseFloat(style.gap) || parseFloat(style.columnGap) || 0;
        return cardElement.offsetWidth + gap;
    }

    function updateButtons() {
        const scrollLeft = flyerCarousel.scrollLeft;
        const maxScroll = flyerCarousel.scrollWidth - flyerCarousel.clientWidth;
        
        if (btnPrev) btnPrev.disabled = scrollLeft <= 0;
        if (btnNext) btnNext.disabled = scrollLeft >= maxScroll - 5;
    }

    if (btnNext) {
        btnNext.addEventListener('click', () => {
            flyerCarousel.scrollBy({ left: getCardWidth(), behavior: 'smooth' });
        });
    }

    if (btnPrev) {
        btnPrev.addEventListener('click', () => {
            flyerCarousel.scrollBy({ left: -getCardWidth(), behavior: 'smooth' });
        });
    }

    flyerCarousel.addEventListener('scroll', updateButtons, { passive: true });
    window.addEventListener('resize', updateButtons);
    
    // Initial check
    setTimeout(updateButtons, 100);
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initFlyerCarousel);
} else {
    initFlyerCarousel();
}

function initLinkCarousel() {
    const linkCarousel = document.getElementById('link-carousel');
    if (!linkCarousel) return;

    const linkContainer = document.getElementById('link-carousel-container');
    const linkDots = document.querySelectorAll('.link-dot');
    const btnNext = document.getElementById('btn-next-link');
    const btnPrev = document.getElementById('btn-prev-link');
    
    const totalLinks = <?= count($link_terkait ?? []) ?>;
    let currentLinkIndex = 0;
    let linkAutoplayInterval;

    function updateLinkDots(index) {
        linkDots.forEach((dot, i) => {
            if (i === index) {
                dot.classList.remove('bg-outline-variant', 'w-2', 'md:w-2.5');
                dot.classList.add('bg-primary', 'w-6');
            } else {
                dot.classList.remove('bg-primary', 'w-6');
                dot.classList.add('bg-outline-variant', 'w-2', 'md:w-2.5');
            }
        });
    }

    function getCardWidth() {
        const cardElement = linkCarousel.children[0];
        if (!cardElement) return 0;
        const style = window.getComputedStyle(linkCarousel);
        const gap = parseFloat(style.gap) || parseFloat(style.columnGap) || 0;
        return cardElement.offsetWidth + gap;
    }

    function scrollToLinkIndex(index) {
        const itemWidth = getCardWidth();
        if (itemWidth === 0) return;
        
        linkCarousel.scrollTo({
            left: index * itemWidth,
            behavior: 'smooth'
        });
        
        currentLinkIndex = index;
        updateLinkDots(index);
    }

    function nextLinkSlide() {
        const containerWidth = linkCarousel.offsetWidth;
        const cardElement = linkCarousel.children[0];
        if (!cardElement) return;
        const itemsPerView = Math.round(containerWidth / cardElement.offsetWidth) || 1;
        
        if (currentLinkIndex >= totalLinks - itemsPerView) {
            currentLinkIndex = 0; // Loop back
        } else {
            currentLinkIndex++;
        }
        scrollToLinkIndex(currentLinkIndex);
    }

    function prevLinkSlide() {
        if (currentLinkIndex <= 0) {
            const containerWidth = linkCarousel.offsetWidth;
            const cardElement = linkCarousel.children[0];
            if (!cardElement) return;
            const itemsPerView = Math.round(containerWidth / cardElement.offsetWidth) || 1;
            currentLinkIndex = Math.max(0, totalLinks - itemsPerView);
        } else {
            currentLinkIndex--;
        }
        scrollToLinkIndex(currentLinkIndex);
    }

    function pauseLinkCarousel() {
        clearInterval(linkAutoplayInterval);
    }

    function resumeLinkCarousel() {
        pauseLinkCarousel(); // clear existing first
        linkAutoplayInterval = setInterval(nextLinkSlide, 4000); // 4 seconds autoplay
    }

    // Attach Event Listeners
    if (btnNext) btnNext.addEventListener('click', nextLinkSlide);
    if (btnPrev) btnPrev.addEventListener('click', prevLinkSlide);

    linkDots.forEach((dot) => {
        dot.addEventListener('click', function() {
            const index = parseInt(this.getAttribute('data-index'));
            scrollToLinkIndex(index);
        });
    });

    if (linkContainer) {
        linkContainer.addEventListener('mouseenter', pauseLinkCarousel);
        linkContainer.addEventListener('mouseleave', resumeLinkCarousel);
        linkContainer.addEventListener('touchstart', pauseLinkCarousel, {passive: true});
        linkContainer.addEventListener('touchend', resumeLinkCarousel, {passive: true});
    }

    linkCarousel.addEventListener('scroll', () => {
        const scrollLeft = linkCarousel.scrollLeft;
        const itemWidth = getCardWidth();
        if (itemWidth === 0) return;
        
        const newIndex = Math.round(scrollLeft / itemWidth);
        if (newIndex !== currentLinkIndex && newIndex < totalLinks && newIndex >= 0) {
            currentLinkIndex = newIndex;
            updateLinkDots(currentLinkIndex);
        }
    }, { passive: true });

    // Start autoplay
    resumeLinkCarousel();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLinkCarousel);
} else {
    initLinkCarousel();
}
</script>

<?= $this->endSection() ?>
