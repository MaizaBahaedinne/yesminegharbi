<!DOCTYPE html>
<html lang="fr">
<head>
  <?php
    $cssPath = FCPATH . 'assets/css/app.css';
    $jsPath  = FCPATH . 'assets/js/app.js';
    $cssVer  = is_file($cssPath) ? filemtime($cssPath) : time();
    $jsVer   = is_file($jsPath) ? filemtime($jsPath) : time();
  ?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= esc($page_description ?? '') ?>">
  <meta name="robots" content="index, follow">
  <meta property="og:title"       content="<?= esc($page_title ?? 'Yesmine Gharbi') ?>">
  <meta property="og:description" content="<?= esc($page_description ?? '') ?>">
  <meta property="og:type"        content="website">
  <meta property="og:image"       content="<?= base_url('assets/images/og.jpg') ?>">
  <title><?= esc($page_title ?? 'Yesmine Gharbi') ?></title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWix+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkR4j8w4LLynf1W4n+6o0w5f5hXg5xR9E0Ng==" crossorigin="anonymous" referrerpolicy="no-referrer">
  <link rel="stylesheet" href="<?= base_url('assets/css/app.css?v=' . $cssVer) ?>">
  <link rel="icon" href="<?= base_url('assets/images/favicon.svg') ?>" type="image/svg+xml">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?= $this->include('partials/navbar') ?>

<main id="main">
  <?= $content ?>
</main>

<?= $this->include('partials/footer') ?>

<script>const BASE_URL = '<?= site_url('/') ?>';</script>
<script src="<?= base_url('assets/js/app.js?v=' . $jsVer) ?>" defer></script>
</body>
</html>
