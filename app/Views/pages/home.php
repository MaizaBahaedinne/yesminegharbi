<?php
/**
 * View: pages/home.php
 * Données : $formations[], $ressources_free[], $ressources_premium[]
 */

$iconesFormation = [
    'cv'          => '<i class="fa-solid fa-file-lines" aria-hidden="true"></i>',
    'entretien'   => '<i class="fa-solid fa-microphone" aria-hidden="true"></i>',
    'recrutement' => '<i class="fa-solid fa-briefcase" aria-hidden="true"></i>',
    'branding'    => '<i class="fa-solid fa-link" aria-hidden="true"></i>',
];
$coverGradients = [
    'cv'          => ['#EA2E00','#FF6B3D'],
    'entretien'   => ['#1F1F1F','#4A4A4A'],
    'recrutement' => ['#C49A3C','#E8C060'],
    'branding'    => ['#9DBDB8','#4A8F89'],
];
$coverIcons = [
    'cv'          => '<svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.9)" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>',
    'entretien'   => '<svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.9)" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>',
    'recrutement' => '<svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.9)" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
    'branding'    => '<svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.9)" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>',
];
$badgeFormation = [
    'disponible' => '<span class="formation-badge badge-disponible">Disponible</span>',
    'bientot'    => '<span class="formation-badge badge-bientot">Bientôt</span>',
    'archive'    => '',
];
$iconeRessource = [
    'checklist' => '<i class="fa-solid fa-clipboard-list" aria-hidden="true"></i>',
    'template'  => '<i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>',
    'ebook'     => '<i class="fa-solid fa-lightbulb" aria-hidden="true"></i>',
    'guide'     => '<i class="fa-solid fa-chart-column" aria-hidden="true"></i>',
    'kit'       => '<i class="fa-solid fa-bullseye" aria-hidden="true"></i>',
];
?>

<!-- =============================================
     HERO
     ============================================= -->
<section class="hero">
  <div class="hero-content">
    <div class="hero-eyebrow">Spécialiste Recrutement &amp; Personal Branding</div>
    <h1>Des conseils terrain,<br>pas des <em>manuels.</em></h1>
    <p class="hero-sub">
      Formations, ressources et accompagnement pour candidats, recruteurs et entreprises.
      Tout ce dont vous avez besoin — en un seul endroit.
    </p>
    <div class="hero-btns">
      <a href="<?= site_url('formations') ?>" class="btn-primary">Voir les formations →</a>
      <a href="<?= site_url('ressources-gratuites') ?>" class="btn-secondary">Ressources gratuites</a>
    </div>
  </div>

  <div class="hero-visual">
    <div class="hero-photo-frame">
      <img src="<?= base_url('assets/img/yesmine.jpg') ?>" alt="Yesmine Gharbi" style="width:100%;height:100%;object-fit:cover;object-position:top;display:block;border-radius:inherit">
      <div class="floating-card floating-card-1">
        <span class="fc-emoji"><i class="fa-solid fa-graduation-cap" aria-hidden="true"></i></span>
        <span>Formation vendue !</span>
      </div>
      <div class="floating-card floating-card-2">
        <span class="fc-emoji"><i class="fa-solid fa-star" aria-hidden="true"></i></span>
        <span>+200 avis 5 étoiles</span>
      </div>
    </div>
  </div>
</section>

<!-- =============================================
     TRUST BAND
     ============================================= -->
<div class="trust-band">
  <?php
  $nets = [
      ['key'=>'tiktok',    'label'=>'TikTok',    'svg'=>'<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.18 8.18 0 0 0 4.78 1.52V6.76a4.85 4.85 0 0 1-1.01-.07z"/></svg>'],
      ['key'=>'instagram', 'label'=>'Instagram', 'svg'=>'<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>'],
      ['key'=>'linkedin',  'label'=>'LinkedIn',  'svg'=>'<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>'],
      ['key'=>'facebook',  'label'=>'Facebook',  'svg'=>'<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>'],
  ];
  foreach ($nets as $i => $n):
      $count = $settings[$n['key'].'_followers'] ?? '';
      $url   = $settings[$n['key'].'_url'] ?? '#';
      if (!$count) continue;
  ?>
  <?php if ($i > 0): ?><div class="trust-sep">|</div><?php endif; ?>
  <a href="<?= esc($url) ?>" target="_blank" rel="noopener" class="trust-item" style="text-decoration:none">
    <strong><?= esc($count) ?></strong>
    <span><?= $n['svg'] ?> <?= $n['label'] ?></span>
  </a>
  <?php endforeach; ?>
