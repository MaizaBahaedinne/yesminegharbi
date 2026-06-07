<?php
/**
 * Accueil — yesminegharbi.com
 * Hub central de marque personnelle
 */
session_start();
$page_title       = 'Yesmine Gharbi — Spécialiste Recrutement & Créatrice de Contenu';
$page_description = 'Formations en ligne, ressources gratuites et conseils recrutement par Yesmine Gharbi. Boostez votre carrière avec des conseils issus du terrain.';
require_once 'includes/header.php';
?>

<!-- =============================================
     HERO
     ============================================= -->
<section class="hero" aria-label="Présentation">
  <div class="container">
    <div class="hero__inner">

      <!-- Left: Text -->
      <div>
        <span class="hero__eyebrow">Spécialiste Recrutement &amp; Créatrice de Contenu</span>
        <h1 class="hero__title">
          Des conseils<br>
          qui viennent<br>
          <em>du terrain</em>
        </h1>
        <p class="hero__subtitle">
          Formations, ressources et guides pratiques pour décrocher votre prochain poste
          — ou recruter les meilleurs talents.
        </p>
        <div class="hero__actions">
          <a href="/formations.php"           class="btn btn--primary btn--lg">Voir les formations →</a>
          <a href="/ressources-gratuites.php" class="btn btn--secondary btn--lg">Ressources gratuites</a>
        </div>

        <!-- Stats -->
        <div class="hero__stats" role="list">
          <div role="listitem">
            <div class="hero__stat-value">+200K</div>
            <div class="hero__stat-label">Abonnés réseaux</div>
          </div>
          <div role="listitem">
            <div class="hero__stat-value">3</div>
            <div class="hero__stat-label">Formations disponibles</div>
          </div>
          <div role="listitem">
            <div class="hero__stat-value">+4</div>
            <div class="hero__stat-label">Guides &amp; templates</div>
          </div>
        </div>
      </div>

      <!-- Right: Image -->
      <div class="hero__image" aria-hidden="true">
        <div class="hero__image-placeholder">
          <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
          </svg>
          <span>Photo Yesmine</span>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- =============================================
     TRUST BAR
     ============================================= -->
<section class="trust-bar" aria-label="Présence sur les réseaux sociaux">
  <div class="container">
    <div class="trust-bar__inner">
      <div class="trust-bar__item">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.27 6.27 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.73a4.85 4.85 0 01-1.01-.04z"/></svg>
        TikTok — @yesminegharbi
      </div>
      <div class="trust-bar__item">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
        Instagram — @yesminegharbi
      </div>
      <div class="trust-bar__item">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
        LinkedIn — Yesmine Gharbi
      </div>
      <div class="trust-bar__item">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
        Facebook — Yesmine Gharbi
      </div>
    </div>
  </div>
</section>

<!-- =============================================
     FORMATIONS APERÇU
     ============================================= -->
