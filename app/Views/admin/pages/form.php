<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-container_max_width mx-auto pb-10">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="font-headline-lg text-headline-lg text-on-surface"><?= esc($title) ?></h2>
        <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/pages') ?>" class="text-outline-variant hover:text-on-surface transition-colors flex items-center gap-2">
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
        <form action="<?= isset($page) ? base_url('admin/' . tenant()->pkm_slug . '/pages/update/' . $page['page_uuid']) : base_url('admin/' . tenant()->pkm_slug . '/pages/store') ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Kiri: Form Utama -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Judul -->
                    <div>
                        <label for="judul" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Judul Halaman <span class="text-error">*</span></label>
                        <input type="text" id="judul" name="judul" value="<?= esc(old('judul', $page['judul'] ?? '')) ?>" required
                            class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all">
                    </div>

                    <!-- Konten -->
                    <div>
                        <label for="konten" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Isi Konten <span class="text-error">*</span></label>
                        <textarea id="konten" name="konten" rows="15"
                            class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all"><?= old('konten', $page['konten'] ?? '') ?></textarea>
                    </div>
                </div>

                <!-- Kanan: Sidebar Form -->
                <div class="space-y-6">
                    <?php if (isset($list_pkm)): ?>
                    <!-- PKM (Super Admin Only) -->
                    <div class="bg-surface p-4 rounded border border-surface-variant">
                        <label for="pkm_id" class="block font-label-sm text-label-sm text-on-surface-variant mb-2">Pilih PKM <span class="text-error">*</span></label>
                        <select id="pkm_id" name="pkm_id" required class="w-full bg-surface-container-lowest border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-3 py-2 cursor-pointer">
                            <option value="" disabled <?= old('pkm_id', $page['pkm_id'] ?? '') === '' ? 'selected' : '' ?>>-- Pilih PKM --</option>
                            <?php foreach ($list_pkm as $pkm): ?>
                                <option value="<?= esc($pkm['pkm_id']) ?>" <?= old('pkm_id', $page['pkm_id'] ?? '') == $pkm['pkm_id'] ? 'selected' : '' ?>><?= esc($pkm['pkm_nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>

                    <!-- Status -->
                    <div class="bg-surface p-4 rounded border border-surface-variant">
                        <label for="status" class="block font-label-sm text-label-sm text-on-surface-variant mb-2">Status Publikasi <span class="text-error">*</span></label>
                        <select id="status" name="status" class="w-full bg-surface-container-lowest border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-3 py-2 cursor-pointer">
                            <option value="Diterbitkan" <?= old('status', $page['status'] ?? '') === 'Diterbitkan' ? 'selected' : '' ?>>Diterbitkan</option>
                            <option value="Draf" <?= old('status', $page['status'] ?? '') === 'Draf' ? 'selected' : '' ?>>Draf</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="pt-6 mt-6 border-t border-surface-variant flex justify-end gap-3">
                <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/pages') ?>" class="px-4 py-2 rounded font-data-table text-data-table text-on-surface hover:bg-surface-container-high transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-primary text-on-primary px-6 py-2 rounded font-data-table text-data-table hover:shadow-sm hover:-translate-y-[1px] transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Simpan Halaman
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
document.addEventListener("DOMContentLoaded", function() {
    const {
        ClassicEditor,
        Essentials,
        Paragraph,
        Bold,
        Italic,
        Image,
        ImageInsert,
        ImageToolbar,
        ImageCaption,
        ImageStyle,
        Alignment,
        SourceEditing,
        Heading,
        List,
        Link,
        BlockQuote
    } = CKEDITOR;

    ClassicEditor
        .create(document.querySelector('#konten'), {
            licenseKey: 'GPL',
            plugins: [
                Essentials, Paragraph, Bold, Italic,
                Image, ImageInsert, ImageToolbar, ImageCaption, ImageStyle,
                Alignment, SourceEditing, Heading, List, Link, BlockQuote
            ],
            toolbar: [
                'undo', 'redo', '|',
                'sourceEditing', '|',
                'heading', '|',
                'bold', 'italic', '|',
                'alignment', '|',
                'bulletedList', 'numberedList', '|',
                'link', 'insertImage', 'blockQuote'
            ],
            image: {
                toolbar: [
                    'imageStyle:inline',
                    'imageStyle:block',
                    'imageStyle:side',
                    '|',
                    'toggleImageCaption',
                    'imageTextAlternative'
                ],
                insert: {
                    type: 'auto'
                }
            }
        })
        .catch(error => {
            console.error(error);
        });
});
</script>
<?= $this->endSection() ?>
