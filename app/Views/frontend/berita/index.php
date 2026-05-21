<?= $this->extend('frontend/layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-container-max mx-auto px-margin-mobile md:px-gutter py-8">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 mb-8 text-on-surface-variant font-label-md text-label-md">
        <a class="hover:text-primary" href="<?= base_url() ?>">Beranda</a>
        <span class="material-symbols-outlined text-sm">chevron_right</span>
        <span class="text-primary font-bold">Berita Terkini</span>
    </nav>

    <!-- Page Header & Filters -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
        <div>
            <h1 class="font-headline-xl text-headline-xl mb-4 text-on-surface">Berita Terkini</h1>
            <div class="flex flex-wrap gap-2">
                <button class="px-6 py-2 bg-primary text-on-primary rounded-full font-label-md text-label-md">Semua</button>
                <button class="px-6 py-2 bg-surface-container text-on-surface-variant hover:bg-surface-variant rounded-full font-label-md text-label-md transition-colors">Gizi & KIA</button>
                <button class="px-6 py-2 bg-surface-container text-on-surface-variant hover:bg-surface-variant rounded-full font-label-md text-label-md transition-colors">Penyakit Menular</button>
                <button class="px-6 py-2 bg-surface-container text-on-surface-variant hover:bg-surface-variant rounded-full font-label-md text-label-md transition-colors">Promkes</button>
                <button class="px-6 py-2 bg-surface-container text-on-surface-variant hover:bg-surface-variant rounded-full font-label-md text-label-md transition-colors">Layanan</button>
            </div>
        </div>
        <div class="w-full md:w-80">
            <div class="relative">
                <input class="w-full bg-surface-container-lowest border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg px-4 py-3 pr-12 font-body-md text-body-md transition-all" placeholder="Cari topik spesifik..." type="text"/>
                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline">search</span>
            </div>
        </div>
    </div>

    <!-- News Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">
        <!-- Article Card 1 -->
        <article class="group bg-surface-container-lowest rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="relative aspect-video overflow-hidden">
                <img alt="Gizi News" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDYoNZ7CXDunqLmhK6a1Ayr-MKM2yEtzoGan8oBh2Hh5FxuRHA-nXtgu9xTvFlFTn9GAT6ZYgswvXPucnNT4xKJh3tIzK7Yg7oXFF3Xk72bDiHMwQ1uo8rzavXt7vJeQUYObMDn8OFRWhkZTob5b1eHnaPWBA9WHaKvsRXewgX2bTuDCt5h7ejk0N3U0-WuzwFxsMTuTgoxWmBveZcvCozntvfLYZ-oClaZI96rXSlhurHeA69q71rmG6JrRInQECcjHrl-Q2FQRnbB"/>
                <span class="absolute top-4 left-4 bg-primary text-on-primary px-3 py-1 rounded-full font-label-md text-label-md">Gizi & KIA</span>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-4 mb-3 text-caption font-caption text-on-surface-variant">
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">calendar_today</span> 12 Okt 2024</span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">person</span> Bidan Desa</span>
                </div>
                <h3 class="font-headline-md text-headline-md mb-3 text-on-surface group-hover:text-primary transition-colors leading-tight">Puskesmas Balangnipa Sukses Turunkan Angka Stunting 10%</h3>
                <p class="text-body-md font-body-md text-on-surface-variant line-clamp-3">Laporan terbaru menunjukkan bahwa program Pemberian Makanan Tambahan (PMT) berhasil menurunkan prevalensi balita stunting di wilayah kerja kami secara signifikan.</p>
            </div>
        </article>

        <!-- Article Card 2 -->
        <article class="group bg-surface-container-lowest rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="relative aspect-video overflow-hidden">
                <img alt="Penyakit Menular News" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDEJ2LgOSACjB3ZGx382r98WaCDMp95XBsrIGsIDTuneYE0ijTS43s6i9wm8TXDeOxvdyXGRwN-eWybs347Oi2Huu5Y3hm2WmWIv9IOpdX2CmKi2kmld6l0f1EM9HKVfyWtNqgNw77Ho_9Jke_Otl2qEZ5GFzp9MXl8iYHTYuf4ICpdwo4TiMZZkUBcAQAZOKEUqEcvEttGkqDFBL62OT2m8qer_RlTOsRJ9Yo6gOuGPIuyYGsDJtl3AfNWSCGtVS_S6fhjN7pYu0gH"/>
                <span class="absolute top-4 left-4 bg-primary text-on-primary px-3 py-1 rounded-full font-label-md text-label-md">Penyakit Menular</span>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-4 mb-3 text-caption font-caption text-on-surface-variant">
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">calendar_today</span> 11 Okt 2024</span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">person</span> Tim Promkes</span>
                </div>
                <h3 class="font-headline-md text-headline-md mb-3 text-on-surface group-hover:text-primary transition-colors leading-tight">Waspada Demam Berdarah di Musim Pancaroba</h3>
                <p class="text-body-md font-body-md text-on-surface-variant line-clamp-3">Masyarakat diimbau untuk kembali menggalakkan Gerakan 3M Plus sebagai bentuk antisipasi melonjaknya kasus DBD akibat cuaca yang tak menentu.</p>
            </div>
        </article>

        <!-- Article Card 3 -->
        <article class="group bg-surface-container-lowest rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="relative aspect-video overflow-hidden">
                <img alt="Promkes News" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAqkWB1FtDvXp2fxyYDoZNmihsgLFYpbwGtf1LvRHkcgi26BGGI-zKwl03SjXZZxdPE7vjSNEDQ8u8j5vmSDItjp9t2a0YWM5tqngr18m8sZDwwZIcsbXVqSlNXAH3zKp9vbyfpk9tbDX79FZ36rSwHQQcoJpenH3TfOjX56hIPyXUogVxWEQBF2W2VERN-W1xKyniKBsjwdBg3h5niyHiihEra62gWidlCW4Uw3nQ0P9nKKCw03s-co2lxkRyftOib5o-RNvaIYOF3"/>
                <span class="absolute top-4 left-4 bg-primary text-on-primary px-3 py-1 rounded-full font-label-md text-label-md">Promkes</span>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-4 mb-3 text-caption font-caption text-on-surface-variant">
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">calendar_today</span> 10 Okt 2024</span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">person</span> Siti Aminah</span>
                </div>
                <h3 class="font-headline-md text-headline-md mb-3 text-on-surface group-hover:text-primary transition-colors leading-tight">Senam Lansia Rutin Digelar Setiap Jumat Pagi</h3>
                <p class="text-body-md font-body-md text-on-surface-variant line-clamp-3">Program ini bertujuan untuk menjaga kebugaran dan kesehatan jantung bagi kelompok masyarakat lanjut usia di sekitar wilayah puskesmas.</p>
            </div>
        </article>

        <!-- Article Card 4 -->
        <article class="group bg-surface-container-lowest rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="relative aspect-video overflow-hidden">
                <img alt="Layanan News" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDKo0khtJE1svHiUskPeqpOGa-LWCq6ARfLp7gsq_6I5fM8-OHUJ7fC5hdoHXV7ddLY1uXiMXUNvdlUilO320tmI53DIdAevYMyi2tYFVPW6gEkT9wFuzOYfv80U1BSnCLarDvF32e5xZ8pl2N_85IUC6h0fJAHIHsrR8iTciPCHaka2dO3nLDgM6t4iASHNRJDp2eQNbNyssqiXsA-WlFELKTScIrrxmd1pN63TqB1NCLo-oKKME_BThwyDVt1zSqyxogEZdV1ps3q"/>
                <span class="absolute top-4 left-4 bg-primary text-on-primary px-3 py-1 rounded-full font-label-md text-label-md">Layanan</span>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-4 mb-3 text-caption font-caption text-on-surface-variant">
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">calendar_today</span> 09 Okt 2024</span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">person</span> Rama Putra</span>
                </div>
                <h3 class="font-headline-md text-headline-md mb-3 text-on-surface group-hover:text-primary transition-colors leading-tight">Pendaftaran Antrean Puskesmas Kini Bisa Lewat WhatsApp</h3>
                <p class="text-body-md font-body-md text-on-surface-variant line-clamp-3">Guna mengurangi penumpukan pasien di ruang tunggu, kami meluncurkan layanan pendaftaran online via WhatsApp mulai bulan ini.</p>
            </div>
        </article>

        <!-- Article Card 5 -->
        <article class="group bg-surface-container-lowest rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="relative aspect-video overflow-hidden">
                <img alt="Sains News" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBo7Dngy68DemxrOvWhrAcSsBbxmNHSvidEKC2mawxxVrg9TWIVEbRr8Cy7dEdnSWsGmBzKbHwkOVcF_itRWK5PovZFLRjxGcTBMtJX-xDYdh6kuVjUuGY8V2Jj3ktNjVH02Qs9f30MU-HAWgtKPMTAoCbFAguzSfUTLPd1wOj-_tvoMzbA5yvUO-g9JiD6O5q9HIAFTFxl6Y-ILwHbogDZRVh7jp-ewEp-lDk6cDg0-P8EvbJ64ljSvZZe-iTb92z7GWdAtbFwoUTk"/>
                <span class="absolute top-4 left-4 bg-primary text-on-primary px-3 py-1 rounded-full font-label-md text-label-md">Layanan Medis</span>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-4 mb-3 text-caption font-caption text-on-surface-variant">
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">calendar_today</span> 08 Okt 2024</span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">person</span> Dr. Haryono</span>
                </div>
                <h3 class="font-headline-md text-headline-md mb-3 text-on-surface group-hover:text-primary transition-colors leading-tight">Pentingnya Pemeriksaan Gigi Minimal 6 Bulan Sekali</h3>
                <p class="text-body-md font-body-md text-on-surface-variant line-clamp-3">Poli Gigi Puskesmas kini dilengkapi dengan peralatan terbaru. Kami mengimbau warga untuk rutin memeriksakan kesehatan mulut.</p>
            </div>
        </article>

        <!-- Article Card 6 -->
        <article class="group bg-surface-container-lowest rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="relative aspect-video overflow-hidden">
                <img alt="Imunisasi News" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDiLzyH-1_QF6i1BkfYtfkA65BXJt-QGgWJ2MNrJ17eQfCJcLX6v9qeIVo36ZyvmDa8GNuD9u9kAMzryn_T9f5VEtWElD25dpLoVqATy_YdUIyb7XDf_EiyXopN8-xoNiY0wOJ1ynAPRjRPmj_x31nMNQUzqkaVAmCq1pmGHq1th8qgB5M8NzIUY9TK-F_eaVZrtLktHt4zJe8eYMeVfxWEWTO30YcpEu1S5ZBZIeyV4gn3xanp7thhfZOuWPhhu5pJJpfmfwnMnsF7"/>
                <span class="absolute top-4 left-4 bg-primary text-on-primary px-3 py-1 rounded-full font-label-md text-label-md">Imunisasi</span>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-4 mb-3 text-caption font-caption text-on-surface-variant">
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">calendar_today</span> 07 Okt 2024</span>
                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">person</span> Lia Safitri</span>
                </div>
                <h3 class="font-headline-md text-headline-md mb-3 text-on-surface group-hover:text-primary transition-colors leading-tight">Pekan Imunisasi Nasional (PIN) Polio Sasar 5.000 Anak</h3>
                <p class="text-body-md font-body-md text-on-surface-variant line-clamp-3">Tenaga kesehatan disebar ke seluruh desa untuk memastikan seluruh anak di bawah usia 5 tahun mendapatkan tetes polio secara gratis.</p>
            </div>
        </article>
    </div>

    <!-- Pagination -->
    <div class="mt-section-gap flex justify-center items-center gap-2">
        <button class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant text-on-surface-variant hover:bg-primary hover:text-on-primary transition-all">
            <span class="material-symbols-outlined text-sm">chevron_left</span>
        </button>
        <button class="w-10 h-10 flex items-center justify-center rounded-lg bg-primary text-on-primary font-bold">1</button>
        <button class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container transition-all">2</button>
        <button class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container transition-all">3</button>
        <span class="px-2 text-outline">...</span>
        <button class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container transition-all">12</button>
        <button class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant text-on-surface-variant hover:bg-primary hover:text-on-primary transition-all">
            <span class="material-symbols-outlined text-sm">chevron_right</span>
        </button>
    </div>
</div>
<?= $this->endSection() ?>