<section class="section" aria-labelledby="formations-heading">
  <div class="container">
    <div class="section__header">
      <span class="section__tag">Formations</span>
      <h2 class="section__title" id="formations-heading">Maîtrisez le recrutement, de A à Z</h2>
      <p class="section__subtitle">Des formations vidéo courtes et actionnables, conçues à partir de cas réels.</p>
    </div>

    <div class="card-grid">

      <!-- Formation 1 -->
      <article class="card">
        <div class="card__cover-placeholder" aria-label="Couverture formation CV">
          <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
          </svg>
        </div>
        <div class="card__body">
          <div class="card__meta">
            <span class="badge badge--bientot">Bientôt disponible</span>
            <span class="badge badge--nouveau">Junior</span>
          </div>
          <h3 class="card__title">CV &amp; LinkedIn Optimisés</h3>
          <p class="card__desc">Créez un CV qui passe les filtres ATS et un profil LinkedIn qui attire les recruteurs.</p>
          <div class="card__info">
            <span class="card__info-item">
              <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/></svg>
              5 modules
            </span>
            <span class="card__info-item">
              <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
              3h de contenu
            </span>
          </div>
          <div class="card__footer">
            <div>
              <div class="card__price">49 TND</div>
            </div>
            <a href="/formations.php" class="btn btn--primary btn--sm">Voir la formation</a>
          </div>
        </div>
      </article>

      <!-- Formation 2 -->
      <article class="card">
        <div class="card__cover-placeholder" aria-label="Couverture formation entretien">
          <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
          </svg>
        </div>
        <div class="card__body">
          <div class="card__meta">
            <span class="badge badge--bientot">Bientôt disponible</span>
            <span class="badge badge--nouveau">Tous niveaux</span>
          </div>
          <h3 class="card__title">Réussir ses Entretiens</h3>
          <p class="card__desc">Préparez chaque type d'entretien avec des techniques éprouvées et des réponses modèles.</p>
          <div class="card__info">
            <span class="card__info-item">
              <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/></svg>
              6 modules
            </span>
            <span class="card__info-item">
              <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
              4h de contenu
            </span>
          </div>
          <div class="card__footer">
            <div>
              <div class="card__price">59 TND</div>
            </div>
            <a href="/formations.php" class="btn btn--primary btn--sm">Voir la formation</a>
          </div>
        </div>
      </article>

      <!-- Formation 3 -->
      <article class="card">
        <div class="card__cover-placeholder" aria-label="Couverture formation recrutement">
          <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
          </svg>
        </div>
        <div class="card__body">
          <div class="card__meta">
            <span class="badge badge--bientot">Bientôt disponible</span>
            <span class="badge badge--nouveau">Recruteurs</span>
          </div>
          <h3 class="card__title">Recrutement Efficace</h3>
          <p class="card__desc">Optimisez vos processus de recrutement et trouvez les meilleurs talents plus rapidement.</p>
          <div class="card__info">
            <span class="card__info-item">
              <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/></svg>
              7 modules
            </span>
            <span class="card__info-item">
              <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg>
              5h de contenu
            </span>
          </div>
          <div class="card__footer">
            <div>
              <div class="card__price">79 TND</div>
            </div>
            <a href="/formations.php" class="btn btn--primary btn--sm">Voir la formation</a>
          </div>
        </div>
      </article>

    </div>

    <div class="section-cta">
      <a href="/formations.php" class="btn btn--outline">Voir toutes les formations →</a>
    </div>
  </div>
</section>

<!-- =============================================
     RESSOURCES GRATUITES HIGHLIGHT
     ============================================= -->
<section class="section section--beige" aria-labelledby="freeres-heading">
  <div class="container">
    <div class="section__header">
      <span class="section__tag">Gratuit</span>
      <h2 class="section__title" id="freeres-heading">Des ressources gratuites à forte valeur</h2>
      <p class="section__subtitle">Téléchargez gratuitement nos guides et templates — aucun paiement requis, juste votre email.</p>
    </div>

    <div class="card-grid">

      <article class="resource-card">
        <div class="resource-card__icon" aria-hidden="true">
          <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <span class="badge badge--gratuit">Gratuit</span>
        <h3 class="resource-card__title">Guide des Salaires en Tunisie 2026</h3>
        <p class="resource-card__desc">Grille complète par secteur et niveau d'expérience pour négocier votre salaire en connaissance de cause.</p>
        <div class="resource-card__footer">
          <span class="text-xs text-muted">PDF · 12 pages</span>
          <button class="btn btn--primary btn--sm open-resource-modal" data-resource="guide-salaires" data-resource-name="Guide des Salaires 2026">
            Télécharger →
          </button>
        </div>
      </article>

      <article class="resource-card">
        <div class="resource-card__icon" aria-hidden="true">
          <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
        </div>
        <span class="badge badge--gratuit">Gratuit</span>
        <h3 class="resource-card__title">Checklist Entretien d'Embauche</h3>
        <p class="resource-card__desc">50 points clés à vérifier avant, pendant et après votre entretien pour maximiser vos chances.</p>
        <div class="resource-card__footer">
          <span class="text-xs text-muted">PDF · 4 pages</span>
          <button class="btn btn--primary btn--sm open-resource-modal" data-resource="checklist-entretien" data-resource-name="Checklist Entretien">
            Télécharger →
          </button>
        </div>
      </article>

      <article class="resource-card">
        <div class="resource-card__icon" aria-hidden="true">
          <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <span class="badge badge--gratuit">Gratuit</span>
        <h3 class="resource-card__title">Mini Guide LinkedIn Professionnel</h3>
        <p class="resource-card__desc">Optimisez votre profil LinkedIn en 30 minutes et attirez l'attention des recruteurs.</p>
        <div class="resource-card__footer">
          <span class="text-xs text-muted">PDF · 8 pages</span>
          <button class="btn btn--primary btn--sm open-resource-modal" data-resource="guide-linkedin" data-resource-name="Mini Guide LinkedIn">
            Télécharger →
          </button>
        </div>
      </article>

    </div>

    <div class="section-cta">
      <a href="/ressources-gratuites.php" class="btn btn--secondary">Voir toutes les ressources gratuites →</a>
    </div>
  </div>
