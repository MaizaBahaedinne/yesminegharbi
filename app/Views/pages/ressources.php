<?php
$iconeRessource = [
    'checklist' => '<i class="fa-solid fa-clipboard-list" aria-hidden="true"></i>',
    'template'  => '<i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>',
    'ebook'     => '<i class="fa-solid fa-lightbulb" aria-hidden="true"></i>',
    'guide'     => '<i class="fa-solid fa-chart-column" aria-hidden="true"></i>',
    'kit'       => '<i class="fa-solid fa-bullseye" aria-hidden="true"></i>',
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
    <span class="section-tag">Toutes les ressources</span>
    <h1>Ressources</h1>
    <p>Toutes les ressources dans un seul affichage, avec filtres en haut.</p>
  </div>
</div>

<section>
  <div class="filter-area">
    <div class="filter-row">
      <span class="filter-label">Accès :</span>
      <a href="?access=tous&type=<?= esc($active_type ?? 'tous') ?>&profil=<?= esc($active_profil ?? 'tous') ?>" class="filter-btn <?= ($active_access ?? 'tous') === 'tous' ? 'active' : '' ?>">Tous</a>
      <a href="?access=gratuit&type=<?= esc($active_type ?? 'tous') ?>&profil=<?= esc($active_profil ?? 'tous') ?>" class="filter-btn <?= ($active_access ?? 'tous') === 'gratuit' ? 'active' : '' ?>">Gratuit</a>
      <a href="?access=premium&type=<?= esc($active_type ?? 'tous') ?>&profil=<?= esc($active_profil ?? 'tous') ?>" class="filter-btn <?= ($active_access ?? 'tous') === 'premium' ? 'active' : '' ?>">Premium</a>
    </div>
    <div class="filter-row" style="margin-top:10px">
      <span class="filter-label">Type :</span>
      <a href="?access=<?= esc($active_access ?? 'tous') ?>&type=tous&profil=<?= esc($active_profil ?? 'tous') ?>" class="filter-btn <?= ($active_type ?? 'tous') === 'tous' ? 'active' : '' ?>">Tous</a>
      <a href="?access=<?= esc($active_access ?? 'tous') ?>&type=guide&profil=<?= esc($active_profil ?? 'tous') ?>" class="filter-btn <?= ($active_type ?? 'tous') === 'guide' ? 'active' : '' ?>">Guide PDF</a>
      <a href="?access=<?= esc($active_access ?? 'tous') ?>&type=template&profil=<?= esc($active_profil ?? 'tous') ?>" class="filter-btn <?= ($active_type ?? 'tous') === 'template' ? 'active' : '' ?>">Template</a>
      <a href="?access=<?= esc($active_access ?? 'tous') ?>&type=checklist&profil=<?= esc($active_profil ?? 'tous') ?>" class="filter-btn <?= ($active_type ?? 'tous') === 'checklist' ? 'active' : '' ?>">Checklist</a>
      <a href="?access=<?= esc($active_access ?? 'tous') ?>&type=kit&profil=<?= esc($active_profil ?? 'tous') ?>" class="filter-btn <?= ($active_type ?? 'tous') === 'kit' ? 'active' : '' ?>">Kit complet</a>
    </div>
    <div class="filter-row" style="margin-top:10px">
      <span class="filter-label">Profil :</span>
      <a href="?access=<?= esc($active_access ?? 'tous') ?>&type=<?= esc($active_type ?? 'tous') ?>&profil=tous" class="filter-btn <?= ($active_profil ?? 'tous') === 'tous' ? 'active' : '' ?>">Tous</a>
      <a href="?access=<?= esc($active_access ?? 'tous') ?>&type=<?= esc($active_type ?? 'tous') ?>&profil=junior" class="filter-btn <?= ($active_profil ?? 'tous') === 'junior' ? 'active' : '' ?>">Junior</a>
      <a href="?access=<?= esc($active_access ?? 'tous') ?>&type=<?= esc($active_type ?? 'tous') ?>&profil=experimente" class="filter-btn <?= ($active_profil ?? 'tous') === 'experimente' ? 'active' : '' ?>">Expérimenté</a>
      <a href="?access=<?= esc($active_access ?? 'tous') ?>&type=<?= esc($active_type ?? 'tous') ?>&profil=recruteur" class="filter-btn <?= ($active_profil ?? 'tous') === 'recruteur' ? 'active' : '' ?>">Recruteur</a>
    </div>
  </div>

  <?php if (empty($resources)): ?>
    <p style="text-align:center;color:var(--gris);padding:40px 0">Aucune ressource ne correspond à vos filtres.</p>
  <?php else: ?>
    <div class="ressources-full-grid">
      <?php foreach ($resources as $r): ?>
        <div class="ressource-card-full">
          <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:14px">
            <div class="ri-icon" style="width:52px;height:52px;font-size:24px;border-radius:12px;background:<?= !empty($r['is_premium']) ? 'var(--rouge-light)' : 'var(--sauge-light)' ?>;display:flex;align-items:center;justify-content:center">
              <?= $iconeRessource[$r['type']] ?? '<i class="fa-solid fa-file-lines" aria-hidden="true"></i>' ?>
            </div>
            <span class="ri-badge" style="<?= !empty($r['is_premium']) ? ($badgeCss[$r['tag_badge']] ?? 'background:var(--rouge);color:white') : 'background:var(--sauge);color:white' ?>;font-size:11px;font-weight:700;padding:4px 10px;border-radius:20px">
              <?= !empty($r['is_premium']) ? ucfirst(esc($r['tag_badge'] ?? 'premium')) : 'Gratuit' ?>
            </span>
          </div>
          <h3 style="font-family:'Playfair Display',serif;font-size:18px;margin-bottom:8px"><?= esc($r['titre']) ?></h3>
          <p style="font-size:14px;color:var(--gris);line-height:1.6;margin-bottom:16px;flex:1"><?= esc($r['description_courte']) ?></p>
          <div style="display:flex;align-items:center;justify-content:space-between;padding-top:14px;border-top:1px solid var(--beige-dark)">
            <?php if (!empty($r['is_premium'])): ?>
              <span class="prix"><?= number_format((float) $r['prix'], 0) ?> TND</span>
              <a href="<?= site_url('ressources/' . ($r['slug'] ?? '')) ?>" class="btn-primary" style="padding:8px 18px;font-size:13px">Acheter →</a>
            <?php else: ?>
              <span style="font-size:12px;color:var(--gris)"><?= strtoupper(esc($r['type'])) ?></span>
              <?php if (!empty($isLoggedIn) && in_array((int) $r['id'], $ownedResourceIds ?? [], true)): ?>
                <a href="<?= site_url('ressources/download/request-code/' . ($r['slug'] ?? '')) ?>" class="btn-primary" style="display:inline-flex">Vérifier et télécharger →</a>
              <?php elseif (!empty($isLoggedIn)): ?>
                <a href="<?= site_url('ressources/' . ($r['slug'] ?? '')) ?>" class="btn-primary" style="display:inline-flex">Consulter →</a>
              <?php else: ?>
                <button class="btn-primary open-download" data-id="<?= (int) $r['id'] ?>" data-titre="<?= esc($r['titre']) ?>">Télécharger →</button>
              <?php endif; ?>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>
