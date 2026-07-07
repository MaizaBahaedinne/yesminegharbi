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
  <a href="<?= site_url('/') ?>" class="nav-logo">Yesmine <span>Gharbi</span></a>

  <ul class="nav-links">
    <li><a href="<?= site_url('formations') ?>"           class="<?= $seg === 'formations' ? 'active' : '' ?>">Formations</a></li>
    <li><a href="<?= site_url('ressources') ?>" class="<?= in_array($seg, ['ressources', 'ressources-gratuites', 'ressources-premium'], true) ? 'active' : '' ?>">Ressources</a></li>
    <li><a href="<?= site_url('entreprises') ?>"          class="<?= $seg === 'entreprises' ? 'active' : '' ?>">Entreprises</a></li>
    <li><a href="<?= site_url('a-propos') ?>"             class="<?= $seg === 'a-propos' ? 'active' : '' ?>">À propos</a></li>
    <li><a href="<?= site_url('contact') ?>" class="nav-cta">Me contacter</a></li>
    <?php if (!empty($isLoggedIn)): ?>
      <li style="position:relative">
        <button type="button" id="userMenuBtn" aria-expanded="false" style="display:flex;align-items:center;gap:.6rem;padding:.5rem .8rem;border-radius:999px;background:var(--beige);color:var(--noir);text-decoration:none;border:0;cursor:pointer">
          <span style="width:34px;height:34px;border-radius:50%;background:var(--rouge);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-weight:700;font-size:.9rem"><?= esc($initials) ?></span>
          <span style="font-weight:600"><?= esc($displayName ?: 'Mon compte') ?></span>
          <span style="font-size:.75rem;color:var(--gris)"><i class="fa-solid fa-chevron-down" aria-hidden="true"></i></span>
        </button>
        <div id="userMenuPanel" style="position:absolute;top:calc(100% + 10px);right:0;min-width:220px;background:#fff;border:1px solid #eee;border-radius:12px;box-shadow:0 14px 30px rgba(0,0,0,.12);padding:.45rem;display:none;z-index:1200">
          <a href="<?= site_url('mon-compte') ?>" style="display:block;padding:.7rem .8rem;border-radius:8px;color:var(--noir);text-decoration:none">Gestion de mon profil</a>
          <a href="<?= site_url('mon-compte/commandes') ?>" style="display:block;padding:.7rem .8rem;border-radius:8px;color:var(--noir);text-decoration:none">Mes commandes</a>
          <a href="<?= site_url('deconnexion') ?>" style="display:block;padding:.7rem .8rem;border-radius:8px;color:var(--rouge);text-decoration:none">Se déconnecter</a>
        </div>
      </li>
    <?php else: ?>
      <li><a href="<?= site_url('connexion') ?>" style="padding:.65rem 1rem;border-radius:999px;background:var(--rouge);color:#fff;font-weight:600;text-decoration:none">Connexion / Inscription</a></li>
    <?php endif; ?>
  </ul>

  <button class="nav-burger" id="navBurger" aria-label="Menu" aria-expanded="false">
    <span></span><span></span><span></span>
  </button>
</nav>

<!-- Mobile drawer -->
<div class="nav-mobile" id="navMobile" aria-hidden="true">
  <a href="<?= site_url('/') ?>">Accueil</a>
  <a href="<?= site_url('formations') ?>">Formations</a>
  <a href="<?= site_url('ressources') ?>">Ressources</a>
  <a href="<?= site_url('entreprises') ?>">Entreprises</a>
  <a href="<?= site_url('a-propos') ?>">À propos</a>
  <?php if (!empty($isLoggedIn)): ?>
    <a href="<?= site_url('mon-compte') ?>" style="display:flex;align-items:center;gap:.6rem;margin-top:12px">
      <span style="width:34px;height:34px;border-radius:50%;background:var(--rouge);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-weight:700;font-size:.9rem"><?= esc($initials) ?></span>
      <span><?= esc($displayName ?: 'Mon compte') ?></span>
    </a>
  <?php else: ?>
    <a href="<?= site_url('connexion') ?>" class="nav-cta" style="margin-top:12px;display:block;text-align:center;background:var(--rouge);color:#fff">Connexion / Inscription</a>
  <?php endif; ?>
  <a href="<?= site_url('contact') ?>" class="nav-cta" style="margin-top:12px;display:block;text-align:center">Me contacter</a>
</div>