</div>

<!-- =============================================
     POUR QUI
     ============================================= -->
<section id="audience">
  <div class="section-header">
    <span class="section-tag">Pour qui ?</span>
    <h2>Un hub pour chaque profil</h2>
    <p class="section-desc">Que vous cherchiez un emploi, que vous recrutiez, ou que vous souhaitiez renforcer votre marque employeur — il y a quelque chose pour vous.</p>
  </div>
  <div class="audience-grid">
    <div class="audience-card candidat">
      <span class="audience-icon"><i class="fa-solid fa-bullseye" aria-hidden="true"></i></span>
      <h3>Candidats</h3>
      <p>Juniors, expérimentés ou en reconversion — améliorez votre CV, LinkedIn et préparez vos entretiens avec des conseils terrain.</p>
      <ul class="audience-list">
        <li>Templates CV ATS-friendly</li>
        <li>Guide entretien complet</li>
        <li>Optimisation profil LinkedIn</li>
        <li>Personal branding digital</li>
      </ul>
    </div>
    <div class="audience-card rh">
      <span class="audience-icon"><i class="fa-solid fa-clipboard-list" aria-hidden="true"></i></span>
      <h3>Recruteurs &amp; RH</h3>
      <p>Optimisez vos processus, formez vos équipes et accédez à des outils conçus pour les professionnels du recrutement.</p>
      <ul class="audience-list">
        <li>Formations process recrutement</li>
        <li>Kits évaluation candidats</li>
        <li>Checklists onboarding</li>
        <li>Ressources sourcing</li>
      </ul>
    </div>
    <div class="audience-card entreprise">
      <span class="audience-icon"><i class="fa-solid fa-building" aria-hidden="true"></i></span>
      <h3>Entreprises</h3>
      <p>Boostez votre marque employeur, formez vos équipes RH et collaborez avec une experte pour attirer les meilleurs talents.</p>
      <ul class="audience-list">
        <li>Stratégie marque employeur</li>
        <li>Formations RH sur-mesure</li>
        <li>Création de contenu RH</li>
        <li>Accompagnement &amp; conseil</li>
      </ul>
    </div>
  </div>
</section>

<!-- =============================================
     FORMATIONS
     ============================================= -->
<section class="section-alt" id="formations">
  <div class="section-header">
    <span class="section-tag">Formations</span>
    <h2>Apprendre du terrain, <em>pas des livres</em></h2>
    <p class="section-desc">Des formations vidéo pratiques, conçues à partir de l'expérience réelle du recrutement en Tunisie et à l'international.</p>
  </div>

  <div class="formations-grid">
    <?php foreach ($formations as $f): ?>
    <div class="formation-card">
      <div class="formation-thumb">
        <?php
          if (!empty($f['cover_image'])):
        ?>
          <img src="<?= base_url('assets/covers/' . esc($f['cover_image'])) ?>" alt="<?= esc($f['titre']) ?>" style="width:100%;height:100%;object-fit:cover;display:block">
        <?php
          else:
            $g = $coverGradients[$f['theme']] ?? ['#EA2E00','#FF6B3D'];
            $ico = $coverIcons[$f['theme']] ?? $coverIcons['cv'];
            $shortTitle = mb_strlen($f['titre']) > 30 ? mb_substr($f['titre'],0,30).'…' : $f['titre'];
        ?>
          <div style="width:100%;height:100%;background:linear-gradient(135deg,<?= $g[0] ?>,<?= $g[1] ?>);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:12px;padding:20px">
            <?= $ico ?>
            <span style="color:rgba(255,255,255,.95);font-family:'Playfair Display',serif;font-size:13px;font-weight:700;text-align:center;line-height:1.3"><?= esc($shortTitle) ?></span>
          </div>
        <?php endif; ?>
        <?= $badgeFormation[$f['statut']] ?? '' ?>
      </div>
      <div class="formation-body">
        <div class="formation-meta">
          <span class="tag"><?= esc(ucfirst($f['theme'] === 'branding' ? 'Personal Branding' : ucfirst($f['theme']))) ?></span>
          <span class="tag"><?= $f['niveau'] === 'tous' ? 'Tous niveaux' : ucfirst(esc($f['niveau'])) ?></span>
        </div>
        <h3><?= esc($f['titre']) ?></h3>
        <p><?= esc($f['description_courte']) ?></p>
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

  <div class="center">
    <a href="<?= site_url('formations') ?>" class="voir-tout">Voir toutes les formations →</a>
  </div>
