<?php
/** @var string $currentUri */
$seg = service('uri')->getSegment(1);
$user = $user ?? [];
$displayName = trim(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? ''));
$initials = '';
if ($displayName !== '') {
  $parts = preg_split('/\s+/', trim($displayName));
  $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
}
$initials = $initials ?: 'U';
?>
<nav>
  <a href="<?= site_url('/') ?>" class="nav-logo" aria-label="Yesmine Gharbi, accueil">Yesmine <span>Gharbi</span><small>RECRUTEMENT · CARRIÈRE</small></a>

  <ul class="nav-links">
    <li><a href="<?= site_url('formations') ?>" class="<?= $seg === 'formations' ? 'active' : '' ?>">Formations</a></li>
    <li><a href="<?= site_url('ressources') ?>" class="<?= in_array($seg, ['ressources', 'ressources-gratuites', 'ressources-premium'], true) ? 'active' : '' ?>">Ressources</a></li>
    <li><a href="<?= site_url('cv-ats') ?>" class="<?= $seg === 'cv-ats' ? 'active' : '' ?>">CV ATS</a></li>
    <li><a href="<?= site_url('actualites') ?>" class="<?= $seg === 'actualites' ? 'active' : '' ?>">Actualités</a></li>
    <li><a href="<?= site_url('entreprises') ?>" class="<?= $seg === 'entreprises' ? 'active' : '' ?>">Entreprises</a></li>
    <li><a href="<?= site_url('a-propos') ?>" class="<?= $seg === 'a-propos' ? 'active' : '' ?>">À propos</a></li>
    <li class="nav-actions">
      <a href="<?= site_url('contact') ?>" class="nav-cta"><i class="fa-regular fa-paper-plane" aria-hidden="true"></i><span>Me contacter</span></a>
    <?php if (!empty($isLoggedIn)): ?>
      <div class="nav-account">
        <button type="button" id="userMenuBtn" class="nav-account-trigger" aria-expanded="false" aria-controls="userMenuPanel">
          <span class="nav-avatar"><?= esc($initials) ?></span>
          <span class="nav-account-name"><?= esc($displayName ?: 'Mon compte') ?></span>
          <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
        </button>
        <div id="userMenuPanel" class="nav-account-menu" hidden>
          <span class="nav-account-heading">Mon espace</span>
          <a href="<?= site_url('mon-compte') ?>"><i class="fa-regular fa-user" aria-hidden="true"></i> Gestion de mon profil</a>
          <a href="<?= site_url('mon-compte/commandes') ?>"><i class="fa-solid fa-bag-shopping" aria-hidden="true"></i> Mes commandes</a>
          <a href="<?= site_url('mon-compte/cv') ?>"><i class="fa-regular fa-file-lines" aria-hidden="true"></i> Mes CV</a>
          <a href="<?= site_url('deconnexion') ?>" class="nav-account-logout"><i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i> Se déconnecter</a>
        </div>
      </div>
    <?php else: ?>
      <a href="<?= site_url('connexion') ?>" class="nav-login">Connexion</a>
    <?php endif; ?>
    </li>
  </ul>

  <button class="nav-burger" id="navBurger" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="navMobile">
    <i class="fa-solid fa-bars" aria-hidden="true"></i>
  </button>
</nav>

<div class="nav-mobile" id="navMobile" aria-hidden="true" inert>
  <button type="button" class="nav-mobile-backdrop" data-close-mobile aria-label="Fermer le menu"></button>
  <div class="nav-mobile-panel" role="dialog" aria-modal="true" aria-label="Navigation principale">
    <div class="nav-mobile-head">
      <a href="<?= site_url('/') ?>" class="nav-logo">Yesmine <span>Gharbi</span></a>
      <button type="button" class="nav-mobile-close" data-close-mobile aria-label="Fermer le menu"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
    </div>
    <span class="nav-mobile-label">Explorer</span>
    <a href="<?= site_url('formations') ?>" class="<?= $seg === 'formations' ? 'active' : '' ?>">Formations <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
    <a href="<?= site_url('ressources') ?>" class="<?= in_array($seg, ['ressources', 'ressources-gratuites', 'ressources-premium'], true) ? 'active' : '' ?>">Ressources <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
    <a href="<?= site_url('cv-ats') ?>" class="<?= $seg === 'cv-ats' ? 'active' : '' ?>">CV ATS <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
    <a href="<?= site_url('actualites') ?>" class="<?= $seg === 'actualites' ? 'active' : '' ?>">Actualités <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
    <a href="<?= site_url('entreprises') ?>" class="<?= $seg === 'entreprises' ? 'active' : '' ?>">Entreprises <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
    <a href="<?= site_url('a-propos') ?>" class="<?= $seg === 'a-propos' ? 'active' : '' ?>">À propos <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
    <div class="nav-mobile-actions">
      <a href="<?= site_url('contact') ?>" class="nav-cta"><i class="fa-regular fa-paper-plane" aria-hidden="true"></i> Me contacter</a>
      <?php if (!empty($isLoggedIn)): ?>
        <a href="<?= site_url('mon-compte') ?>" class="nav-mobile-account"><span class="nav-avatar"><?= esc($initials) ?></span><?= esc($displayName ?: 'Mon compte') ?></a>
        <a href="<?= site_url('mon-compte/commandes') ?>" class="nav-mobile-sub">Mes commandes</a>
        <a href="<?= site_url('mon-compte/cv') ?>" class="nav-mobile-sub">Mes CV</a>
        <a href="<?= site_url('deconnexion') ?>" class="nav-mobile-sub nav-account-logout">Se déconnecter</a>
      <?php else: ?>
        <a href="<?= site_url('connexion') ?>" class="nav-login">Connexion / Inscription</a>
      <?php endif; ?>
    </div>
  </div>
</div>
