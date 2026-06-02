<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>
<!-- Main Content Canvas -->
<main class="max-w-container-max mx-auto px-margin-mobile md:px-gutter py-stack-lg">
    <!-- Breadcrumb -->
    <nav aria-label="Breadcrumb" class="flex items-center text-on-surface-variant font-caption text-caption mb-stack-md">
        <a class="hover:text-primary transition-colors" href="<?= base_url(tenant()->pkm_slug) ?>">Beranda</a>
        <span class="material-symbols-outlined mx-2 text-[14px]">chevron_right</span>
        <span class="text-on-surface">Galeri Foto</span>
    </nav>
    <!-- Page Header -->
    <header class="mb-stack-lg">
        <h1 class="font-display-lg text-display-lg text-on-surface mb-stack-sm">Galeri Foto</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">Arsip visual dokumentasi pelayanan kesehatan, kegiatan posyandu, dan infrastruktur Puskesmas Balangnipa.</p>
    </header>
    
    <!-- Gallery Grid (Bento/Card Layout) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter mb-section-gap">
        <?php if(!empty($list_galeri)): ?>
            <?php foreach($list_galeri as $galeri): ?>
            <!-- Add data-images attribute to store JSON encoded images -->
            <article class="group cursor-pointer bg-surface rounded-xl overflow-hidden border border-outline-variant shadow-[0px_4px_20px_rgba(0,0,0,0.05)] hover:shadow-lg hover:-translate-y-1 transition-all duration-300 gallery-card"
                     data-title="<?= esc($galeri['judul'], 'attr') ?>"
                     data-images="<?= esc(json_encode($galeri['images']), 'attr') ?>">
                <div class="relative aspect-video overflow-hidden">
                    <img alt="<?= esc($galeri['judul']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="<?= strpos($galeri['sampul_url'], 'http') === 0 ? esc($galeri['sampul_url']) : base_url(esc($galeri['sampul_url'])) ?>"/>
                    <div class="absolute top-4 left-4 bg-primary text-on-primary font-caption text-caption px-2 py-1 rounded shadow">
                        <?= esc($galeri['jumlah_foto']) ?> Foto
                    </div>
                </div>
                <div class="p-stack-md">
                    <h2 class="font-headline-md text-headline-md text-on-surface mb-stack-sm group-hover:text-primary transition-colors line-clamp-2">
                        <?= esc($galeri['judul']) ?>
                    </h2>
                    <div class="flex items-center text-on-surface-variant font-caption text-caption gap-2">
                        <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                        <time datetime="<?= date('Y-m-d', strtotime($galeri['created_at'])) ?>">
                            <?= date('d M Y', strtotime($galeri['created_at'])) ?>
                        </time>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Belum ada galeri.</p>
        <?php endif; ?>
    </div>
</main>