</section>

<!-- =============================================
     RESSOURCES
     ============================================= -->
<section id="ressources">
  <div class="section-header">
    <span class="section-tag">Ressources</span>
    <h2>Guides, templates &amp; outils</h2>
    <p class="section-desc">Des ressources concrètes à utiliser immédiatement — gratuites ou premium.</p>
  </div>

  <div class="ressources-grid">

    <!-- Gratuites -->
    <div class="ressources-free">
      <div class="ressource-header">
        <h3>Ressources gratuites</h3>
        <span style="font-size:12px;color:var(--gris)">Avec votre email</span>
      </div>
      <div class="ressource-items">
        <?php foreach ($ressources_free as $r): ?>
        <button class="ressource-item open-download"
                data-id="<?= (int)$r['id'] ?>"
                data-titre="<?= esc($r['titre']) ?>">
          <div class="ri-icon"><?= $iconeRessource[$r['type']] ?? '<i class="fa-solid fa-file-lines" aria-hidden="true"></i>' ?></div>
          <div class="ri-info">
            <h4><?= esc($r['titre']) ?></h4>
            <span><?= esc(strtoupper($r['type'])) ?></span>
          </div>
          <span class="ri-badge badge-free">Gratuit</span>
        </button>
        <?php endforeach; ?>
      </div>
      <div class="email-form">
        <input type="email" id="quickEmail" placeholder="votre@email.com">
        <button type="button" onclick="openDownloadAll()">Télécharger</button>
      </div>
    </div>

    <!-- Premium -->
    <div class="ressources-free">
      <div class="ressource-header">
        <h3>Ressources premium</h3>
        <span style="font-size:12px;color:var(--rouge);font-weight:600">Accès immédiat</span>
      </div>
      <div class="ressource-items">
        <?php foreach ($ressources_premium as $r): ?>
        <a href="<?= site_url('ressources/' . $r['slug']) ?>" class="ressource-item">
          <div class="ri-icon"><?= $iconeRessource[$r['type']] ?? '<i class="fa-solid fa-file-lines" aria-hidden="true"></i>' ?></div>
          <div class="ri-info">
            <h4><?= esc($r['titre']) ?></h4>
            <span><?= esc(strtoupper($r['type'])) ?></span>
          </div>
          <span class="ri-badge badge-premium"><?= number_format((float)$r['prix'], 0) ?> TND</span>
        </a>
        <?php endforeach; ?>
      </div>
      <div style="margin-top:16px">
        <a href="<?= site_url('ressources-premium') ?>" class="btn-primary" style="display:block;text-align:center">Voir toutes les ressources →</a>
      </div>
    </div>

  </div>
</section>

<!-- =============================================
     B2B SECTION
     ============================================= -->
<section class="b2b-section" id="entreprises">
  <div class="b2b-inner">
    <div class="b2b-left">
      <span class="section-tag" style="color:var(--sauge)">Pour les entreprises</span>
      <h2>Rayonnez sur votre<br>marque employeur</h2>
      <p>Vous travaillez dans les RH ou vous souhaitez attirer les meilleurs talents ? Collaborons pour créer du contenu, former vos équipes et renforcer votre image employeur.</p>

      <div class="b2b-services">
        <div class="b2b-service">
          <div class="b2b-service-icon rouge"><i class="fa-solid fa-clapperboard" aria-hidden="true"></i></div>
          <div>
            <h4>Création de contenu RH</h4>
            <p>Vidéos, posts LinkedIn, carousels — du contenu qui parle vraiment à vos candidats.</p>
          </div>
        </div>
        <div class="b2b-service">
          <div class="b2b-service-icon sauge"><i class="fa-solid fa-graduation-cap" aria-hidden="true"></i></div>
          <div>
            <h4>Formations équipes RH</h4>
            <p>Sessions de formation sur-mesure : sourcing, entretiens, marque employeur.</p>
          </div>
        </div>
        <div class="b2b-service">
          <div class="b2b-service-icon or"><i class="fa-solid fa-handshake" aria-hidden="true"></i></div>
          <div>
            <h4>Promotion de votre marque</h4>
            <p>Présentez votre entreprise à une audience qualifiée de +50 000 professionnels.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="b2b-right">
      <div class="b2b-stat-card">
        <span class="big-num">+50K</span>
        <span>abonnés actifs sur les réseaux</span>
      </div>
      <div class="b2b-stat-card">
        <span class="big-num">85%</span>
        <span>d'audience dans le domaine professionnel</span>
      </div>
      <div class="b2b-stat-card">
        <span class="big-num">3 ans</span>
        <span>d'expérience terrain en recrutement</span>
      </div>
      <a href="<?= site_url('contact') ?>?sujet=entreprise" class="b2b-cta">Discutons de votre projet →</a>
    </div>
  </div>
