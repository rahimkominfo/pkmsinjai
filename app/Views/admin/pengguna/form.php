<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<div class="max-w-container_max_width mx-auto">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="font-headline-lg text-headline-lg text-on-surface"><?= esc($title) ?></h2>
        <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/pengguna') ?>" class="text-outline-variant hover:text-on-surface transition-colors flex items-center gap-2">
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

    <div class="bg-surface-container-lowest border border-surface-variant rounded-lg p-[24px] level-1-surface max-w-3xl">
        <form action="<?= isset($user) ? base_url('admin/' . tenant()->pkm_slug . '/pengguna/update/' . $user['user_id']) : base_url('admin/' . tenant()->pkm_slug . '/pengguna/store') ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Username -->
                <div>
                    <label for="username" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Username <span class="text-error">*</span></label>
                    <input type="text" id="username" name="username" value="<?= old('username', $user['username'] ?? '') ?>" required
                        class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all">
                </div>

                <!-- PKM / Tenant -->
                <div>
                    <label for="pkm_id" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Asal PKM (Tenant) <span class="text-error">*</span></label>
                    <select id="pkm_id" name="pkm_id" required class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all cursor-pointer">
                        <option value="">-- Pilih PKM --</option>
                        <option value="super" <?= old('pkm_id', $user['pkm_id'] ?? '') === null ? 'selected' : '' ?>>Bukan Spesifik PKM (Super Admin)</option>
                        <?php foreach ($pkms as $pkm_item): ?>
                            <option value="<?= $pkm_item['pkm_id'] ?>" <?= old('pkm_id', $user['pkm_id'] ?? '') == $pkm_item['pkm_id'] ? 'selected' : '' ?>>
                                <?= esc($pkm_item['pkm_nama']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Email <span class="text-error">*</span></label>
                    <input type="email" id="email" name="email" value="<?= old('email', $user['email'] ?? '') ?>" required
                        class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all">
                </div>

                <!-- Nama Publik -->
                <div>
                    <label for="nama_publik" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Nama Publik <span class="text-error">*</span></label>
                    <input type="text" id="nama_publik" name="nama_publik" value="<?= old('nama_publik', $user['nama_publik'] ?? '') ?>" required
                        class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all">
                </div>

                <!-- Peran -->
                <div>
                    <label for="peran" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Peran <span class="text-error">*</span></label>
                    <select id="peran" name="peran" required class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all cursor-pointer">
                        <option value="Kontributor" <?= old('peran', $user['peran'] ?? '') === 'Kontributor' ? 'selected' : '' ?>>Kontributor</option>
                        <option value="Editor" <?= old('peran', $user['peran'] ?? '') === 'Editor' ? 'selected' : '' ?>>Editor</option>
                        <option value="Admin" <?= old('peran', $user['peran'] ?? '') === 'Admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>
                
                <!-- Password -->
                <div class="md:col-span-2">
                    <label for="password" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Password <?= isset($user) ? '<span class="text-outline-variant font-normal">(Kosongkan jika tidak ingin mengubah)</span>' : '<span class="text-error">*</span>' ?></label>
                    <input type="password" id="password" name="password" <?= !isset($user) ? 'required' : '' ?>
                        class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all">
                </div>
            </div>

            <div class="pt-4 border-t border-surface-variant flex justify-end gap-3">
                <a href="<?= base_url('admin/' . tenant()->pkm_slug . '/pengguna') ?>" class="px-4 py-2 rounded font-data-table text-data-table text-on-surface hover:bg-surface-container-high transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-primary text-on-primary px-4 py-2 rounded font-data-table text-data-table hover:shadow-sm hover:-translate-y-[1px] transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