</section>

<!-- =============================================
     RESSOURCES PREMIUM
     ============================================= -->
<section class="section" aria-labelledby="premium-heading">
  <div class="container">
    <div class="section__header">
      <span class="section__tag">Premium</span>
      <h2 class="section__title" id="premium-heading">Ressources premium — Passez au niveau supérieur</h2>
      <p class="section__subtitle">Guides approfondis, templates prêts à l'emploi et kits complets conçus par une experte du recrutement.</p>
    </div>

    <div class="card-grid card-grid--4">

      <article class="resource-card">
        <div class="resource-card__icon" aria-hidden="true">
          <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <span class="badge badge--premium">Premium</span>
        <h3 class="resource-card__title">Template CV ATS</h3>
        <p class="resource-card__desc">Template Word + PDF optimisé pour les systèmes ATS. Compatible tous secteurs.</p>
        <div class="resource-card__footer">
          <span class="card__price" style="font-size:18px">19 TND</span>
          <a href="/ressources-premium.php" class="btn btn--primary btn--sm">Acheter</a>
        </div>
      </article>

      <article class="resource-card">
        <div class="resource-card__icon" aria-hidden="true">
          <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        </div>
        <span class="badge badge--premium">Premium</span>
        <h3 class="resource-card__title">Guide Entretien Complet</h3>
        <p class="resource-card__desc">60 questions fréquentes avec exemples de réponses structurées méthode STAR.</p>
        <div class="resource-card__footer">
          <span class="card__price" style="font-size:18px">29 TND</span>
          <a href="/ressources-premium.php" class="btn btn--primary btn--sm">Acheter</a>
        </div>
      </article>

      <article class="resource-card">
        <div class="resource-card__icon" aria-hidden="true">
          <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        </div>
        <span class="badge badge--populaire">Populaire</span>
        <h3 class="resource-card__title">Kit Candidat Complet</h3>
        <p class="resource-card__desc">CV + lettre de motivation + guide entretien + checklist. Tout pour réussir.</p>
        <div class="resource-card__footer">
          <span class="card__price" style="font-size:18px">49 TND</span>
          <a href="/ressources-premium.php" class="btn btn--primary btn--sm">Acheter</a>
        </div>
      </article>

      <article class="resource-card">
        <div class="resource-card__icon" aria-hidden="true">
          <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <span class="badge badge--nouveau">Nouveau</span>
        <h3 class="resource-card__title">Kit Recruteur Pro</h3>
        <p class="resource-card__desc">Scripts d'entretien, grilles d'évaluation et templates de fiches de poste.</p>
        <div class="resource-card__footer">
          <span class="card__price" style="font-size:18px">59 TND</span>
          <a href="/ressources-premium.php" class="btn btn--primary btn--sm">Acheter</a>
        </div>
      </article>

    </div>

    <div class="section-cta">
      <a href="/ressources-premium.php" class="btn btn--outline">Voir toutes les ressources premium →</a>
    </div>
  </div>
</section>

<!-- =============================================
     ENTREPRISES B2B
     ============================================= -->
