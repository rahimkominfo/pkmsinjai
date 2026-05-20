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

    <style>
      @keyframes pulse-green {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(34, 197, 94, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
      }
      .animate-pulse-green {
        animation: pulse-green 2s infinite;
      }
    </style>
</head>
<body class="bg-background text-on-surface font-body-md antialiased selection:bg-primary-container selection:text-on-primary-container">

    <!-- Navbar -->
    <?= $this->include('frontend/layouts/navbar') ?>

    <!-- Main Content -->
    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <?= $this->include('frontend/layouts/footer') ?>

    <!-- Scripts -->
    <script>
        // Common JS logic can go here
        const menuToggle = document.getElementById('menuToggle');
        if (menuToggle) {
            menuToggle.addEventListener('click', () => {
                // Mobile menu logic
            });
        }
    </script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
