<!DOCTYPE html>
<html lang="fr">
<head>
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
  <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
  <link rel="icon" href="<?= base_url('assets/images/favicon.svg') ?>" type="image/svg+xml">
</head>
<body>

<?= $this->include('partials/navbar') ?>

<main id="main">
  <?= $content ?>
</main>

<?= $this->include('partials/footer') ?>

<script src="<?= base_url('assets/js/app.js') ?>" defer></script>
</body>
</html>
