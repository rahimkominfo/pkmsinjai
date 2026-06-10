<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Status Antrian Section (View Cell) -->
<?= view_cell('App\Cells\AntrianCell::render') ?>

<!-- Hero Carousel Section -->
<section class="relative h-[450px] md:h-[600px] w-full overflow-hidden bg-surface-dim" id="hero-carousel">
    <!-- Carousel Slides -->
    <?php if (!empty($hero_artikel)): ?>
        <?php foreach ($hero_artikel as $index => $hero): ?>
        <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out carousel-slide <?= $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' ?>">
            <img alt="<?= esc($hero['judul']) ?>" class="w-full h-full object-cover" src="<?= strpos($hero['gambar_utama'], 'http') === 0 ? esc($hero['gambar_utama']) : base_url(esc($hero['gambar_utama'])) ?>"/>
            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
            <!-- Content Overlay -->
            <div class="absolute inset-0 flex flex-col justify-end pb-16 md:pb-24">
                <div class="max-w-container-max mx-auto px-margin-mobile md:px-gutter w-full">
                    <div class="max-w-3xl">
                        <span class="inline-block bg-primary text-on-primary px-3 py-1 rounded-full text-label-md font-label-md mb-4 shadow-lg"><?= esc($hero['nama_kategori'] ?? 'Berita') ?></span>
                        <h1 class="text-white font-headline-xl text-3xl md:text-5xl mb-4 leading-tight drop-shadow-md">
                            <?= esc($hero['judul']) ?>
                        </h1>
                        <p class="text-white/90 font-body-lg text-lg hidden md:block mb-6 line-clamp-2 drop-shadow-sm">
                            <?= esc($hero['abstrak']) ?>
                        </p>
                        <a href="<?= base_url(tenant()->pkm_slug . '/berita/detail/' . esc($hero['slug'])) ?>" class="inline-block bg-white text-primary px-6 py-3 rounded-lg font-label-md text-label-md hover:bg-surface-container transition-colors shadow-md">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Navigation Arrows -->
    <?php if (!empty($hero_artikel) && count($hero_artikel) > 1): ?>
    <div class="absolute inset-0 flex items-center justify-between px-4 md:px-8 z-20 pointer-events-none">
        <button onclick="prevSlide()" class="pointer-events-auto w-12 h-12 flex items-center justify-center rounded-full bg-white/20 hover:bg-white/40 backdrop-blur-md text-white transition-all">
            <span class="material-symbols-outlined">chevron_left</span>
        </button>
        <button onclick="nextSlide()" class="pointer-events-auto w-12 h-12 flex items-center justify-center rounded-full bg-white/20 hover:bg-white/40 backdrop-blur-md text-white transition-all">
            <span class="material-symbols-outlined">chevron_right</span>
        </button>
    </div>
    
    <!-- Carousel Indicators -->
    <div class="absolute bottom-8 left-0 right-0 z-20 flex justify-center gap-2">
        <?php foreach ($hero_artikel as $index => $hero): ?>
            <button onclick="goToSlide(<?= $index ?>)" class="carousel-dot w-3 h-3 rounded-full transition-all <?= $index === 0 ? 'bg-primary scale-125' : 'bg-white/50 hover:bg-white/80' ?>"></button>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
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
</div>

<script>
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

<script>
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

<?= $this->endSection() ?>