</section>

<!-- =============================================
     À PROPOS MINI
     ============================================= -->
<section class="section-alt" id="apropos">
  <div class="apropos-mini">
    <div class="apropos-photo">
      <img src="<?= base_url('assets/img/yesmine.jpg') ?>" alt="Yesmine Gharbi" style="width:100%;height:100%;object-fit:cover">
    </div>
    <div class="apropos-content">
      <h2>Yesmine Gharbi</h2>
      <span class="apropos-title">Spécialiste Recrutement &amp; Créatrice de contenu RH</span>
      <p>Après plusieurs années en cabinet et en entreprise, j'ai décidé de partager ce que j'ai appris sur le terrain — pas dans les manuels. Mon objectif : rendre les ressources RH accessibles, pratiques et vraiment utiles, que vous soyez candidat, recruteur ou entreprise.</p>
      <div class="social-links">
        <a href="https://tiktok.com/@yesminegharbi" class="social-link" target="_blank" rel="noopener"><i class="fa-solid fa-mobile-screen-button" aria-hidden="true"></i> TikTok</a>
        <a href="https://instagram.com/yesminegharbi" class="social-link" target="_blank" rel="noopener"><i class="fa-solid fa-camera" aria-hidden="true"></i> Instagram</a>
        <a href="https://linkedin.com/in/yesminegharbi" class="social-link" target="_blank" rel="noopener"><i class="fa-solid fa-briefcase" aria-hidden="true"></i> LinkedIn</a>
        <a href="https://facebook.com/yesminegharbi" class="social-link" target="_blank" rel="noopener"><i class="fa-solid fa-users" aria-hidden="true"></i> Facebook</a>
      </div>
    </div>
  </div>
</section>

<!-- =============================================
     TÉMOIGNAGES
     ============================================= -->
<section id="temoignages">
  <div class="section-header">
    <span class="section-tag">Ils en parlent</span>
    <h2>Ce que disent nos apprenants</h2>
  </div>
  <div class="temoignages-grid">
    <?php if (! empty($testimonials)): ?>
        <?php foreach ($testimonials as $testimonial): ?>
            <div class="temoignage">
          <div class="stars\"><?= str_repeat('<i class="fa-solid fa-star" aria-hidden="true"></i>', max(1, min(5, (int) $testimonial['rating']))) ?></div>
                <p><?= esc($testimonial['quote']) ?></p>
                <div class="temoignage-author">
                    <div class="author-avatar" style="background:<?= esc($testimonial['avatar_color'] ?: '#EA2E00') ?>"><?= esc($testimonial['avatar_initials'] ?: strtoupper(substr($testimonial['author_name'], 0, 2))) ?></div>
                    <div class="author-info"><h4><?= esc($testimonial['author_name']) ?></h4><span><?= esc($testimonial['author_role']) ?></span></div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="temoignage" style="grid-column:1/-1;text-align:center;">
            <p>Aucun témoignage disponible pour le moment.</p>
        </div>
    <?php endif; ?>
  </div>
</section>

<!-- =============================================
     NEWSLETTER CTA FINAL
     ============================================= -->
<div class="cta-final" id="contact">
  <span class="section-tag">Rejoindre la communauté</span>
  <h2>Restez au courant de tout</h2>
  <p>Nouvelles formations, ressources gratuites, conseils exclusifs — directement dans votre boîte mail.</p>
  <form class="newsletter-form" id="newsletterForm" novalidate>
    <?= csrf_field() ?>
    <input type="email" name="email" placeholder="votre@email.com" required>
    <button type="submit">Je m'abonne</button>
  </form>
  <p style="font-size:12px;color:var(--gris);margin-top:12px">Pas de spam. Désabonnement en un clic.</p>
  <div id="newsletterMsg" style="margin-top:10px;font-size:14px;font-weight:600"></div>
</div>
