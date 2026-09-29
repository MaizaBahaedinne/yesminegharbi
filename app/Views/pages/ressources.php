<?php
$iconeRessource = [
    'checklist' => '<i class="fa-solid fa-clipboard-list" aria-hidden="true"></i>',
    'template'  => '<i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>',
    'ebook'     => '<i class="fa-solid fa-lightbulb" aria-hidden="true"></i>',
    'guide'     => '<i class="fa-solid fa-chart-column" aria-hidden="true"></i>',
    'kit'       => '<i class="fa-solid fa-bullseye" aria-hidden="true"></i>',
    'atelier'   => '<i class="fa-solid fa-video" aria-hidden="true"></i>',
    'methode'   => '<i class="fa-solid fa-diagram-project" aria-hidden="true"></i>',
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
  <?php
  $filters = [
      'access'     => $active_access ?? 'tous',
      'type'       => $active_type ?? 'tous',
      'thematique' => $active_thematique ?? 'tous',
  ];
  $filterUrl = static fn (string $key, string $value): string => '?' . http_build_query(array_merge($filters, [$key => $value]));
  $filterGroups = [
      'access'     => ['label' => 'Accès',      'options' => ['gratuit' => 'Gratuit', 'premium' => 'Premium']],
      'type'       => ['label' => 'Type',       'options' => \App\Models\RessourceModel::TYPES],
      'thematique' => ['label' => 'Thématique', 'options' => \App\Models\RessourceModel::THEMATIQUES],
  ];
  ?>
  <div class="filter-area">
    <?php $first = true; foreach ($filterGroups as $key => $group): ?>
    <div class="filter-row"<?= $first ? '' : ' style="margin-top:10px"' ?>>
      <span class="filter-label"><?= esc($group['label']) ?> :</span>
      <a href="<?= esc($filterUrl($key, 'tous')) ?>" class="filter-btn <?= $filters[$key] === 'tous' ? 'active' : '' ?>">Tous</a>
      <?php foreach ($group['options'] as $value => $label): ?>
      <a href="<?= esc($filterUrl($key, $value)) ?>" class="filter-btn <?= $filters[$key] === $value ? 'active' : '' ?>"><?= esc($label) ?></a>
      <?php endforeach; ?>
    </div>
    <?php $first = false; endforeach; ?>
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
              <span style="font-size:12px;color:var(--gris)"><?= esc(\App\Models\RessourceModel::TYPES[$r['type']] ?? ucfirst($r['type'])) ?></span>
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
