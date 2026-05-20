<!-- TopNavBar -->
<nav class="bg-surface-container-lowest dark:bg-inverse-surface border-b border-outline-variant dark:border-outline shadow-sm docked full-width top-0 sticky z-50">
    <div class="flex justify-between items-center w-full px-6 py-4 max-w-container-max mx-auto">
        <div class="flex items-center gap-6">
            <a class="font-headline-md text-headline-md font-black tracking-tight text-on-surface dark:text-on-primary-fixed" href="<?= base_url() ?>">PKM BALANGNIPA</a>
            <div class="hidden md:flex gap-6 items-center">
                <a class="text-primary dark:text-primary-fixed font-bold border-b-2 border-primary dark:border-primary-fixed pb-2 font-label-md text-label-md" href="<?= base_url() ?>">Beranda</a>

                <!-- Menu Profil -->
                <div class="relative group">
                    <button class="flex items-center gap-1 text-on-surface-variant dark:text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md py-2">
                        Profil
                        <span class="material-symbols-outlined text-[18px]">expand_more</span>
                    </button>
                    <div class="absolute left-0 mt-0 w-48 bg-white dark:bg-inverse-surface border border-outline-variant dark:border-outline rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                        <a href="#" class="block px-4 py-2 text-sm text-on-surface-variant hover:bg-surface-container-low hover:text-primary">Visi dan Misi</a>
                        <a href="#" class="block px-4 py-2 text-sm text-on-surface-variant hover:bg-surface-container-low hover:text-primary">Struktur Organisasi</a>
                    </div>
                </div>

                <!-- Menu Capaian Program Kesehatan -->
                <div class="relative group">
                    <button class="flex items-center gap-1 text-on-surface-variant dark:text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md py-2 text-left">
                        Capaian Program Kesehatan
                        <span class="material-symbols-outlined text-[18px]">expand_more</span>
                    </button>
                    <div class="absolute left-0 mt-0 w-56 bg-white dark:bg-inverse-surface border border-outline-variant dark:border-outline rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                        <a href="#" class="block px-4 py-2 text-sm text-on-surface-variant hover:bg-surface-container-low hover:text-primary">Cakupan Imunisasi</a>
                        <a href="#" class="block px-4 py-2 text-sm text-on-surface-variant hover:bg-surface-container-low hover:text-primary">Data Stunting</a>
                    </div>
                </div>

                <a class="text-on-surface-variant dark:text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md" href="#">Berita</a>
                <a class="text-on-surface-variant dark:text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md" href="#">Galeri</a>
                <a class="text-on-surface-variant dark:text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md" href="#">Edukasi Kesehatan Digital</a>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button class="text-on-surface-variant hover:text-primary transition-colors duration-200 hidden md:block">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">account_circle</span>
            </button>
        </div>
    </div>
</nav>
