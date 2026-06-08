<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= esc($title ?? 'PKM Balangnipa Admin Dashboard') ?></title>
    <!-- Google Fonts & Material Symbols -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <!-- Tailwind CSS Local -->
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <style>
        .level-1-surface {
            box-shadow: 0px 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        :root {
            --tenant-primary: <?= esc(tenant()->primary_color ?? '#eaddff') ?>;
            --tenant-on-primary: <?= esc(tenant()->on_primary_color ?? '#1f2937') ?>;
        }
        .sidebar-tenant {
            background-color: var(--tenant-primary);
        }
        .sidebar-tenant-text {
            color: var(--tenant-on-primary);
        }
        .sidebar-tenant-text-muted {
            color: var(--tenant-on-primary);
            opacity: 0.8;
        }
        .sidebar-tenant-link {
            color: var(--tenant-on-primary);
            opacity: 0.8;
            border-color: transparent;
        }
        .sidebar-tenant-link:hover {
            opacity: 1;
            background-color: rgba(255, 255, 255, 0.15);
        }
        .sidebar-tenant-link.active {
            opacity: 1;
            background-color: rgba(255, 255, 255, 0.15);
            border-left-color: var(--tenant-on-primary);
        }
    </style>
</head>
<body class="bg-background text-on-surface antialiased flex h-screen overflow-hidden">
    <!-- SideNavBar -->
    <aside id="sidebar" class="fixed h-screen w-sidebar_width left-0 top-0 shadow-lg md:shadow-sm flex flex-col h-full py-base z-30 sidebar-tenant -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
        <!-- Brand Header -->
        <div class="px-6 py-6 mb-4 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <img alt="<?= esc(tenant()->pkm_nama ?? 'Portal Admin') ?> Logo" class="w-10 h-10 object-contain" src="<?= base_url('assets/img/logo_sinjai.png') ?>"/>
                <div>
                    <h1 class="text-headline-sm font-headline-sm font-bold sidebar-tenant-text"><?= esc(tenant()->pkm_nama ?? 'Portal Admin') ?></h1>
                    <p class="font-label-sm text-label-sm sidebar-tenant-text-muted mt-1 uppercase tracking-wider"><?= session()->get('peran') ?></p>
                </div>
            </div>
            <!-- Close Button for Mobile -->
            <button id="sidebar-close" class="md:hidden text-sidebar-tenant-text opacity-70 hover:opacity-100 transition-opacity">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <!-- Navigation Links -->
        <nav class="flex-1 flex flex-col gap-1 overflow-y-auto">
            <?php 
            $role = session()->get('peran'); 
            $currentURL = current_url();
            
            // Function to check active state
            $isActive = function($path) use ($currentURL) {
                return strpos($currentURL, $path) !== false ? 'active' : '';
            };
            ?>

            <a class="flex items-center gap-3 px-6 py-3 font-label-sm text-label-sm transition-all duration-200 ease-in-out border-l-4 sidebar-tenant-link <?= $isActive('admin/'.tenant()->pkm_slug.'/dashboard') ?>" href="<?= base_url('admin/' . tenant()->pkm_slug . '/dashboard') ?>">
                <span class="material-symbols-outlined text-[20px]">dashboard</span>
                Dashboard
            </a>

            <?php if(in_array($role, ['Admin Dinkes', 'Admin PKM', 'Editor', 'Penulis'])): ?>
            <a class="flex items-center gap-3 px-6 py-3 font-label-sm text-label-sm transition-all duration-200 ease-in-out border-l-4 sidebar-tenant-link <?= $isActive('admin/'.tenant()->pkm_slug.'/artikel') ?>" href="<?= base_url('admin/' . tenant()->pkm_slug . '/artikel') ?>">
                <span class="material-symbols-outlined text-[20px]">article</span>
                Artikel Berita
            </a>
            <a class="flex items-center gap-3 px-6 py-3 font-label-sm text-label-sm transition-all duration-200 ease-in-out border-l-4 sidebar-tenant-link <?= $isActive('admin/'.tenant()->pkm_slug.'/media') ?>" href="<?= base_url('admin/' . tenant()->pkm_slug . '/media') ?>">
                <span class="material-symbols-outlined text-[20px]">perm_media</span>
                Media
            </a>
            <?php endif; ?>

            <?php if(in_array($role, ['Admin Dinkes', 'Admin PKM', 'Editor'])): ?>
            <a class="flex items-center gap-3 px-6 py-3 font-label-sm text-label-sm transition-all duration-200 ease-in-out border-l-4 sidebar-tenant-link <?= $isActive('admin/'.tenant()->pkm_slug.'/kategori') ?>" href="<?= base_url('admin/' . tenant()->pkm_slug . '/kategori') ?>">
                <span class="material-symbols-outlined text-[20px]">category</span>
                Kategori
            </a>
            <a class="flex items-center gap-3 px-6 py-3 font-label-sm text-label-sm transition-all duration-200 ease-in-out border-l-4 sidebar-tenant-link <?= $isActive('admin/'.tenant()->pkm_slug.'/galeri') ?>" href="<?= base_url('admin/' . tenant()->pkm_slug . '/galeri') ?>">
                <span class="material-symbols-outlined text-[20px]">imagesmode</span>
                Galeri
            </a>
            <?php endif; ?>

            <?php if(in_array($role, ['Admin Dinkes', 'Admin PKM'])): ?>
            <a class="flex items-center gap-3 px-6 py-3 font-label-sm text-label-sm transition-all duration-200 ease-in-out border-l-4 sidebar-tenant-link <?= $isActive('admin/'.tenant()->pkm_slug.'/antrian') ?>" href="<?= base_url('admin/' . tenant()->pkm_slug . '/antrian') ?>">
                <span class="material-symbols-outlined text-[20px]">confirmation_number</span>
                Antrian
            </a>
            <a class="flex items-center gap-3 px-6 py-3 font-label-sm text-label-sm transition-all duration-200 ease-in-out border-l-4 sidebar-tenant-link <?= $isActive('admin/'.tenant()->pkm_slug.'/pengguna') ?>" href="<?= base_url('admin/' . tenant()->pkm_slug . '/pengguna') ?>">
                <span class="material-symbols-outlined text-[20px]">group</span>
                Pengguna
            </a>
            <?php endif; ?>

            <?php if(in_array($role, ['Admin Dinkes', 'Admin PKM', 'Pendaftaran', 'Poli Umum', 'Poli Gigi', 'Farmasi'])): ?>
            <a class="flex items-center gap-3 px-6 py-3 font-label-sm text-label-sm transition-all duration-200 ease-in-out border-l-4 sidebar-tenant-link <?= $isActive('admin/'.tenant()->pkm_slug.'/antrian-loket') ?>" href="<?= base_url('admin/' . tenant()->pkm_slug . '/antrian-loket') ?>">
                <span class="material-symbols-outlined text-[20px]">queue</span>
                Update Antrian
            </a>
            <?php endif; ?>

            <?php if($role === 'Admin Dinkes'): ?>
            <a class="flex items-center gap-3 px-6 py-3 font-label-sm text-label-sm transition-all duration-200 ease-in-out border-l-4 sidebar-tenant-link <?= $isActive('admin/'.tenant()->pkm_slug.'/peran') ?>" href="<?= base_url('admin/' . tenant()->pkm_slug . '/peran') ?>">
                <span class="material-symbols-outlined text-[20px]">manage_accounts</span>
                Peran Pengguna
            </a>
            <?php endif; ?>
            
            <?php if(in_array($role, ['Admin Dinkes', 'Admin PKM'])): ?>
            <a class="flex items-center gap-3 px-6 py-3 font-label-sm text-label-sm transition-all duration-200 ease-in-out border-l-4 sidebar-tenant-link <?= $isActive('admin/'.tenant()->pkm_slug.'/pengaturan') ?>" href="<?= base_url('admin/' . tenant()->pkm_slug . '/pengaturan') ?>">
                <span class="material-symbols-outlined text-[20px]">settings</span>
                Pengaturan
            </a>
            <a class="flex items-center gap-3 px-6 py-3 font-label-sm text-label-sm transition-all duration-200 ease-in-out border-l-4 sidebar-tenant-link <?= $isActive('admin/'.tenant()->pkm_slug.'/menu') ?>" href="<?= base_url('admin/' . tenant()->pkm_slug . '/menu') ?>">
                <span class="material-symbols-outlined text-[20px]">menu_open</span>
                Pengaturan Menu
            </a>
            <?php endif; ?>
            
            <div class="mt-auto mb-4">
                <a class="flex items-center gap-3 px-6 py-3 font-label-sm text-label-sm transition-colors transition-all duration-200 ease-in-out border-l-4 sidebar-tenant-link" style="color: #ef4444; opacity: 0.9;" href="<?= base_url('logout') ?>">
                    <span class="material-symbols-outlined text-[20px]">logout</span>
                    Logout
                </a>
            </div>
        </nav>
    </aside>

    <!-- Sidebar Backdrop for Mobile -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-black/50 z-20 hidden transition-opacity duration-300"></div>

    <!-- Main Wrapper -->
    <div class="flex-1 ml-0 md:ml-sidebar_width flex flex-col h-screen relative">
        <!-- TopNavBar -->
        <header class="bg-surface fixed top-0 left-0 md:left-sidebar_width right-0 h-16 border-b border-outline-variant flex justify-between items-center px-4 md:px-gutter z-10">
            <div class="flex items-center gap-3 md:gap-6">
                <!-- Hamburger Menu Toggle -->
                <button id="sidebar-toggle" class="md:hidden text-on-surface-variant hover:bg-surface-container-low rounded-full p-2 transition-colors flex items-center justify-center">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <span class="hidden lg:block text-headline-sm font-headline-sm text-on-surface"><?= esc(tenant()->pkm_nama ?? 'Portal Admin') ?></span>
                <div class="relative group">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors text-[20px]">search</span>
                    <input class="pl-10 pr-4 py-2 bg-surface-container-lowest border border-surface-variant rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface w-40 sm:w-48 md:w-64 transition-all" placeholder="Search..." type="text"/>
                </div>
            </div>
            <div class="flex items-center gap-2 md:gap-4">
                <button class="text-on-surface-variant hover:bg-surface-container-low rounded-full p-2 transition-colors flex items-center justify-center">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <div class="h-8 w-8 rounded-full overflow-hidden border border-outline-variant cursor-pointer ml-1 md:ml-2 hover:opacity-80 transition-opacity">
                    <img alt="Administrator Profile" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuANBBr6wQMkq7K0dSIy0wUJ05OB6MUm5so6M9L6b_yy4GOAYg_R2Tj7gDRNivcqqXVKLwcm5be2qB08J2rr1Sx1bQ9qtT5Eh1RaOn_DmdqkHHWaKuo-mbkW6i9QncAsql4DV6Td33UkeQFwDDa7fZGnfFJ-LBClQQFO-Bb4FFKRHv0OKKxuiVu1EPZEEE5FJlVk5Z3gXB4EvqpyGcjIRHJbKRrI9Yxr9vtsktcUQ8TiEQG0Kzrs8zmMeLhrMPtc4XuK6jsC2hhyJ4A"/>
                </div>
            </div>
        </header>

        <!-- Main Content Canvas -->
        <main class="flex-1 overflow-y-auto pt-16 px-4 md:px-gutter py-margin_desktop bg-background">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <!-- Sidebar Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarClose = document.getElementById('sidebar-close');
            const backdrop = document.getElementById('sidebar-backdrop');

            function toggleSidebar() {
                sidebar.classList.toggle('-translate-x-full');
                backdrop.classList.toggle('hidden');
                if (!backdrop.classList.contains('hidden')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            }

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }

            if (sidebarClose) {
                sidebarClose.addEventListener('click', toggleSidebar);
            }

            if (backdrop) {
                backdrop.addEventListener('click', toggleSidebar);
            }
        });
    </script>
</body>
</html>
