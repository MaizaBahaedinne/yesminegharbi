<?php
/**
 * View: pages/home.php
 * Données : $formations[], $ressources_free[], $ressources_premium[]
 */

$iconesFormation = [
    'cv'          => '📄',
    'entretien'   => '🎤',
    'recrutement' => '💼',
    'branding'    => '🔗',
];
$badgeFormation = [
    'disponible' => '<span class="formation-badge badge-disponible">Disponible</span>',
    'bientot'    => '<span class="formation-badge badge-bientot">Bientôt</span>',
    'archive'    => '',
];
$iconeRessource = [
    'checklist' => '📋',
    'template'  => '📝',
    'ebook'     => '💡',
    'guide'     => '📊',
    'kit'       => '🎯',
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
    <div class="hero-stats">
      <div class="stat">
        <span class="stat-num">+50K</span>
        <span class="stat-label">Abonnés</span>
      </div>
      <div class="stat">
        <span class="stat-num"><?= count($formations) ?></span>
        <span class="stat-label">Formations</span>
      </div>
      <div class="stat">
        <span class="stat-num">+10</span>
        <span class="stat-label">Ressources</span>
      </div>
    </div>
  </div>

  <div class="hero-visual">
    <div class="hero-photo-frame">
      <div class="photo-placeholder">
        <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="#b8a898" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
        </svg>
        Votre photo ici
      </div>
      <div class="floating-card floating-card-1">
        <span class="fc-emoji">🎓</span>
        <span>Formation vendue !</span>
      </div>
      <div class="floating-card floating-card-2">
        <span class="fc-emoji">⭐</span>
        <span>+200 avis 5 étoiles</span>
      </div>
    </div>
  </div>
</section>

<!-- =============================================
     TRUST BAND
     ============================================= -->
<div class="trust-band">
  <div class="trust-item"><strong>TikTok</strong> · Recrutement &amp; CV</div>
  <div class="trust-sep">|</div>
  <div class="trust-item"><strong>Instagram</strong> · Conseils pro</div>
  <div class="trust-sep">|</div>
  <div class="trust-item"><strong>LinkedIn</strong> · Personal branding</div>
  <div class="trust-sep">|</div>
  <div class="trust-item"><strong>Facebook</strong> · Communauté</div>
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
      <span class="audience-icon">🎯</span>
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
      <span class="audience-icon">📋</span>
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
      <span class="audience-icon">🏢</span>
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
        <?= $iconesFormation[$f['theme']] ?? '📚' ?>
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
          <div class="ri-icon"><?= $iconeRessource[$r['type']] ?? '📄' ?></div>
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
          <div class="ri-icon"><?= $iconeRessource[$r['type']] ?? '📄' ?></div>
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
          <div class="b2b-service-icon rouge">🎬</div>
          <div>
            <h4>Création de contenu RH</h4>
            <p>Vidéos, posts LinkedIn, carousels — du contenu qui parle vraiment à vos candidats.</p>
          </div>
        </div>
        <div class="b2b-service">
          <div class="b2b-service-icon sauge">🎓</div>
          <div>
            <h4>Formations équipes RH</h4>
            <p>Sessions de formation sur-mesure : sourcing, entretiens, marque employeur.</p>
          </div>
        </div>
        <div class="b2b-service">
          <div class="b2b-service-icon or">🤝</div>
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
    <div class="apropos-photo">👩‍💼</div>
    <div class="apropos-content">
      <h2>Yesmine Gharbi</h2>
      <span class="apropos-title">Spécialiste Recrutement &amp; Créatrice de contenu RH</span>
      <p>Après plusieurs années en cabinet et en entreprise, j'ai décidé de partager ce que j'ai appris sur le terrain — pas dans les manuels. Mon objectif : rendre les ressources RH accessibles, pratiques et vraiment utiles, que vous soyez candidat, recruteur ou entreprise.</p>
      <div class="social-links">
        <a href="https://tiktok.com/@yesminegharbi" class="social-link" target="_blank" rel="noopener">📱 TikTok</a>
        <a href="https://instagram.com/yesminegharbi" class="social-link" target="_blank" rel="noopener">📸 Instagram</a>
        <a href="https://linkedin.com/in/yesminegharbi" class="social-link" target="_blank" rel="noopener">💼 LinkedIn</a>
        <a href="https://facebook.com/yesminegharbi" class="social-link" target="_blank" rel="noopener">👥 Facebook</a>
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
    <div class="temoignage">
      <div class="stars">★★★★★</div>
      <p>« Grâce à la formation entretien, j'ai décroché un CDI en moins de 3 semaines. Les conseils sont concrets et adaptés au marché tunisien. »</p>
      <div class="temoignage-author">
        <div class="author-avatar" style="background:var(--sauge)">SA</div>
        <div class="author-info"><h4>Sana A.</h4><span>Chef de projet, Tunis</span></div>
      </div>
    </div>
    <div class="temoignage">
      <div class="stars">★★★★★</div>
      <p>« Le kit recruteur m'a fait gagner un temps fou. Des outils vraiment professionnels, pensés par quelqu'un qui sait ce qu'est le terrain. »</p>
      <div class="temoignage-author">
        <div class="author-avatar" style="background:var(--rouge)">MB</div>
        <div class="author-info"><h4>Mohamed B.</h4><span>Responsable RH, Sfax</span></div>
      </div>
    </div>
    <div class="temoignage">
      <div class="stars">★★★★★</div>
      <p>« Yesmine a créé du contenu pour notre entreprise et le retour a été exceptionnel. Notre image employeur a vraiment évolué. »</p>
      <div class="temoignage-author">
        <div class="author-avatar" style="background:var(--or)">LC</div>
        <div class="author-info"><h4>Leila C.</h4><span>DRH, Start-up Tunis</span></div>
      </div>
    </div>
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
