<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-container_max_width mx-auto pb-10">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="font-headline-lg text-headline-lg text-on-surface"><?= esc($title) ?></h2>
        <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/artikel') ?>" class="text-outline-variant hover:text-on-surface transition-colors flex items-center gap-2">
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

    <div class="bg-surface-container-lowest border border-surface-variant rounded-lg p-[24px] level-1-surface">
        <form action="<?= isset($artikel) ? base_url('admin/' . tenant()->pkm_slug . '/artikel/update/' . $artikel['artikel_id']) : base_url('admin/' . tenant()->pkm_slug . '/artikel/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Kiri: Form Utama -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Judul -->
                    <div>
                        <label for="judul" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Judul Artikel <span class="text-error">*</span></label>
                        <input type="text" id="judul" name="judul" value="<?= old('judul', $artikel['judul'] ?? '') ?>" required
                            class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all">
                    </div>

                    <!-- Abstrak -->
                    <div>
                        <label for="abstrak" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Abstrak Singkat</label>
                        <textarea id="abstrak" name="abstrak" rows="3"
                            class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all"><?= old('abstrak', $artikel['abstrak'] ?? '') ?></textarea>
                        <p class="text-[12px] text-outline mt-1">Muncul di daftar berita atau halaman depan.</p>
                    </div>

                    <!-- Konten -->
                    <div>
                        <label for="konten" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Isi Konten <span class="text-error">*</span></label>
                        <textarea id="konten" name="konten" rows="15"
                            class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all"><?= old('konten', $artikel['konten'] ?? '') ?></textarea>
                    </div>
                </div>

                <!-- Kanan: Sidebar Form -->
                <div class="space-y-6">
                    <?php if (isset($list_pkm)): ?>
                    <!-- PKM (Super Admin Only) -->
                    <div class="bg-surface p-4 rounded border border-surface-variant">
                        <label for="pkm_id" class="block font-label-sm text-label-sm text-on-surface-variant mb-2">Pilih PKM <span class="text-error">*</span></label>
                        <select id="pkm_id" name="pkm_id" required class="w-full bg-surface-container-lowest border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-3 py-2 cursor-pointer">
                            <option value="" disabled <?= old('pkm_id', $artikel['pkm_id'] ?? '') === '' ? 'selected' : '' ?>>-- Pilih PKM --</option>
                            <?php foreach ($list_pkm as $pkm): ?>
                                <option value="<?= esc($pkm['pkm_id']) ?>" <?= old('pkm_id', $artikel['pkm_id'] ?? '') == $pkm['pkm_id'] ? 'selected' : '' ?>><?= esc($pkm['pkm_nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>

                    <!-- Status -->
                    <div class="bg-surface p-4 rounded border border-surface-variant">
                        <label for="status" class="block font-label-sm text-label-sm text-on-surface-variant mb-2">Status Publikasi</label>
                        <select id="status" name="status" class="w-full bg-surface-container-lowest border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-3 py-2 cursor-pointer">
                            <option value="Draf" <?= old('status', $artikel['status'] ?? '') === 'Draf' ? 'selected' : '' ?>>Draf</option>
                            <option value="Ditayangkan" <?= old('status', $artikel['status'] ?? '') === 'Ditayangkan' ? 'selected' : '' ?>>Ditayangkan</option>
                            <option value="Diarsipkan" <?= old('status', $artikel['status'] ?? '') === 'Diarsipkan' ? 'selected' : '' ?>>Diarsipkan</option>
                        </select>
                    </div>

                    <!-- Kategori -->
                    <div class="bg-surface p-4 rounded border border-surface-variant">
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-2">Kategori</label>
                        <div class="max-h-48 overflow-y-auto space-y-2">
                            <?php 
                                $oldVal = old('kategori_id');
                                if ($oldVal === null) {
                                    $selectedCats = $artikel_kategori ?? [];
                                } else {
                                    $selectedCats = is_array($oldVal) ? $oldVal : [];
                                }
                            ?>
                            <?php foreach ($kategori as $kat): ?>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="kategori_id[]" value="<?= $kat['kategori_id'] ?>" 
                                        <?= in_array($kat['kategori_id'], $selectedCats) ? 'checked' : '' ?>
                                        class="cursor-pointer"
                                        style="appearance: auto; accent-color: var(--tenant-primary); width: 1.15rem; height: 1.15rem;">
                                    <span class="font-body-md text-body-md text-on-surface select-none"><?= esc($kat['nama']) ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Gambar Utama -->
                    <div class="bg-surface p-4 rounded border border-surface-variant">
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-2">Gambar Utama (Sampul)</label>
                        
                        <?php if (isset($artikel) && $artikel['gambar_utama']): ?>
                            <div class="mb-3">
                                <img src="<?= strpos($artikel['gambar_utama'], 'http') === 0 ? esc($artikel['gambar_utama']) : base_url(esc($artikel['gambar_utama'])) ?>" alt="Current Image" class="w-full h-auto rounded shadow-sm">
                            </div>
                        <?php endif; ?>
                        
                        <div class="flex items-center gap-4 mb-3">
                            <label class="flex items-center gap-1 cursor-pointer">
                                <input type="radio" name="sumber_gambar" value="upload" checked onchange="toggleGambar(this.value)" class="accent-primary cursor-pointer w-4 h-4">
                                <span class="text-[13px] text-on-surface">Upload File</span>
                            </label>
                            <label class="flex items-center gap-1 cursor-pointer">
                                <input type="radio" name="sumber_gambar" value="link" onchange="toggleGambar(this.value)" class="accent-primary cursor-pointer w-4 h-4">
                                <span class="text-[13px] text-on-surface">Masukkan Link</span>
                            </label>
                        </div>

                        <div id="gambar_upload_container">
                            <input type="file" id="gambar_utama" name="gambar_utama" accept="image/*"
                                class="block w-full text-sm text-outline
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-primary-container file:text-on-primary-container
                                    hover:file:bg-primary-fixed-dim cursor-pointer">
                            <p class="text-[12px] text-outline mt-2">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                        </div>

                        <div id="gambar_link_container" class="hidden">
                            <input type="url" name="gambar_utama_link" placeholder="https://..." class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-3 py-2 transition-all">
                            <p class="text-[12px] text-outline mt-2">Masukkan link / URL gambar lengkap.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6 mt-6 border-t border-surface-variant flex justify-end gap-3">
                <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/artikel') ?>" class="px-4 py-2 rounded font-data-table text-data-table text-on-surface hover:bg-surface-container-high transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-primary text-on-primary px-6 py-2 rounded font-data-table text-data-table hover:shadow-sm hover:-translate-y-[1px] transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">publish</span>
                    Simpan Artikel
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.ck-editor__editable_inline {
    min-height: 400px;
}
</style>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
function toggleGambar(val) {
    if (val === 'upload') {
        document.getElementById('gambar_upload_container').classList.remove('hidden');
        document.getElementById('gambar_link_container').classList.add('hidden');
    } else {
        document.getElementById('gambar_upload_container').classList.add('hidden');
        document.getElementById('gambar_link_container').classList.remove('hidden');
    }
}

document.addEventListener("DOMContentLoaded", function() {
    ClassicEditor
        .create(document.querySelector('#konten'))
        .catch(error => {
            console.error(error);
        });
});
</script>
<?= $this->endSection() ?>