<!-- Lightbox Modal -->
<div id="galleryModal" style="display: none; opacity: 0;" class="fixed inset-0 z-[9999] bg-black/95 backdrop-blur-md transition-opacity duration-300">
    <!-- Header -->
    <div class="absolute top-0 left-0 right-0 flex justify-between items-center p-4 text-white z-50">
        <h3 id="modalTitle" class="font-headline-md text-lg truncate pr-4">Judul Galeri</h3>
        <button id="closeModal" class="p-2 hover:bg-white/20 rounded-full transition-colors flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">close</span>
        </button>
    </div>
    
    <!-- Prev Button -->
    <button id="prevBtn" class="absolute left-2 md:left-6 top-1/2 -translate-y-1/2 z-50 p-2 md:p-3 bg-black/50 hover:bg-black/80 rounded-full text-white transition-all items-center justify-center cursor-pointer" style="display: none;">
        <span class="material-symbols-outlined text-3xl">chevron_left</span>
    </button>
    
    <!-- Next Button -->
    <button id="nextBtn" class="absolute right-2 md:right-6 top-1/2 -translate-y-1/2 z-50 p-2 md:p-3 bg-black/50 hover:bg-black/80 rounded-full text-white transition-all items-center justify-center cursor-pointer" style="display: none;">
        <span class="material-symbols-outlined text-3xl">chevron_right</span>
    </button>

    <!-- Main Content Area (Image container) -->
    <div id="modalContentArea" class="w-full h-full flex flex-col items-center justify-center pt-16 pb-24 px-12 md:px-24">
        <img id="modalImage" src="" alt="Gallery Image" class="max-w-full max-h-full object-contain rounded drop-shadow-2xl select-none" />
    </div>
    
    <!-- Footer Counter & Caption -->
    <div class="absolute bottom-0 left-0 right-0 p-4 text-center text-white z-50 bg-gradient-to-t from-black/90 to-transparent">
        <p id="modalCaption" class="text-white/90 font-body-md mb-2 min-h-[1.5rem]"></p>
        <div class="text-white/70 font-caption text-sm bg-black/50 inline-block px-3 py-1 rounded-full">
            <span id="currentImageIndex">1</span> / <span id="totalImages">1</span>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const galleryCards = document.querySelectorAll('.gallery-card');
    const modal = document.getElementById('galleryModal');
    const closeModalBtn = document.getElementById('closeModal');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    const modalImage = document.getElementById('modalImage');
    const modalCaption = document.getElementById('modalCaption');
    const modalTitle = document.getElementById('modalTitle');
    const currentImageIndexEl = document.getElementById('currentImageIndex');
    const totalImagesEl = document.getElementById('totalImages');
    
    let currentImages = [];
    let currentIndex = 0;

    function openModal(title, images) {
        if (!images || images.length === 0) {
            alert('Belum ada gambar pada galeri ini.');
            return;
        }
        
        currentImages = images;
        currentIndex = 0;
        
        modalTitle.textContent = title;
        totalImagesEl.textContent = images.length;
        
        updateModalContent();
        
        // Show modal
        modal.style.display = 'block';
        
        // Allow browser to render display:flex before fading in
        setTimeout(() => {
            modal.style.opacity = '1';
        }, 50);
        
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }
    
    function closeModal() {
        modal.style.opacity = '0';
        setTimeout(() => {
            modal.style.display = 'none';
            document.body.style.overflow = ''; // Restore scrolling
        }, 300);
    }
    
    function updateModalContent() {
        const imgData = currentImages[currentIndex];
        if (!imgData) return;
        
        let url = imgData.gambar_url;
        if (url && !url.startsWith('http')) {
            const baseUrl = '<?= rtrim(base_url(), '/') ?>/';
            url = baseUrl + (url.startsWith('/') ? url.substring(1) : url);
        }
        
        modalImage.src = url;
        modalCaption.textContent = imgData.caption || '';
        currentImageIndexEl.textContent = currentIndex + 1;
        
        if (currentImages.length <= 1) {
            prevBtn.style.display = 'none';
            nextBtn.style.display = 'none';
        } else {
            prevBtn.style.display = 'flex';
            nextBtn.style.display = 'flex';
        }
    }
    
    function showNext(e) {
        if (e) e.stopPropagation();
        if (currentImages.length <= 1) return;
        currentIndex = (currentIndex + 1) % currentImages.length;
        updateModalContent();
    }
    
    function showPrev(e) {
        if (e) e.stopPropagation();
        if (currentImages.length <= 1) return;
        currentIndex = (currentIndex - 1 + currentImages.length) % currentImages.length;
        updateModalContent();
    }
    
    galleryCards.forEach(card => {
        card.addEventListener('click', function(e) {
            e.preventDefault();
            const title = this.getAttribute('data-title');
            const imagesJson = this.getAttribute('data-images');
            
            if (imagesJson) {
                try {
                    const images = JSON.parse(imagesJson);
                    openModal(title, images);
                } catch (err) {
                    console.error('JSON Parse Error:', err);
                    alert('Gagal memuat data gambar.');
                }
            }
        });
    });
    
    closeModalBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        closeModal();
    });
    
    nextBtn.addEventListener('click', showNext);
    prevBtn.addEventListener('click', showPrev);
    
    modal.addEventListener('click', function(e) {
        // Close if clicking outside the image or buttons
        if (e.target === modal || e.target.id === 'modalContentArea') {
            closeModal();
        }
    });
    
    document.addEventListener('keydown', function(e) {
        if (modal.style.display === 'none') return;
        if (e.key === 'Escape') closeModal();
        if (e.key === 'ArrowRight') showNext();
        if (e.key === 'ArrowLeft') showPrev();
    });
});
</script>
<?= $this->endSection() ?>
