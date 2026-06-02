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
                <?php if (session()->get('peran') === 'Admin Dinkes'): ?>
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
                <?php else: ?>
                    <input type="hidden" name="pkm_id" value="<?= esc(tenant()->pkm_id) ?>">
                <?php endif; ?>

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
                    <label for="peran_id" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Peran <span class="text-error">*</span></label>
                    <select id="peran_id" name="peran_id" required class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface px-4 py-2 transition-all cursor-pointer">
                        <?php foreach($roles as $r): ?>
                            <option value="<?= $r['peran_id'] ?>" <?= old('peran_id', $user['peran_id'] ?? '') == $r['peran_id'] ? 'selected' : '' ?>><?= esc($r['nama_peran']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- Password -->
                <div>
                    <label for="password" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Password <?= isset($user) ? '<span class="text-outline-variant font-normal">(Kosongkan jika tak ubah)</span>' : '<span class="text-error">*</span>' ?></label>
                    <div class="relative">
                        <input type="password" id="password" name="password" <?= !isset($user) ? 'required' : '' ?>
                            class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface pl-4 pr-10 py-2 transition-all">
                        <button type="button" onclick="togglePassword('password', 'icon-pass')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-on-surface-variant hover:text-primary transition-colors focus:outline-none">
                            <span id="icon-pass" class="material-symbols-outlined text-[20px]">visibility_off</span>
                        </button>
                    </div>
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="konfirmasi_password" class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Konfirmasi Password <?= !isset($user) ? '<span class="text-error">*</span>' : '<span class="text-outline-variant font-normal">(Isi jika ubah password)</span>' ?></label>
                    <div class="relative">
                        <input type="password" id="konfirmasi_password" name="konfirmasi_password" <?= !isset($user) ? 'required' : '' ?>
                            class="w-full bg-surface border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface pl-4 pr-10 py-2 transition-all">
                        <button type="button" onclick="togglePassword('konfirmasi_password', 'icon-confirm')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-on-surface-variant hover:text-primary transition-colors focus:outline-none">
                            <span id="icon-confirm" class="material-symbols-outlined text-[20px]">visibility_off</span>
                        </button>
                    </div>
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

<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = 'visibility';
    } else {
        input.type = 'password';
        icon.textContent = 'visibility_off';
    }
}
</script>
<?= $this->endSection() ?>
