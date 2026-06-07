<?php
$iconesFormation = [
    'cv'          => '📄',
    'entretien'   => '🎤',
    'recrutement' => '💼',
    'branding'    => '🔗',
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
        <?= $iconesFormation[$f['theme']] ?? '📚' ?>
        <?php if ($f['statut'] === 'disponible'): ?>
          <span class="formation-badge badge-disponible">Disponible</span>
        <?php else: ?>
          <span class="formation-badge badge-bientot">Bientôt</span>
        <?php endif; ?>
        <?php if ($f['is_populaire']): ?>
          <span class="formation-badge" style="left:auto;right:12px;background:var(--or);color:white">⭐ Populaire</span>
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
          <span>🎬 <?= (int)$f['modules_count'] ?> modules</span>
          <span>⏱ <?= esc($f['heures']) ?></span>
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
