<?php
/** @var string $currentUri */
$seg = service('uri')->getSegment(1);
?>
<nav>
  <a href="<?= site_url('/') ?>" class="nav-logo">Yesmine <span>Gharbi</span></a>

  <ul class="nav-links">
    <li><a href="<?= site_url('formations') ?>"           class="<?= $seg === 'formations' ? 'active' : '' ?>">Formations</a></li>
    <li><a href="<?= site_url('ressources-gratuites') ?>" class="<?= $seg === 'ressources-gratuites' ? 'active' : '' ?>">Ressources</a></li>
    <li><a href="<?= site_url('entreprises') ?>"          class="<?= $seg === 'entreprises' ? 'active' : '' ?>">Entreprises</a></li>
    <li><a href="<?= site_url('a-propos') ?>"             class="<?= $seg === 'a-propos' ? 'active' : '' ?>">À propos</a></li>
    <li><a href="<?= site_url('contact') ?>" class="nav-cta">Me contacter</a></li>
  </ul>

  <button class="nav-burger" id="navBurger" aria-label="Menu" aria-expanded="false">
    <span></span><span></span><span></span>
  </button>
</nav>

<!-- Mobile drawer -->
<div class="nav-mobile" id="navMobile" aria-hidden="true">
  <a href="<?= site_url('/') ?>">Accueil</a>
  <a href="<?= site_url('formations') ?>">Formations</a>
  <a href="<?= site_url('ressources-gratuites') ?>">Ressources gratuites</a>
  <a href="<?= site_url('ressources-premium') ?>">Ressources premium</a>
  <a href="<?= site_url('entreprises') ?>">Entreprises</a>
  <a href="<?= site_url('a-propos') ?>">À propos</a>
  <a href="<?= site_url('contact') ?>" class="nav-cta" style="margin-top:12px;display:block;text-align:center">Me contacter</a>
</div>
