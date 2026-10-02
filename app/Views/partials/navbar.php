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
$localeUrl = current_url();
?>
<nav>
  <a href="<?= site_url('/') ?>" class="nav-logo" aria-label="Yesmine Gharbi, accueil"><span class="nav-brand-name">Yesmine <span>Gharbi</span></span><small><?= esc(lang('Site.tagline')) ?></small></a>

  <ul class="nav-links">
    <li><a href="<?= site_url('a-propos') ?>" class="<?= $seg === 'a-propos' ? 'active' : '' ?>"><?= esc(lang('Site.nav.about')) ?></a></li>
    <li class="nav-tools-item">
      <details class="nav-tools-details">
        <summary class="<?= $seg === 'cv-ats' || ($seg === 'mon-compte' && service('uri')->getSegment(2) === 'cv') ? 'active' : '' ?>"><?= esc(lang('Site.nav.tools')) ?> <i class="fa-solid fa-chevron-down" aria-hidden="true"></i></summary>
        <div class="nav-tools-menu">
          <a href="<?= site_url('cv-ats') ?>"><i class="fa-solid fa-file-circle-check" aria-hidden="true"></i> <?= esc(lang('Site.nav.cv')) ?></a>
        </div>
      </details>
    </li>
    <li><a href="<?= site_url('formations') ?>" class="<?= $seg === 'formations' ? 'active' : '' ?>"><?= esc(lang('Site.nav.training')) ?></a></li>
    <li><a href="<?= site_url('ressources') ?>" class="<?= in_array($seg, ['ressources', 'ressources-gratuites', 'ressources-premium'], true) ? 'active' : '' ?>"><?= esc(lang('Site.nav.resources')) ?></a></li>
    <li><a href="<?= site_url('entreprises') ?>" class="<?= $seg === 'entreprises' ? 'active' : '' ?>"><?= esc(lang('Site.nav.companies')) ?></a></li>
    <li><a href="<?= site_url('actualites') ?>" class="<?= $seg === 'actualites' ? 'active' : '' ?>"><?= esc(lang('Site.nav.news')) ?></a></li>
    <li class="nav-search-item">
      <form action="<?= site_url('recherche') ?>" method="get" class="nav-search-form" role="search">
        <label class="sr-only" for="nav-search"><?= esc(lang('Site.nav.search_site')) ?></label>
        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
        <input id="nav-search" type="search" name="q" placeholder="<?= esc(lang('Site.nav.search')) ?>" minlength="2" maxlength="100" required>
        <button type="submit" aria-label="<?= esc(lang('Site.nav.search_action')) ?>"><i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
      </form>
    </li>
    <li class="nav-actions">
      <div class="language-switcher" aria-label="<?= esc(lang('Site.nav.choose_language')) ?>">
        <?php foreach (['fr' => 'FR', 'en' => 'EN', 'ar' => 'عربي'] as $code => $label): ?>
          <a href="<?= esc($localeUrl . '?lang=' . $code) ?>" lang="<?= esc($code) ?>" hreflang="<?= esc($code) ?>" class="<?= $siteLocale === $code ? 'active' : '' ?>" <?= $siteLocale === $code ? 'aria-current="true"' : '' ?>><?= esc($label) ?></a>
        <?php endforeach; ?>
      </div>
      <a href="<?= site_url('contact') ?>" class="nav-cta"><i class="fa-regular fa-paper-plane" aria-hidden="true"></i><span><?= esc(lang('Site.nav.contact')) ?></span></a>
    <?php if (!empty($isLoggedIn)): ?>
      <div class="nav-account">
        <button type="button" id="userMenuBtn" class="nav-account-trigger" aria-expanded="false" aria-controls="userMenuPanel">
          <span class="nav-avatar"><?= esc($initials) ?></span>
          <span class="nav-account-name"><?= esc($displayName ?: lang('Site.nav.account')) ?></span>
          <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
        </button>
        <div id="userMenuPanel" class="nav-account-menu" hidden>
          <span class="nav-account-heading"><?= esc(lang('Site.nav.my_space')) ?></span>
          <a href="<?= site_url('mon-compte') ?>"><i class="fa-regular fa-user" aria-hidden="true"></i> <?= esc(lang('Site.nav.profile')) ?></a>
          <a href="<?= site_url('mon-compte/commandes') ?>"><i class="fa-solid fa-bag-shopping" aria-hidden="true"></i> <?= esc(lang('Site.nav.orders')) ?></a>
          <a href="<?= site_url('mon-compte/cv') ?>"><i class="fa-regular fa-file-lines" aria-hidden="true"></i> <?= esc(lang('Site.nav.my_cvs')) ?></a>
          <a href="<?= site_url('deconnexion') ?>" class="nav-account-logout"><i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i> <?= esc(lang('Site.nav.logout')) ?></a>
        </div>
      </div>
    <?php else: ?>
      <a href="<?= site_url('connexion') ?>" class="nav-login"><?= esc(lang('Site.nav.login')) ?></a>
    <?php endif; ?>
    </li>
  </ul>

  <button class="nav-burger" id="navBurger" aria-label="<?= esc(lang('Site.nav.open_menu')) ?>" aria-expanded="false" aria-controls="navMobile">
    <i class="fa-solid fa-bars" aria-hidden="true"></i>
  </button>