<section class="section section--beige" aria-labelledby="b2b-heading">
  <div class="container">
    <div class="b2b-section">
      <!-- Left -->
      <div>
        <span class="section__tag" style="color:#F5A623">Entreprises &amp; B2B</span>
        <h2 class="b2b-section__title" id="b2b-heading">Renforcez votre marque employeur</h2>
        <p class="b2b-section__desc">Formations RH sur mesure, conseil marque employeur et promotion auprès d'une audience qualifiée.</p>
        <div style="display:flex;gap:12px;flex-wrap:wrap">
          <a href="/entreprises.php" class="btn btn--primary">Découvrir les offres →</a>
          <a href="/contact.php?sujet=entreprise" class="btn" style="background:rgba(255,255,255,0.12);color:#fff;border-radius:8px;padding:12px 24px;font-size:14px;font-weight:700">Nous contacter</a>
        </div>
      </div>
      <!-- Right -->
      <div class="b2b-features">
        <div class="b2b-feature">
          <div class="b2b-feature__icon" aria-hidden="true">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
          </div>
          <div>
            <div class="b2b-feature__title">Marque Employeur</div>
            <div class="b2b-feature__desc">Stratégie et contenus pour attirer les meilleurs talents</div>
          </div>
        </div>
        <div class="b2b-feature">
          <div class="b2b-feature__icon" aria-hidden="true">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
          </div>
          <div>
            <div class="b2b-feature__title">Formations RH</div>
            <div class="b2b-feature__desc">Sessions de formation pour vos équipes recrutement</div>
          </div>
        </div>
        <div class="b2b-feature">
          <div class="b2b-feature__icon" aria-hidden="true">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
          </div>
          <div>
            <div class="b2b-feature__title">Promotion Audience</div>
            <div class="b2b-feature__desc">Visibilité auprès de +200K candidats et professionnels RH</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- =============================================
     À PROPOS MINI
     ============================================= -->
<section class="section" aria-labelledby="about-heading">
  <div class="container">
    <div class="about-mini">
      <!-- Image -->
      <div>
        <div class="about-mini__image-placeholder" aria-label="Photo de Yesmine Gharbi">
          <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
          </svg>
        </div>
      </div>
      <!-- Content -->
      <div>
        <span class="section__tag">À propos</span>
        <h2 class="about-mini__title" id="about-heading">Yesmine Gharbi</h2>
        <p class="about-mini__bio">
          Spécialiste en recrutement avec plusieurs années d'expérience terrain, je partage des conseils
          concrets et actionnables pour aider candidats et recruteurs à atteindre leurs objectifs.
          Mon contenu est basé sur la réalité du marché tunisien — pas sur des théories importées.
        </p>
        <div class="social-links" role="list">
          <a href="https://www.tiktok.com/@yesminegharbi" class="social-link" target="_blank" rel="noopener noreferrer" role="listitem">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.27 6.27 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.73a4.85 4.85 0 01-1.01-.04z"/></svg>
            TikTok
          </a>
          <a href="https://www.instagram.com/yesminegharbi" class="social-link" target="_blank" rel="noopener noreferrer" role="listitem">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
            Instagram
          </a>
          <a href="https://www.linkedin.com/in/yesminegharbi" class="social-link" target="_blank" rel="noopener noreferrer" role="listitem">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
            LinkedIn
          </a>
        </div>
        <a href="/a-propos.php" class="btn btn--secondary">En savoir plus sur moi →</a>
      </div>
    </div>
  </div>
</section>

<!-- =============================================
     TÉMOIGNAGES
     ============================================= -->
