<?php
/**
 * Shared Header Component
 * yesminegharbi.com
 */

// Determine active page
$current_page = basename($_SERVER['PHP_SELF'], '.php');

function is_active($page_name) {
    global $current_page;
    return ($current_page === $page_name) ? ' active' : '';
}

// Default meta values (can be overridden before including this file)
if (!isset($page_title))       $page_title       = 'Yesmine Gharbi — Spécialiste Recrutement & Créatrice de Contenu';
if (!isset($page_description)) $page_description = 'Formations, ressources et conseils en recrutement par Yesmine Gharbi. Boostez votre carrière avec des conseils issus du terrain.';
if (!isset($page_keywords))    $page_keywords    = 'recrutement, formation, CV, entretien, emploi, LinkedIn, personal branding, Tunisie';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($page_description) ?>">
  <meta name="keywords"    content="<?= htmlspecialchars($page_keywords) ?>">
  <meta name="robots"      content="index, follow">

  <!-- Open Graph -->
  <meta property="og:title"       content="<?= htmlspecialchars($page_title) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($page_description) ?>">
  <meta property="og:type"        content="website">
  <meta property="og:url"         content="https://yesminegharbi.com">
  <meta property="og:image"       content="/assets/images/og-image.jpg">

  <title><?= htmlspecialchars($page_title) ?></title>

  <!-- Preconnect for Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <!-- Stylesheets -->
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="stylesheet" href="/assets/css/components.css">

  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
</head>
<body>

<!-- ===== NAVBAR ===== -->
<header class="navbar" role="banner">
  <div class="container navbar__inner">

    <!-- Logo -->
    <a href="/" class="navbar__logo" aria-label="Yesmine Gharbi — Accueil">
      Yesmine<span>.</span>
    </a>

    <!-- Desktop Navigation -->
    <nav class="navbar__nav" role="navigation" aria-label="Navigation principale">
      <a href="/"                    class="navbar__link<?= is_active('index') ?>">Accueil</a>
      <a href="/formations.php"      class="navbar__link<?= is_active('formations') ?>">Formations</a>
      <a href="/ressources-gratuites.php" class="navbar__link<?= is_active('ressources-gratuites') ?>">Ressources gratuites</a>
      <a href="/ressources-premium.php"   class="navbar__link<?= is_active('ressources-premium') ?>">Premium</a>
      <a href="/entreprises.php"     class="navbar__link<?= is_active('entreprises') ?>">Entreprises</a>
      <a href="/a-propos.php"        class="navbar__link<?= is_active('a-propos') ?>">À propos</a>
    </nav>

    <!-- Desktop CTA -->
    <div class="navbar__cta">
      <a href="/contact.php" class="btn btn--secondary btn--sm">Contact</a>
      <a href="/formations.php" class="btn btn--primary btn--sm">Voir les formations</a>
    </div>

    <!-- Mobile Burger -->
    <button class="navbar__burger" id="navBurger" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="mobileNav">
      <span></span>
      <span></span>
      <span></span>
    </button>

  </div>
</header>

<!-- Mobile Navigation -->
<nav class="navbar__mobile" id="mobileNav" aria-label="Navigation mobile" role="navigation">
  <a href="/"                         class="navbar__link<?= is_active('index') ?>">Accueil</a>
  <a href="/formations.php"           class="navbar__link<?= is_active('formations') ?>">Formations</a>
  <a href="/ressources-gratuites.php" class="navbar__link<?= is_active('ressources-gratuites') ?>">Ressources gratuites</a>
  <a href="/ressources-premium.php"   class="navbar__link<?= is_active('ressources-premium') ?>">Ressources premium</a>
  <a href="/entreprises.php"          class="navbar__link<?= is_active('entreprises') ?>">Entreprises</a>
  <a href="/a-propos.php"             class="navbar__link<?= is_active('a-propos') ?>">À propos</a>
  <a href="/contact.php"              class="navbar__link<?= is_active('contact') ?>">Contact</a>
  <a href="/formations.php" class="btn btn--primary btn--full">Voir les formations →</a>
</nav>

<!-- Page Content Wrapper -->
<main id="main-content" class="page-content" role="main">