</nav>

<div class="nav-mobile" id="navMobile" aria-hidden="true" inert>
  <button type="button" class="nav-mobile-backdrop" data-close-mobile aria-label="Fermer le menu"></button>
  <div class="nav-mobile-panel" role="dialog" aria-modal="true" aria-label="Navigation principale">
    <div class="nav-mobile-head">
      <a href="<?= site_url('/') ?>" class="nav-logo"><span class="nav-brand-name">Yesmine <span>Gharbi</span></span><small><?= esc(lang('Site.tagline')) ?></small></a>
      <button type="button" class="nav-mobile-close" data-close-mobile aria-label="<?= esc(lang('Site.nav.close')) ?>"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
    </div>
    <span class="nav-mobile-label"><?= esc(lang('Site.nav.explore')) ?></span>
    <form action="<?= site_url('recherche') ?>" method="get" class="nav-mobile-search" role="search">
      <label class="sr-only" for="mobile-search"><?= esc(lang('Site.nav.search_site')) ?></label>
      <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
      <input id="mobile-search" type="search" name="q" placeholder="<?= esc(lang('Site.nav.search')) ?>" minlength="2" maxlength="100" required>
      <button type="submit" aria-label="<?= esc(lang('Site.nav.search_action')) ?>"><i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
    </form>
    <a href="<?= site_url('a-propos') ?>" class="<?= $seg === 'a-propos' ? 'active' : '' ?>"><?= esc(lang('Site.nav.about')) ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
    <span class="nav-mobile-label nav-mobile-tools-label"><?= esc(lang('Site.nav.tools')) ?></span>
    <a href="<?= site_url('cv-ats') ?>" class="<?= $seg === 'cv-ats' ? 'active' : '' ?>"><?= esc(lang('Site.nav.cv')) ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
    <a href="<?= site_url('formations') ?>" class="<?= $seg === 'formations' ? 'active' : '' ?>"><?= esc(lang('Site.nav.training')) ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
    <a href="<?= site_url('ressources') ?>" class="<?= in_array($seg, ['ressources', 'ressources-gratuites', 'ressources-premium'], true) ? 'active' : '' ?>"><?= esc(lang('Site.nav.resources')) ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
    <a href="<?= site_url('entreprises') ?>" class="<?= $seg === 'entreprises' ? 'active' : '' ?>"><?= esc(lang('Site.nav.companies')) ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
    <a href="<?= site_url('actualites') ?>" class="<?= $seg === 'actualites' ? 'active' : '' ?>"><?= esc(lang('Site.nav.news')) ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
    <div class="nav-mobile-actions">
      <a href="<?= site_url('contact') ?>" class="nav-cta"><i class="fa-regular fa-paper-plane" aria-hidden="true"></i> <?= esc(lang('Site.nav.contact')) ?></a>
      <?php if (!empty($isLoggedIn)): ?>
        <a href="<?= site_url('mon-compte') ?>" class="nav-mobile-account"><span class="nav-avatar"><?= esc($initials) ?></span><?= esc($displayName ?: lang('Site.nav.account')) ?></a>
        <a href="<?= site_url('mon-compte/commandes') ?>" class="nav-mobile-sub"><?= esc(lang('Site.nav.orders')) ?></a>
        <a href="<?= site_url('mon-compte/cv') ?>" class="nav-mobile-sub"><?= esc(lang('Site.nav.my_cvs')) ?></a>
        <a href="<?= site_url('deconnexion') ?>" class="nav-mobile-sub nav-account-logout"><?= esc(lang('Site.nav.logout')) ?></a>
      <?php else: ?>
        <a href="<?= site_url('connexion') ?>" class="nav-login"><?= esc(lang('Site.nav.login_register')) ?></a>
      <?php endif; ?>
      <div class="language-switcher language-switcher-mobile" aria-label="<?= esc(lang('Site.nav.choose_language')) ?>">
        <?php foreach (['fr' => 'FR', 'en' => 'EN', 'ar' => 'عربي'] as $code => $label): ?>
          <a href="<?= esc($localeUrl . '?lang=' . $code) ?>" lang="<?= esc($code) ?>" hreflang="<?= esc($code) ?>" class="<?= $siteLocale === $code ? 'active' : '' ?>" <?= $siteLocale === $code ? 'aria-current="true"' : '' ?>><?= esc($label) ?></a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
