<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Portal PKM Sinjai</title>
    <link href="<?= base_url('css/app.css') ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center h-screen">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="px-8 py-10">
            <div class="text-center mb-8">
                <span class="material-symbols-outlined text-teal-600 text-6xl mb-2">admin_panel_settings</span>
                <h1 class="text-2xl font-bold text-gray-800">Login Admin</h1>
                <p class="text-gray-500 text-sm mt-1">Sistem Manajemen PKM Kabupaten Sinjai</p>
            </div>

            <?php if(session()->getFlashdata('msg')): ?>
                <div class="bg-red-50 text-red-600 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">error</span>
                    <span class="text-sm"><?= session()->getFlashdata('msg') ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login/process') ?>" method="POST">
                <?= csrf_field() ?>
                
                <div class="mb-5">
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-gray-400">person</span>
                        </div>
                        <input type="text" name="username" id="username" class="pl-10 w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-sm" placeholder="Masukkan username" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-gray-400">lock</span>
                        </div>
                        <input type="password" name="password" id="password" class="pl-10 w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-sm" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-medium py-2.5 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                    <span>Masuk</span>
                    <span class="material-symbols-outlined text-sm">login</span>
                </button>
            </form>
        </div>
        
        <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 text-center">
            <a href="<?= base_url() ?>" class="text-sm text-teal-600 hover:text-teal-700 font-medium inline-flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Kembali ke Beranda
            </a>
        </div>
    </div>

</body>
</html>
