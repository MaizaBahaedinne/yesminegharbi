<?php
$iconesFormation = [
    'cv'          => '<i class="fa-solid fa-file-lines" aria-hidden="true"></i>',
    'entretien'   => '<i class="fa-solid fa-microphone" aria-hidden="true"></i>',
    'recrutement' => '<i class="fa-solid fa-briefcase" aria-hidden="true"></i>',
    'branding'    => '<i class="fa-solid fa-link" aria-hidden="true"></i>',
];

// Dégradés par thème
$coverGradients = [
    'cv'          => ['#EA2E00','#FF6B3D'],
    'entretien'   => ['#1F1F1F','#4A4A4A'],
    'recrutement' => ['#C49A3C','#E8C060'],
    'branding'    => ['#9DBDB8','#4A8F89'],
];
// Icônes SVG par thème
$coverIcons = [
    'cv' => '<svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.9)" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>',
    'entretien' => '<svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.9)" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>',
    'recrutement' => '<svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.9)" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
    'branding' => '<svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.9)" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>',
];
?>

<!-- PAGE HEADER -->
<div class="page-header">
  <div class="page-header-inner">
    <span class="section-tag">Formations</span>
    <h1>Toutes les formations</h1>
    <p>Des formations vidéo pratiques, conçues à partir de l'expérience réelle du recrutement.</p>
  </div>
</div>

<section>
  <!-- Filtres -->
  <div class="filter-area">
    <div class="filter-row">
      <span class="filter-label">Niveau :</span>
      <a href="?niveau=tous&theme=<?= esc($active_theme) ?>" class="filter-btn <?= $active_niveau === 'tous' ? 'active' : '' ?>">Tous</a>
      <a href="?niveau=junior&theme=<?= esc($active_theme) ?>" class="filter-btn <?= $active_niveau === 'junior' ? 'active' : '' ?>">Junior</a>
      <a href="?niveau=experimente&theme=<?= esc($active_theme) ?>" class="filter-btn <?= $active_niveau === 'experimente' ? 'active' : '' ?>">Expérimenté</a>
    </div>
    <div class="filter-row" style="margin-top:10px">
      <span class="filter-label">Thème :</span>
      <a href="?niveau=<?= esc($active_niveau) ?>&theme=tous"          class="filter-btn <?= $active_theme === 'tous' ? 'active' : '' ?>">Tous</a>
      <a href="?niveau=<?= esc($active_niveau) ?>&theme=cv"            class="filter-btn <?= $active_theme === 'cv' ? 'active' : '' ?>">CV</a>
      <a href="?niveau=<?= esc($active_niveau) ?>&theme=entretien"     class="filter-btn <?= $active_theme === 'entretien' ? 'active' : '' ?>">Entretien</a>
      <a href="?niveau=<?= esc($active_niveau) ?>&theme=recrutement"   class="filter-btn <?= $active_theme === 'recrutement' ? 'active' : '' ?>">Recrutement</a>
      <a href="?niveau=<?= esc($active_niveau) ?>&theme=branding"      class="filter-btn <?= $active_theme === 'branding' ? 'active' : '' ?>">Personal Branding</a>
    </div>
  </div>

  <!-- Grille -->
  <?php if (empty($formations)): ?>
  <div style="text-align:center;padding:60px 0;color:var(--gris)">
    <p>Aucune formation ne correspond à vos filtres.</p>
    <a href="<?= site_url('formations') ?>" class="btn-sm" style="margin-top:16px;display:inline-block">Voir toutes les formations</a>
  </div>
  <?php else: ?>
  <div class="formations-grid">
    <?php foreach ($formations as $f): ?>
    <div class="formation-card">
      <div class="formation-thumb">
        <?php if (!empty($f['cover_image'])): ?>
          <img src="<?= base_url('assets/covers/' . esc($f['cover_image'])) ?>" alt="<?= esc($f['titre']) ?>" style="width:100%;height:100%;object-fit:cover;display:block">
        <?php else:
          $g = $coverGradients[$f['theme']] ?? ['#EA2E00','#FF6B3D'];
          $ico = $coverIcons[$f['theme']] ?? $coverIcons['cv'];
          $shortTitle = mb_strlen($f['titre']) > 30 ? mb_substr($f['titre'],0,30).'…' : $f['titre'];
        ?>
          <div style="width:100%;height:100%;background:linear-gradient(135deg,<?= $g[0] ?>,<?= $g[1] ?>);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:12px;padding:20px">
            <?= $ico ?>
            <span style="color:rgba(255,255,255,.95);font-family:'Playfair Display',serif;font-size:14px;font-weight:700;text-align:center;line-height:1.3"><?= esc($shortTitle) ?></span>
          </div>
        <?php endif; ?>
        <?php if ($f['statut'] === 'disponible'): ?>
          <span class="formation-badge badge-disponible">Disponible</span>
        <?php else: ?>
          <span class="formation-badge badge-bientot">Bientôt</span>
        <?php endif; ?>
        <?php if ($f['is_populaire']): ?>
          <span class="formation-badge" style="left:auto;right:12px;background:var(--or);color:white"><i class="fa-solid fa-star" aria-hidden="true"></i> Populaire</span>
        <?php endif; ?>
      </div>
      <div class="formation-body">
        <div class="formation-meta">
          <span class="tag"><?= $f['theme'] === 'branding' ? 'Personal Branding' : ucfirst(esc($f['theme'])) ?></span>
          <span class="tag"><?= $f['niveau'] === 'tous' ? 'Tous niveaux' : ucfirst(esc($f['niveau'])) ?></span>
        </div>
        <h3><?= esc($f['titre']) ?></h3>
        <p><?= esc($f['description_courte']) ?></p>
        <div style="display:flex;gap:12px;margin-bottom:16px;font-size:13px;color:var(--gris)">
          <span><i class="fa-solid fa-clapperboard" aria-hidden="true"></i> <?= (int)$f['modules_count'] ?> modules</span>
          <span><i class="fa-solid fa-stopwatch" aria-hidden="true"></i> <?= esc($f['heures']) ?></span>
        </div>
        <div class="formation-footer">
          <?php if ($f['statut'] === 'bientot'): ?>
            <div class="prix" style="color:var(--gris)">À venir</div>
            <a href="<?= site_url('formations/' . $f['slug']) ?>" class="btn-sm" style="border-color:var(--beige-dark);color:var(--gris)">Notifier →</a>
          <?php else: ?>
            <div class="prix"><?= number_format((float)$f['prix'], 0) ?> TND <span>· <?= (int)$f['modules_count'] ?> modules</span></div>
            <a href="<?= site_url('formations/' . $f['slug']) ?>" class="btn-sm">Accéder →</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</section>

<!-- CTA NOTIFICATION -->
<div class="cta-final">
  <span class="section-tag">Notifications</span>
  <h2>Soyez notifié·e à l'ouverture</h2>
  <p>Les nouvelles formations arrivent bientôt. Laissez votre email pour y accéder en premier.</p>
  <form class="newsletter-form" id="newsletterForm" novalidate>
    <?= csrf_field() ?>
    <input type="hidden" name="tag" value="notif-formations">
    <input type="email" name="email" placeholder="votre@email.com" required>
    <button type="submit">Me notifier</button>
  </form>
  <div id="newsletterMsg" style="margin-top:10px;font-size:14px;font-weight:600"></div>
</div>