<section class="section section--beige" aria-labelledby="temoignages-heading">
  <div class="container">
    <div class="section__header">
      <span class="section__tag">Témoignages</span>
      <h2 class="section__title" id="temoignages-heading">Ce qu'ils disent de mes ressources</h2>
      <p class="section__subtitle">Des retours concrets de personnes qui ont appliqué mes conseils.</p>
    </div>

    <div class="testimonials-grid">

      <article class="testimonial-card">
        <div class="stars" aria-label="5 étoiles">★★★★★</div>
        <p class="testimonial-card__quote">
          "Grâce au guide de Yesmine, j'ai décroché 3 entretiens en une semaine après avoir optimisé mon CV.
          Les conseils sont vraiment concrets et adaptés au marché tunisien."
        </p>
        <div class="testimonial-card__author">
          <div class="testimonial-card__avatar" aria-hidden="true">A</div>
          <div>
            <div class="testimonial-card__name">Amal B.</div>
            <div class="testimonial-card__role">Ingénieure, Tunis</div>
          </div>
        </div>
      </article>

      <article class="testimonial-card">
        <div class="stars" aria-label="5 étoiles">★★★★★</div>
        <p class="testimonial-card__quote">
          "La checklist entretien m'a sauvé ! J'ai préparé chaque point avant mon entretien et j'ai eu le poste.
          Simple, clair et efficace."
        </p>
        <div class="testimonial-card__author">
          <div class="testimonial-card__avatar" aria-hidden="true">K</div>
          <div>
            <div class="testimonial-card__name">Karim M.</div>
            <div class="testimonial-card__role">Manager RH</div>
          </div>
        </div>
      </article>

      <article class="testimonial-card">
        <div class="stars" aria-label="5 étoiles">★★★★★</div>
        <p class="testimonial-card__quote">
          "Je suis recruteur et le kit recruteur pro a complètement transformé mes entretiens.
          Mes grilles d'évaluation sont maintenant beaucoup plus objectives."
        </p>
        <div class="testimonial-card__author">
          <div class="testimonial-card__avatar" aria-hidden="true">S</div>
          <div>
            <div class="testimonial-card__name">Sarra T.</div>
            <div class="testimonial-card__role">DRH, Sfax</div>
          </div>
        </div>
      </article>

    </div>
  </div>
</section>

<!-- =============================================
     CTA FINAL — NEWSLETTER
     ============================================= -->
<section class="section" aria-labelledby="newsletter-heading">
  <div class="container">
    <div class="email-capture">
      <h2 class="email-capture__title" id="newsletter-heading">Restez informé·e — gratuitement</h2>
      <p class="email-capture__subtitle">Recevez chaque semaine mes meilleurs conseils recrutement directement dans votre boîte mail.</p>
      <form class="email-capture__form" id="heroNewsletterForm" action="/api/newsletter.php" method="POST" novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
        <input type="email" name="email" class="email-capture__input" placeholder="votre@email.com" required aria-label="Votre adresse email">
        <button type="submit" class="btn btn--secondary">S'abonner →</button>
      </form>
    </div>
  </div>
</section>

<!-- =============================================
     RESOURCE DOWNLOAD MODAL
     ============================================= -->
<div class="modal-overlay" id="resourceModal" role="dialog" aria-modal="true" aria-labelledby="resourceModalTitle">
  <div class="modal">
    <button class="modal__close" id="closeResourceModal" aria-label="Fermer">
      <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
      </svg>
    </button>
    <div class="modal__icon" aria-hidden="true">
      <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
      </svg>
    </div>
    <h3 class="modal__title" id="resourceModalTitle">Télécharger la ressource</h3>
    <p class="modal__subtitle" id="resourceModalSubtitle">Entrez vos coordonnées pour recevoir le lien de téléchargement.</p>
    <form id="resourceDownloadForm" action="/api/resource-download.php" method="POST" novalidate>
      <input type="hidden" name="resource_id" id="resourceIdInput">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
      <div class="form-group">
        <label class="form-label" for="res_prenom">Prénom <span style="color:var(--color-accent)">*</span></label>
        <input type="text" id="res_prenom" name="prenom" class="form-input" placeholder="Votre prénom" required>
      </div>
      <div class="form-group">
        <label class="form-label" for="res_email">Email <span style="color:var(--color-accent)">*</span></label>
        <input type="email" id="res_email" name="email" class="form-input" placeholder="votre@email.com" required>
      </div>
      <div id="resourceFormMessage"></div>
      <button type="submit" class="btn btn--primary btn--full">Recevoir le lien →</button>
      <p class="text-xs text-muted text-center mt-md">Pas de spam. Désinscription possible à tout moment.</p>
    </form>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>
