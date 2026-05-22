<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-container_max_width mx-auto pb-10">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="font-headline-lg text-headline-lg text-on-surface"><?= esc($title) ?></h2>
        <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/pengaturan') ?>" class="text-outline-variant hover:text-on-surface transition-colors flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-error-container text-on-error-container p-4 rounded mb-6">
            <ul class="list-disc ml-5">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="bg-surface-container-lowest border border-surface-variant rounded-lg p-[24px] level-1-surface max-w-4xl">
        <form action="<?= isset($pkm) ? base_url('admin/' . tenant()->pkm_slug . '/pengaturan/update/' . $pkm['pkm_id']) : base_url('admin/' . tenant()->pkm_slug . '/pengaturan/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-surface-variant pb-6">
                <!-- Info Utama -->
                <div class="md:col-span-2">
                    <h3 class="font-headline-sm text-headline-sm text-on-surface mb-4">Informasi Dasar</h3>
                </div>

                <!-- Nama PKM -->
                <div class="md:col-span-2">
                    <label for="pkm_nama" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Nama Resmi PKM / Instansi <span class="text-error">*</span></label>
                    <input type="text" id="pkm_nama" name="pkm_nama" value="<?= old('pkm_nama', $pkm['pkm_nama'] ?? '') ?>" placeholder="Cth: PKM Balangnipa" required
                        class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all">
                    <p class="text-[12px] text-outline mt-1">Sistem akan membuat slug URL otomatis berdasarkan nama ini.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-surface-variant pb-6 pt-4">
                <div class="md:col-span-2">
                    <h3 class="font-headline-sm text-headline-sm text-on-surface mb-4">Identitas Visual (Tema)</h3>
                </div>

                <!-- Warna Tema -->
                <div>
                    <label for="primary_color" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Warna Utama (Primary Color)</label>
                    <div class="flex items-center gap-3">
                        <input type="color" id="primary_color" name="primary_color" value="<?= old('primary_color', $pkm['primary_color'] ?? '#006c4a') ?>"
                            class="w-12 h-10 bg-surface border border-surface-variant rounded focus:border-primary outline-none cursor-pointer p-1">
                        <p class="text-[12px] text-outline">Warna ini akan mendominasi desain UI bagian depan (Tenant).</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                <div class="md:col-span-2">
                    <h3 class="font-headline-sm text-headline-sm text-on-surface mb-2">Aset Media</h3>
                </div>

                <!-- Logo -->
                <div class="bg-surface p-4 rounded border border-surface-variant">
                    <label for="logo" class="block font-label-sm text-label-sm text-on-surface-variant mb-2">Logo PKM (Kotak/Bulat)</label>
                    
                    <?php if (isset($pkm) && $pkm['logo']): ?>
                        <div class="mb-3">
                            <img src="<?= base_url(esc($pkm['logo'])) ?>" alt="Logo PKM" class="w-24 h-24 object-contain rounded-full shadow-sm bg-white p-1 border border-outline-variant">
                        </div>
                    <?php endif; ?>
                    
                    <input type="file" id="logo" name="logo" accept="image/*"
                        class="block w-full text-sm text-outline
                            file:mr-4 file:py-2 file:px-4
                            file:rounded file:border-0
                            file:text-sm file:font-semibold
                            file:bg-primary-container file:text-on-primary-container
                            hover:file:bg-primary-fixed-dim cursor-pointer">
                    <p class="text-[12px] text-outline mt-2">Maks 1MB. Disarankan PNG transparan.</p>
                </div>

                <!-- Header Image -->
                <div class="bg-surface p-4 rounded border border-surface-variant">
                    <label for="header_img" class="block font-label-sm text-label-sm text-on-surface-variant mb-2">Gambar Header/Banner (Landscape)</label>
                    
                    <?php if (isset($pkm) && $pkm['header_img']): ?>
                        <div class="mb-3">
                            <img src="<?= base_url(esc($pkm['header_img'])) ?>" alt="Header Banner" class="w-full h-24 object-cover rounded shadow-sm border border-outline-variant">
                        </div>
                    <?php endif; ?>
                    
                    <input type="file" id="header_img" name="header_img" accept="image/*"
                        class="block w-full text-sm text-outline
                            file:mr-4 file:py-2 file:px-4
                            file:rounded file:border-0
                            file:text-sm file:font-semibold
                            file:bg-primary-container file:text-on-primary-container
                            hover:file:bg-primary-fixed-dim cursor-pointer">
                    <p class="text-[12px] text-outline mt-2">Maks 2MB. Untuk latar belakang header utama.</p>
                </div>
            </div>

            <div class="pt-6 mt-6 border-t border-surface-variant flex justify-end gap-3">
                <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/pengaturan') ?>" class="px-4 py-2 rounded font-data-table text-data-table text-on-surface hover:bg-surface-container-high transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-primary text-on-primary px-6 py-2 rounded font-data-table text-data-table hover:shadow-sm hover:-translate-y-[1px] transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Simpan Identitas PKM
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
