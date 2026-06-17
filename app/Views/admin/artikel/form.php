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
        <form action="<?= isset($artikel) ? base_url('admin/' . tenant()->pkm_slug . '/artikel/update/' . $artikel['artikel_uuid']) : base_url('admin/' . tenant()->pkm_slug . '/artikel/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Kiri: Form Utama -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Judul -->
                    <div>
                        <label for="judul" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Judul Artikel <span class="text-error">*</span></label>
                        <input type="text" id="judul" name="judul" value="<?= esc(old('judul', $artikel['judul'] ?? '')) ?>" required
                            class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all">
                    </div>

                    <!-- Abstrak -->
                    <div>
                        <label for="abstrak" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Abstrak Singkat</label>
                        <textarea id="abstrak" name="abstrak" rows="3"
                            class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all"><?= esc(old('abstrak', $artikel['abstrak'] ?? '')) ?></textarea>
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

                    <!-- Tanggal Publikasi -->
                    <div class="bg-surface p-4 rounded border border-surface-variant">
                        <label for="tanggal_publikasi" class="block font-label-sm text-label-sm text-on-surface-variant mb-2">Tanggal Publikasi</label>
                        <input type="datetime-local" id="tanggal_publikasi" name="tanggal_publikasi" 
                            value="<?= old('tanggal_publikasi', isset($artikel['tanggal_publikasi']) ? date('Y-m-d\TH:i', strtotime($artikel['tanggal_publikasi'])) : date('Y-m-d\TH:i')) ?>"
                            class="w-full bg-surface-container-lowest border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-3 py-2 transition-all">
                        <p class="text-[11px] text-outline mt-1">Biarkan default jika ingin dipublikasikan sekarang.</p>
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

<style {csp-style-nonce}>
/* Override Tailwind's base svg display:block which breaks CKEditor UI */
.ck.ck-reset_all svg, .ck-body-wrapper svg {
    display: inline !important;
}

/* Base CKEditor UI styling */
.ck-editor__editable_inline {
    min-height: 400px;
    background-color: var(--surface-container-lowest, #ffffff) !important;
    border-bottom-left-radius: 0.375rem !important;
    border-bottom-right-radius: 0.375rem !important;
    color: var(--on-surface-variant, #333) !important;
    border: 1px solid var(--outline-variant, #ccc) !important;
    border-top: none !important;
}
.ck.ck-toolbar {
    border-top-left-radius: 0.375rem !important;
    border-top-right-radius: 0.375rem !important;
    background-color: var(--surface-container-low, #f3f4f6) !important;
    border: 1px solid var(--outline-variant, #ccc) !important;
}

/* Mengembalikan gaya dasar konten yang di-reset oleh Tailwind (hanya berlaku di dalam editor) */
.ck-content ul {
    list-style-type: disc !important;
    padding-left: 2em !important;
    margin-bottom: 1em !important;
}
.ck-content ol {
    list-style-type: decimal !important;
    padding-left: 2em !important;
    margin-bottom: 1em !important;
}
.ck-content li {
    display: list-item !important;
    margin-bottom: 0.25em !important;
}
.ck-content h2 { font-size: 1.5em !important; font-weight: bold !important; margin-top: 1em !important; margin-bottom: 0.5em !important; }
.ck-content h3 { font-size: 1.25em !important; font-weight: bold !important; margin-top: 1em !important; margin-bottom: 0.5em !important; }
.ck-content h4 { font-size: 1.1em !important; font-weight: bold !important; margin-top: 1em !important; margin-bottom: 0.5em !important; }
.ck-content blockquote {
    border-left: 4px solid #ccc !important;
    padding-left: 1em !important;
    margin-left: 0 !important;
    font-style: italic !important;
    color: #555 !important;
}
.ck-content a { color: #2563eb !important; text-decoration: underline !important; }
.ck-content p { margin-bottom: 1em !important; }
</style>

<style id="csp-nonce-source" {csp-style-nonce}></style>
<script {csp-script-nonce}>
(function() {
    var styleTag = document.getElementById('csp-nonce-source');
    if (styleTag && styleTag.nonce) {
        var cspNonce = styleTag.nonce;
        var originalCreateElement = document.createElement;
        document.createElement = function(tagName) {
            var el = originalCreateElement.apply(this, arguments);
            if (tagName.toLowerCase() === 'style') {
                el.setAttribute('nonce', cspNonce);
            }
            return el;
        };
    }
})();
</script>

<link rel="stylesheet" href="<?= base_url('assets/ckeditor/ckeditor5.css') ?>" {csp-style-nonce}>
<script src="<?= base_url('assets/ckeditor/ckeditor5.umd.js') ?>" {csp-script-nonce}></script>
<script {csp-script-nonce}>
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
    const {
        ClassicEditor,
        Essentials,
        Paragraph,
        Bold,
        Italic,
        Image,
        ImageToolbar,
        ImageCaption,
        ImageStyle,
        ImageUpload,
        SimpleUploadAdapter,
        Alignment,
        SourceEditing,
        Heading,
        List,
        Link,
        BlockQuote
    } = CKEDITOR;

    let editorInstance;

    ClassicEditor
        .create(document.querySelector('#konten'), {
            licenseKey: 'GPL',
            plugins: [
                Essentials, Paragraph, Bold, Italic,
                Image, ImageToolbar, ImageCaption, ImageStyle, ImageUpload, SimpleUploadAdapter,
                Alignment, SourceEditing, Heading, List, Link, BlockQuote
            ],
            toolbar: [
                'undo', 'redo', '|',
                'sourceEditing', '|',
                'heading', '|',
                'bold', 'italic', '|',
                'alignment', '|',
                'bulletedList', 'numberedList', '|',
                'link', 'uploadImage', 'blockQuote'
            ],
            simpleUpload: {
                uploadUrl: '<?= base_url('admin/' . tenant()->pkm_slug . '/media/upload-ckeditor') ?>',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[id="csrf-token"]').getAttribute('content'),
                }
            },
            image: {
                toolbar: [
                    'imageStyle:inline',
                    'imageStyle:block',
                    'imageStyle:side',
                    '|',
                    'toggleImageCaption',
                    'imageTextAlternative'
                ]
            }
        })
        .then(editor => {
            editorInstance = editor;
        })
        .catch(error => {
            console.error(error);
        });

    // ModSecurity Bypass: Encode content to Base64 before submit
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        if (editorInstance) {
            const rawData = editorInstance.getData();
            if (rawData) {
                // Encode UTF-8 string to Base64
                const encodedData = btoa(unescape(encodeURIComponent(rawData)));
                // Update the textarea with encoded data
                document.querySelector('#konten').value = encodedData;
            }
        }
    });
});
</script>
<?= $this->endSection() ?>
