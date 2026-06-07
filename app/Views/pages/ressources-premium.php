<?php
$iconeRessource = [
    'checklist' => '📋',
    'template'  => '📝',
    'ebook'     => '💡',
    'guide'     => '📊',
    'kit'       => '🎯',
];
$badgeCss = [
    'populaire' => 'background:var(--or);color:white',
    'nouveau'   => 'background:var(--noir);color:white',
    'premium'   => 'background:var(--rouge);color:white',
    'gratuit'   => 'background:var(--sauge);color:white',
];
?>

<div class="page-header">
  <div class="page-header-inner">
    <span class="section-tag">Premium</span>
    <h1>Ressources premium</h1>
    <p>Guides approfondis, templates et kits complets conçus par une experte du recrutement.</p>
  </div>
</div>

<section>
  <!-- Filtres -->
  <div class="filter-area">
    <div class="filter-row">
      <span class="filter-label">Type :</span>
      <a href="?type=tous&profil=<?= esc($active_profil) ?>"       class="filter-btn <?= $active_type === 'tous' ? 'active' : '' ?>">Tous</a>
      <a href="?type=guide&profil=<?= esc($active_profil) ?>"      class="filter-btn <?= $active_type === 'guide' ? 'active' : '' ?>">Guide PDF</a>
      <a href="?type=template&profil=<?= esc($active_profil) ?>"   class="filter-btn <?= $active_type === 'template' ? 'active' : '' ?>">Template</a>
      <a href="?type=checklist&profil=<?= esc($active_profil) ?>"  class="filter-btn <?= $active_type === 'checklist' ? 'active' : '' ?>">Checklist</a>
      <a href="?type=kit&profil=<?= esc($active_profil) ?>"        class="filter-btn <?= $active_type === 'kit' ? 'active' : '' ?>">Kit complet</a>
    </div>
    <div class="filter-row" style="margin-top:10px">
      <span class="filter-label">Profil :</span>
      <a href="?type=<?= esc($active_type) ?>&profil=tous"         class="filter-btn <?= $active_profil === 'tous' ? 'active' : '' ?>">Tous</a>
      <a href="?type=<?= esc($active_type) ?>&profil=junior"       class="filter-btn <?= $active_profil === 'junior' ? 'active' : '' ?>">Junior</a>
      <a href="?type=<?= esc($active_type) ?>&profil=experimente"  class="filter-btn <?= $active_profil === 'experimente' ? 'active' : '' ?>">Expérimenté</a>
      <a href="?type=<?= esc($active_type) ?>&profil=recruteur"    class="filter-btn <?= $active_profil === 'recruteur' ? 'active' : '' ?>">Recruteur</a>
    </div>
  </div>

  <?php if (empty($ressources)): ?>
  <p style="text-align:center;color:var(--gris);padding:60px 0">Aucune ressource ne correspond à vos filtres.</p>
  <?php else: ?>
  <div class="ressources-full-grid">
    <?php foreach ($ressources as $r): ?>
    <div class="ressource-card-full">
      <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:14px">
        <div class="ri-icon" style="width:52px;height:52px;font-size:24px;border-radius:12px;background:var(--rouge-light);display:flex;align-items:center;justify-content:center">
          <?= $iconeRessource[$r['type']] ?? '📄' ?>
        </div>
        <span class="ri-badge" style="<?= $badgeCss[$r['tag_badge']] ?? '' ?>;font-size:11px;font-weight:700;padding:4px 10px;border-radius:20px">
          <?= ucfirst(esc($r['tag_badge'])) ?>
        </span>
      </div>
      <h3 style="font-family:'Playfair Display',serif;font-size:18px;margin-bottom:8px"><?= esc($r['titre']) ?></h3>
      <p style="font-size:14px;color:var(--gris);line-height:1.6;margin-bottom:16px;flex:1"><?= esc($r['description_courte']) ?></p>
      <div style="display:flex;align-items:center;justify-content:space-between;padding-top:14px;border-top:1px solid var(--beige-dark)">
        <span class="prix"><?= number_format((float)$r['prix'], 0) ?> TND</span>
        <a href="<?= site_url('ressources/' . $r['slug']) ?>" class="btn-primary" style="padding:8px 18px;font-size:13px">Acheter →</a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</section>
