<?php
$isArabic = ($siteLocale ?? 'fr') === 'ar';
$isEnglish = ($siteLocale ?? 'fr') === 'en';
$text = $isArabic ? [
  'all_resources' => 'جميع الموارد', 'resources' => 'الموارد', 'intro' => 'جميع الموارد في مكان واحد، مع خيارات للتصفية.',
  'access' => 'الوصول', 'type' => 'النوع', 'topic' => 'الموضوع', 'all' => 'الكل',
  'free' => 'مجاني', 'premium' => 'مميز', 'empty' => 'لا توجد موارد تطابق عوامل التصفية.',
  'download' => 'تحميل ←', 'buy' => 'شراء ←', 'view' => 'عرض ←', 'free_badge' => 'مجاني',
  'types' => ['atelier' => 'ورشة', 'methode' => 'منهجية', 'guide' => 'دليل', 'template' => 'قالب', 'checklist' => 'قائمة تحقق', 'kit' => 'حزمة'],
  'topics' => ['carriere' => 'المسار المهني', 'recherche-emploi' => 'البحث عن عمل', 'cv-candidature' => 'السيرة الذاتية والترشح', 'linkedin-branding' => 'لينكدإن والعلامة الشخصية', 'recrutement-rh' => 'التوظيف والموارد البشرية', 'marque-employeur' => 'العلامة كجهة عمل', 'apprentissage-formation' => 'التعلم والتدريب', 'ia-carriere' => 'الذكاء الاصطناعي والمسار المهني'],
  'badges' => ['populaire' => 'الأكثر رواجاً', 'nouveau' => 'جديد', 'premium' => 'مميز', 'gratuit' => 'مجاني'],
] : [
  'all_resources' => 'Toutes les ressources', 'resources' => 'Ressources', 'intro' => 'Toutes les ressources dans un seul affichage, avec filtres en haut.',
  'access' => 'Accès', 'type' => 'Type', 'topic' => 'Thématique', 'all' => 'Tous',
  'free' => 'Gratuit', 'premium' => 'Premium', 'empty' => 'Aucune ressource ne correspond à vos filtres.',
  'download' => 'Télécharger →', 'buy' => 'Acheter →', 'view' => 'Consulter →', 'free_badge' => 'Gratuit',
  'types' => [], 'topics' => [], 'badges' => [],
];
if ($isEnglish) {
  $text = array_replace($text, [
    'all_resources' => 'All resources', 'resources' => 'Resources', 'intro' => 'Browse all resources in one place and filter to find what you need.',
    'access' => 'Access', 'type' => 'Type', 'topic' => 'Topic', 'all' => 'All',
    'free' => 'Free', 'premium' => 'Premium', 'empty' => 'No resources match your filters.',
    'download' => 'Download →', 'buy' => 'Buy →', 'view' => 'View →', 'free_badge' => 'Free',
    'types' => ['atelier' => 'Workshop', 'methode' => 'Method', 'guide' => 'Guide', 'template' => 'Template', 'checklist' => 'Checklist', 'kit' => 'Kit'],
    'topics' => ['carriere' => 'Career', 'recherche-emploi' => 'Job search', 'cv-candidature' => 'CV & applications', 'linkedin-branding' => 'LinkedIn & personal branding', 'recrutement-rh' => 'Recruitment & HR', 'marque-employeur' => 'Employer brand', 'apprentissage-formation' => 'Learning & training', 'ia-carriere' => 'AI & careers'],
    'badges' => ['populaire' => 'Popular', 'nouveau' => 'New', 'premium' => 'Premium', 'gratuit' => 'Free'],
  ]);
}
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
    <span class="section-tag"><?= esc($text['all_resources']) ?></span>
    <h1><?= esc($text['resources']) ?></h1>
    <p><?= esc($text['intro']) ?></p>
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
      'access'     => ['label' => $text['access'], 'options' => ['gratuit' => $text['free'], 'premium' => $text['premium']], 'translations' => []],
      'type'       => ['label' => $text['type'], 'options' => \App\Models\RessourceModel::TYPES, 'translations' => $text['types']],
      'thematique' => ['label' => $text['topic'], 'options' => \App\Models\RessourceModel::THEMATIQUES, 'translations' => $text['topics']],
  ];
  ?>
  <div class="filter-area">
    <?php $first = true; foreach ($filterGroups as $key => $group): ?>
    <div class="filter-row"<?= $first ? '' : ' style="margin-top:10px"' ?>>
      <span class="filter-label"><?= esc($group['label']) ?> :</span>
      <a href="<?= esc($filterUrl($key, 'tous')) ?>" class="filter-btn <?= $filters[$key] === 'tous' ? 'active' : '' ?>"><?= esc($text['all']) ?></a>
      <?php foreach ($group['options'] as $value => $label): ?>
      <a href="<?= esc($filterUrl($key, $value)) ?>" class="filter-btn <?= $filters[$key] === $value ? 'active' : '' ?>"><?= esc($group['translations'][$value] ?? $label) ?></a>
      <?php endforeach; ?>
    </div>
    <?php $first = false; endforeach; ?>
  </div>

  <?php if (empty($resources)): ?>
    <p style="text-align:center;color:var(--gris);padding:40px 0"><?= esc($text['empty']) ?></p>
  <?php else: ?>
    <div class="ressources-full-grid">
      <?php foreach ($resources as $r): ?>
        <div class="ressource-card-full">
          <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:14px">
            <div class="ri-icon" style="width:52px;height:52px;font-size:24px;border-radius:12px;background:<?= !empty($r['is_premium']) ? 'var(--rouge-light)' : 'var(--sauge-light)' ?>;display:flex;align-items:center;justify-content:center">
              <?= $iconeRessource[$r['type']] ?? '<i class="fa-solid fa-file-lines" aria-hidden="true"></i>' ?>
            </div>
            <span class="ri-badge" style="<?= !empty($r['is_premium']) ? ($badgeCss[$r['tag_badge']] ?? 'background:var(--rouge);color:white') : 'background:var(--sauge);color:white' ?>;font-size:11px;font-weight:700;padding:4px 10px;border-radius:20px">
              <?= esc(!empty($r['is_premium']) ? ($text['badges'][$r['tag_badge'] ?? 'premium'] ?? ucfirst($r['tag_badge'] ?? 'premium')) : $text['free_badge']) ?>
            </span>
          </div>
          <h3 style="font-family:'Playfair Display',serif;font-size:18px;margin-bottom:8px"><?= esc($r['titre']) ?></h3>
          <p style="font-size:14px;color:var(--gris);line-height:1.6;margin-bottom:16px;flex:1"><?= esc($r['description_courte']) ?></p>
          <div style="display:flex;align-items:center;justify-content:space-between;padding-top:14px;border-top:1px solid var(--beige-dark)">
            <?php if (!empty($r['is_premium'])): ?>
              <span class="prix"><?= number_format((float) $r['prix'], 0) ?> TND</span>
              <a href="<?= site_url('ressources/' . ($r['slug'] ?? '')) ?>" class="btn-primary" style="padding:8px 18px;font-size:13px"><?= esc($text['buy']) ?></a>
            <?php else: ?>
              <span style="font-size:12px;color:var(--gris)"><?= esc($text['types'][$r['type']] ?? (\App\Models\RessourceModel::TYPES[$r['type']] ?? ucfirst($r['type']))) ?></span>
              <?php if (!empty($isLoggedIn) && in_array((int) $r['id'], $ownedResourceIds ?? [], true)): ?>
                <a href="<?= site_url('ressources/download/' . ($r['slug'] ?? '')) ?>" class="btn-primary" style="display:inline-flex"><?= esc($text['download']) ?></a>
              <?php elseif (!empty($isLoggedIn)): ?>
                <a href="<?= site_url('ressources/' . ($r['slug'] ?? '')) ?>" class="btn-primary" style="display:inline-flex"><?= esc($text['view']) ?></a>
              <?php else: ?>
                <button class="btn-primary open-download" data-id="<?= (int) $r['id'] ?>" data-titre="<?= esc($r['titre']) ?>"><?= esc($text['download']) ?></button>
              <?php endif; ?>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>
