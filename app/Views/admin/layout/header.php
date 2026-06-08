<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Admin Dashboard</title>
<!-- Google Fonts & Material Symbols -->
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<!-- Tailwind CSS Local -->
<link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <style>
        /* Level 1 Surface Custom Shadow based on design system */
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
<aside class="fixed h-screen w-sidebar_width left-0 top-0 shadow-sm flex flex-col h-full py-base z-20 sidebar-tenant">
<!-- Brand Header -->
<div class="px-6 py-6 mb-4 flex items-center gap-3">
<img alt="Logo" class="w-10 h-10 object-contain" src="<?= base_url('images/logo.png') ?>"/>
<div>
<h1 class="text-headline-sm font-headline-sm font-bold sidebar-tenant-text"><?= esc(tenant()->pkm_nama ?? 'Portal Admin') ?></h1>
<p class="font-label-sm text-label-sm sidebar-tenant-text-muted mt-1 uppercase tracking-wider"><?= session()->get('peran') ?></p>
</div>
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
        Artikel
    </a>
    <?php endif; ?>

    <?php if(in_array($role, ['Admin Dinkes', 'Admin PKM', 'Editor'])): ?>
    <a class="flex items-center gap-3 px-6 py-3 font-label-sm text-label-sm transition-all duration-200 ease-in-out border-l-4 sidebar-tenant-link <?= $isActive('admin/'.tenant()->pkm_slug.'/kategori') ?>" href="<?= base_url('admin/' . tenant()->pkm_slug . '/kategori') ?>">
        <span class="material-symbols-outlined text-[20px]">category</span>
        Kategori
    </a>
    <a class="flex items-center gap-3 px-6 py-3 font-label-sm text-label-sm transition-all duration-200 ease-in-out border-l-4 sidebar-tenant-link <?= $isActive('admin/'.tenant()->pkm_slug.'/galeri') ?>" href="<?= base_url('admin/' . tenant()->pkm_slug . '/galeri') ?>">
        <span class="material-symbols-outlined text-[20px]">photo_library</span>
        Galeri
    </a>
    <?php endif; ?>

    <?php if(in_array($role, ['Admin Dinkes', 'Admin PKM'])): ?>
    <a class="flex items-center gap-3 px-6 py-3 font-label-sm text-label-sm transition-all duration-200 ease-in-out border-l-4 sidebar-tenant-link <?= $isActive('admin/'.tenant()->pkm_slug.'/antrian') ?>" href="<?= base_url('admin/' . tenant()->pkm_slug . '/antrian') ?>">
        <span class="material-symbols-outlined text-[20px]">queue</span>
        Antrian
    </a>
    <a class="flex items-center gap-3 px-6 py-3 font-label-sm text-label-sm transition-all duration-200 ease-in-out border-l-4 sidebar-tenant-link <?= $isActive('admin/'.tenant()->pkm_slug.'/pengguna') ?>" href="<?= base_url('admin/' . tenant()->pkm_slug . '/pengguna') ?>">
        <span class="material-symbols-outlined text-[20px]">group</span>
        Pengguna
    </a>
    <a class="flex items-center gap-3 px-6 py-3 font-label-sm text-label-sm transition-all duration-200 ease-in-out border-l-4 sidebar-tenant-link <?= $isActive('admin/'.tenant()->pkm_slug.'/running-text') ?>" href="<?= base_url('admin/' . tenant()->pkm_slug . '/running-text') ?>">
        <span class="material-symbols-outlined text-[20px]">campaign</span>
        Teks Berjalan
    </a>
    <?php endif; ?>

    <?php if($role === 'Admin Dinkes'): ?>
    <a class="flex items-center gap-3 px-6 py-3 font-label-sm text-label-sm transition-all duration-200 ease-in-out border-l-4 sidebar-tenant-link <?= $isActive('admin/'.tenant()->pkm_slug.'/peran') ?>" href="<?= base_url('admin/' . tenant()->pkm_slug . '/peran') ?>">
        <span class="material-symbols-outlined text-[20px]">manage_accounts</span>
        Peran Pengguna
    </a>
    <a class="flex items-center gap-3 px-6 py-3 font-label-sm text-label-sm transition-all duration-200 ease-in-out border-l-4 sidebar-tenant-link <?= $isActive('admin/'.tenant()->pkm_slug.'/pengaturan') ?>" href="<?= base_url('admin/' . tenant()->pkm_slug . '/pengaturan') ?>">
        <span class="material-symbols-outlined text-[20px]">settings</span>
        Pengaturan Sistem
    </a>
    <?php endif; ?>
    
    <?php if(in_array($role, ['Admin Dinkes', 'Admin PKM'])): ?>
    <a class="flex items-center gap-3 px-6 py-3 font-label-sm text-label-sm transition-all duration-200 ease-in-out border-l-4 sidebar-tenant-link <?= $isActive('admin/'.tenant()->pkm_slug.'/menu') ?>" href="<?= base_url('admin/' . tenant()->pkm_slug . '/menu') ?>">
        <span class="material-symbols-outlined text-[20px]">menu</span>
        Menu Frontend
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
