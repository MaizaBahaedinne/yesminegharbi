<?php
/**
 * Formations — yesminegharbi.com
 * Catalogue complet des formations vidéo
 */
session_start();
$page_title       = 'Formations — Yesmine Gharbi';
$page_description = 'Catalogue complet des formations en recrutement, CV, entretien et personal branding par Yesmine Gharbi.';
require_once 'includes/header.php';

// Sample formations data (in production, this would come from a database/CMS)
$formations = [
  [
    'id'          => 1,
    'slug'        => 'cv-linkedin-optimises',
    'titre'       => 'CV & LinkedIn Optimisés',
    'court'       => 'Créez un CV qui passe les filtres ATS et un profil LinkedIn qui attire les recruteurs.',
    'prix'        => 49,
    'niveau'      => 'junior',
    'niveau_label'=> 'Junior',
    'theme'       => 'cv',
    'theme_label' => 'CV',
    'modules'     => 5,
    'heures'      => '3h',
    'statut'      => 'bientot',
    'populaire'   => false,
  ],
  [
    'id'          => 2,
    'slug'        => 'reussir-entretiens',
    'titre'       => 'Réussir ses Entretiens',
    'court'       => "Préparez chaque type d'entretien avec des techniques éprouvées et des réponses modèles.",
    'prix'        => 59,
    'niveau'      => 'tous',
    'niveau_label'=> 'Tous niveaux',
    'theme'       => 'entretien',
    'theme_label' => 'Entretien',
    'modules'     => 6,
    'heures'      => '4h',
    'statut'      => 'bientot',
    'populaire'   => true,
  ],
  [
    'id'          => 3,
    'slug'        => 'recrutement-efficace',
    'titre'       => 'Recrutement Efficace',
    'court'       => 'Optimisez vos processus de recrutement et trouvez les meilleurs talents plus rapidement.',
    'prix'        => 79,
    'niveau'      => 'experimente',
    'niveau_label'=> 'Expérimenté',
    'theme'       => 'recrutement',
    'theme_label' => 'Recrutement',
    'modules'     => 7,
    'heures'      => '5h',
    'statut'      => 'bientot',
    'populaire'   => false,
  ],
];

// Icon SVG for each theme
$icons = [
  'cv'          => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
  'entretien'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>',
  'recrutement' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
  'branding'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>',
];
?>

<!-- ===== PAGE HEADER ===== -->
<section class="page-header">
  <div class="container">
    <nav class="breadcrumb" aria-label="Fil d'Ariane">
      <a href="/">Accueil</a>
      <span aria-hidden="true">›</span>
      <span>Formations</span>
    </nav>
    <h1 class="page-header__title">Formations</h1>
    <p class="page-header__desc">Des formations vidéo courtes et actionnables, conçues à partir de cas réels de recrutement en Tunisie.</p>
  </div>
</section>

<!-- ===== FORMATIONS CATALOGUE ===== -->
<section class="section" aria-labelledby="catalogue-heading">
  <div class="container">

    <!-- Filters -->
    <div role="group" aria-label="Filtres de formations">
      <div class="filter-bar" style="margin-bottom:12px">
        <span class="filter-bar__label">Niveau :</span>
        <button class="filter-btn active" data-filter="niveau" data-value="tous">Tous</button>
        <button class="filter-btn" data-filter="niveau" data-value="junior">Junior</button>
        <button class="filter-btn" data-filter="niveau" data-value="experimente">Expérimenté</button>
      </div>
      <div class="filter-bar">
        <span class="filter-bar__label">Thème :</span>
        <button class="filter-btn active" data-filter="theme" data-value="tous">Tous</button>
        <button class="filter-btn" data-filter="theme" data-value="cv">CV</button>
        <button class="filter-btn" data-filter="theme" data-value="entretien">Entretien</button>
        <button class="filter-btn" data-filter="theme" data-value="recrutement">Recrutement</button>
        <button class="filter-btn" data-filter="theme" data-value="branding">Personal Branding</button>
      </div>
    </div>

    <h2 id="catalogue-heading" class="sr-only">Catalogue de formations</h2>

    <!-- Formations Grid -->
    <div class="card-grid" id="formationsGrid" role="list">
      <?php foreach ($formations as $f): ?>
      <article class="card"
               data-niveau="<?= htmlspecialchars($f['niveau']) ?>"
               data-theme="<?= htmlspecialchars($f['theme']) ?>"
               role="listitem">
        <div class="card__cover-placeholder" aria-label="Couverture : <?= htmlspecialchars($f['titre']) ?>">
          <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <?= $icons[$f['theme']] ?? $icons['cv'] ?>
          </svg>
        </div>
        <div class="card__body">
          <div class="card__meta">
            <span class="badge badge--bientot"><?= $f['statut'] === 'bientot' ? 'Bientôt disponible' : 'Disponible' ?></span>
            <?php if ($f['populaire']): ?>
            <span class="badge badge--populaire">Populaire</span>
            <?php else: ?>
            <span class="badge badge--nouveau"><?= htmlspecialchars($f['niveau_label']) ?></span>
            <?php endif; ?>
          </div>
          <h3 class="card__title"><?= htmlspecialchars($f['titre']) ?></h3>
          <p class="card__desc"><?= htmlspecialchars($f['court']) ?></p>
          <div class="card__info">
            <span class="card__info-item">
              <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/></svg>
              <?= (int)$f['modules'] ?> modules
            </span>
            <span class="card__info-item">
              <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
              <?= htmlspecialchars($f['heures']) ?> de contenu
            </span>
            <span class="card__info-item">
              <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              <?= htmlspecialchars($f['theme_label']) ?>
            </span>
          </div>
          <div class="card__footer">
            <div>
              <div class="card__price"><?= (int)$f['prix'] ?> TND</div>
            </div>
            <a href="/formation.php?slug=<?= urlencode($f['slug']) ?>" class="btn btn--primary btn--sm">
              Accéder à la formation
            </a>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>

    <!-- Empty state -->
    <div id="formationsEmpty" class="hidden" style="text-align:center;padding:var(--space-3xl)">
      <p class="text-muted">Aucune formation ne correspond à vos filtres.</p>
      <button class="btn btn--secondary mt-md reset-filters">Réinitialiser les filtres</button>
    </div>

  </div>
</section>

<!-- ===== CTA NEWSLETTER ===== -->
<section class="section section--beige" aria-labelledby="notif-heading">
  <div class="container" style="max-width:680px">
    <div style="text-align:center">
      <span class="section__tag">Notifications</span>
      <h2 style="font-size:var(--text-2xl);font-weight:700;margin-bottom:var(--space-md)" id="notif-heading">
        Soyez notifié·e à l'ouverture
      </h2>
      <p style="color:var(--color-muted);margin-bottom:var(--space-xl)">
        Les formations ouvriront bientôt. Laissez votre email pour être parmi les premiers à y accéder.
      </p>
      <form class="email-capture__form" style="max-width:440px;margin:0 auto;display:flex;gap:12px"
            action="/api/newsletter.php" method="POST" novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
        <input type="hidden" name="tag" value="notif-formations">
        <input type="email" name="email" class="form-input" placeholder="votre@email.com" required aria-label="Email">
        <button type="submit" class="btn btn--primary" style="white-space:nowrap">Me notifier</button>
      </form>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
