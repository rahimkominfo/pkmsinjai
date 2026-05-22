<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-container_max_width mx-auto pb-10">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="font-headline-lg text-headline-lg text-on-surface"><?= esc($title) ?></h2>
        <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/galeri') ?>" class="text-outline-variant hover:text-on-surface transition-colors flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('message')): ?>
        <div class="bg-primary-container text-on-primary-container p-4 rounded mb-4">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-error-container text-on-error-container p-4 rounded mb-6">
            <ul class="list-disc ml-5">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Utama Galeri -->
        <div class="lg:col-span-2 bg-surface-container-lowest border border-surface-variant rounded-lg p-[24px] level-1-surface">
            <form action="<?= isset($galeri) ? base_url('admin/' . tenant()->pkm_slug . '/galeri/update/' . $galeri['galeri_id']) : base_url('admin/' . tenant()->pkm_slug . '/galeri/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                <?= csrf_field() ?>

                <!-- Judul -->
                <div>
                    <label for="judul" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Judul Galeri <span class="text-error">*</span></label>
                    <input type="text" id="judul" name="judul" value="<?= old('judul', $galeri['judul'] ?? '') ?>" required
                        class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="deskripsi" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Deskripsi Singkat</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3"
                        class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all"><?= old('deskripsi', $galeri['deskripsi'] ?? '') ?></textarea>
                </div>

                <!-- Sampul -->
                <div>
                    <label for="sampul_url" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Foto Sampul Utama <?= isset($galeri) ? '<span class="text-outline-variant font-normal">(Opsional)</span>' : '<span class="text-error">*</span>' ?></label>
                    <?php if (isset($galeri) && $galeri['sampul_url']): ?>
                        <div class="mb-3">
                            <img src="<?= base_url(esc($galeri['sampul_url'])) ?>" alt="Sampul" class="w-48 h-auto rounded shadow-sm border border-outline-variant">
                        </div>
                    <?php endif; ?>
                    <input type="file" id="sampul_url" name="sampul_url" accept="image/*" <?= !isset($galeri) ? 'required' : '' ?>
                        class="block w-full text-sm text-outline
                            file:mr-4 file:py-2 file:px-4
                            file:rounded file:border-0
                            file:text-sm file:font-semibold
                            file:bg-primary-container file:text-on-primary-container
                            hover:file:bg-primary-fixed-dim cursor-pointer">
                </div>

                <!-- Upload Banyak Foto -->
                <div class="border-t border-surface-variant pt-6 mt-6">
                    <label for="foto" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Unggah Foto-foto Tambahan <span class="text-outline-variant font-normal">(Bisa pilih banyak sekaligus)</span></label>
                    <input type="file" id="foto" name="foto[]" multiple accept="image/*"
                        class="block w-full text-sm text-outline
                            file:mr-4 file:py-2 file:px-4
                            file:rounded file:border-0
                            file:text-sm file:font-semibold
                            file:bg-secondary-container file:text-on-secondary-container
                            hover:file:bg-secondary-fixed-dim cursor-pointer border border-dashed border-outline-variant p-4 bg-surface">
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/galeri') ?>" class="px-4 py-2 rounded font-data-table text-data-table text-on-surface hover:bg-surface-container-high transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="bg-primary text-on-primary px-4 py-2 rounded font-data-table text-data-table hover:shadow-sm hover:-translate-y-[1px] transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Simpan Galeri
                    </button>
                </div>
            </form>
        </div>

        <!-- Sidebar / Daftar Foto Terunggah (Hanya Tampil Saat Edit) -->
        <?php if (isset($galeri)): ?>
        <div class="bg-surface-container-lowest border border-surface-variant rounded-lg p-[24px] level-1-surface">
            <h3 class="font-headline-sm text-headline-sm text-on-surface mb-4">Koleksi Foto</h3>
            <?php if (!empty($foto)): ?>
                <div class="grid grid-cols-2 gap-3">
                    <?php foreach ($foto as $img): ?>
                        <div class="relative group rounded overflow-hidden shadow-sm border border-outline-variant bg-black">
                            <img src="<?= base_url(esc($img['gambar_url'])) ?>" alt="Foto" class="w-full h-24 object-cover opacity-90 group-hover:opacity-75 transition-opacity">
                            <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/galeri/delete_foto/' . $img['galeri_gambar_id']) ?>" onclick="return confirm('Hapus foto ini?')" class="absolute top-1 right-1 bg-error text-on-error rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <span class="material-symbols-outlined text-[14px]">close</span>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="font-body-md text-outline-variant text-center py-6">Belum ada foto yang diunggah ke galeri ini.</p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
