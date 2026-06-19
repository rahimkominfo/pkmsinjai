<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= $title ?? 'PKM Balangnipa' ?></title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Work+Sans:wght@600;700&display=swap" rel="stylesheet"/>
    
    <!-- Tailwind CSS (PostCSS Output) -->
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">

    <style {csp-style-nonce}>
      :root {
        --tenant-primary: <?= (!empty(tenant('primary_color'))) ? esc(tenant('primary_color')) : '#006c4a' ?>;
        --tenant-on-primary: <?= (!empty(tenant('on_primary_color'))) ? esc(tenant('on_primary_color')) : '#ffffff' ?>;
      }
      @keyframes pulse-green {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(34, 197, 94, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
      }
      @keyframes scroll-text {
        0% { transform: translate3d(0, 0, 0); }
        100% { transform: translate3d(-100%, 0, 0); }
      }
      .animate-scroll-text {
        display: inline-block;
        white-space: nowrap;
        padding-left: 100%;
        animation: scroll-text 30s linear infinite;
        will-change: transform;
      }
      .animate-scroll-text:hover {
        animation-play-state: paused;
      }
      .animate-pulse-green {
        animation: pulse-green 2s infinite;
      }
    </style>
</head>
<body class="bg-background text-on-surface font-body-md antialiased selection:bg-primary-container selection:text-on-primary-container overflow-x-hidden relative w-full">

    <!-- Navbar -->
    <?= $this->include('frontend/layouts/navbar') ?>

    <!-- Main Content -->
    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <?= $this->include('frontend/layouts/footer') ?>

    <!-- Scripts -->
    <script {csp-script-nonce}>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const menuClose = document.getElementById('menuClose');
            const mobileMenu = document.getElementById('mobileMenu');
            const menuBackdrop = document.getElementById('menuBackdrop');
            const menuContent = document.getElementById('menuContent');

            function openMenu() {
                console.log('Hamburger menu clicked: opening');
                mobileMenu.classList.remove('hidden');
                
                // Force a browser reflow so the transition applies
                void mobileMenu.offsetWidth;
                
                menuBackdrop.classList.remove('opacity-0');
                menuBackdrop.classList.add('opacity-100');
                
                menuContent.classList.remove('translate-x-full');
                menuContent.classList.add('translate-x-0');
                
                document.body.style.overflow = 'hidden';
            }

            function closeMenu() {
                console.log('Hamburger menu clicked: closing');
                menuBackdrop.classList.remove('opacity-100');
                menuBackdrop.classList.add('opacity-0');
                
                menuContent.classList.remove('translate-x-0');
                menuContent.classList.add('translate-x-full');
                
                setTimeout(() => {
                    mobileMenu.classList.add('hidden');
                }, 300);
                document.body.style.overflow = '';
            }

            if (menuToggle) menuToggle.addEventListener('click', openMenu);
            if (menuClose) menuClose.addEventListener('click', closeMenu);
            if (menuBackdrop) menuBackdrop.addEventListener('click', closeMenu);
        });
    </script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
