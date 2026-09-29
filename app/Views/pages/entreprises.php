<div class="page-header" style="background:var(--noir);color:white">
  <div class="page-header-inner">
    <span class="section-tag" style="color:var(--sauge)">B2B</span>
    <h1 style="color:white">Pour les Entreprises</h1>
    <p style="color:rgba(255,255,255,0.7)">Marque employeur · Formations RH · Promotion d'audience</p>
  </div>
</div>

<!-- B2B FULL -->
<section class="b2b-section" style="padding:80px 8%">
  <div class="b2b-inner">
    <div class="b2b-left">
      <span class="section-tag" style="color:var(--sauge)">Pour les entreprises</span>
      <h2>Développez votre<br>marque employeur</h2>

      <div class="b2b-services">
        <div class="b2b-service">
          <div class="b2b-service-icon rouge"><i class="fa-solid fa-bullhorn" aria-hidden="true"></i></div>
          <div>
            <h4>Promotion de votre entreprise</h4>
            <p>Mettez en avant votre activité, vos métiers, votre culture et votre environnement de travail à travers du contenu pensé pour valoriser votre entreprise auprès des talents.</p>
          </div>
        </div>
        <div class="b2b-service">
          <div class="b2b-service-icon sauge"><i class="fa-solid fa-chess-knight" aria-hidden="true"></i></div>
          <div>
            <h4>Stratégies sur mesure</h4>
            <p>Bénéficiez de recommandations et de stratégies adaptées à vos objectifs de marque employeur, de communication et d’attractivité, à mettre ensuite en œuvre par vos équipes.</p>
          </div>
        </div>
      </div>

      <h3 style="color:white;font-family:'Playfair Display',serif;font-size:26px;margin:40px 0 20px">Recrutez mieux &amp; optimisez vos pratiques</h3>

      <div class="b2b-services">
        <div class="b2b-service">
          <div class="b2b-service-icon or"><i class="fa-solid fa-graduation-cap" aria-hidden="true"></i></div>
          <div>
            <h4>Développez les compétences de vos équipes</h4>
            <p>Accédez à mes formations et ressources premium pour aider vos équipes RH et recrutement à renforcer leurs pratiques, développer leurs compétences et recruter plus efficacement.</p>
          </div>
        </div>
        <div class="b2b-service">
          <div class="b2b-service-icon rouge"><i class="fa-solid fa-user-check" aria-hidden="true"></i></div>
          <div>
            <h4>Confiez-moi vos recrutements</h4>
            <p>Je peux intervenir directement dans votre recherche de talents : identification des profils, sourcing, présélection et accompagnement du processus de recrutement selon vos besoins.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="b2b-right">
      <div class="b2b-stat-card">
        <span class="big-num">+187K</span>
        <span>abonnés sur les réseaux</span>
      </div>
      <div class="b2b-stat-card">
        <span class="big-num">85%</span>
        <span>d'audience dans le domaine professionnel</span>
      </div>
      <div class="b2b-stat-card">
        <span class="big-num">+4 ans</span>
        <span>d'expérience terrain en recrutement</span>
      </div>
      <a href="<?= site_url('contact') ?>?sujet=collaboration-entreprise" class="b2b-cta">Discutons de votre projet →</a>
    </div>
  </div>
</section>

<!-- Processus -->
<section style="background:var(--beige)">
  <div class="section-header">
    <span class="section-tag">Comment ça marche</span>
    <h2>Notre processus de collaboration</h2>
  </div>
  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:24px;max-width:960px;margin:0 auto">
    <?php
    $steps = [
        ['num' => '01', 'titre' => 'Contact', 'desc' => 'Remplissez le formulaire de contact avec votre besoin.'],
        ['num' => '02', 'titre' => 'Échange', 'desc' => 'Appel découverte pour comprendre vos objectifs.'],
        ['num' => '03', 'titre' => 'Proposition', 'desc' => 'Je vous envoie une proposition sur-mesure.'],
        ['num' => '04', 'titre' => 'Réalisation', 'desc' => 'On travaille ensemble pour atteindre vos objectifs.'],
    ];
    foreach ($steps as $s): ?>
    <div style="background:white;border-radius:16px;padding:28px;border:1px solid var(--beige-dark);text-align:center">
      <div style="font-family:'Playfair Display',serif;font-size:40px;font-weight:700;color:var(--rouge);margin-bottom:12px"><?= $s['num'] ?></div>
      <h3 style="font-size:16px;font-weight:600;margin-bottom:8px"><?= $s['titre'] ?></h3>
      <p style="font-size:13px;color:var(--gris)"><?= $s['desc'] ?></p>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- CTA Contact -->
<div class="cta-final">
  <span class="section-tag">Passons à l'action</span>
  <h2>Prêt·e à collaborer ?</h2>
  <p>Une idée, une question ou une collaboration ? Parlons-en.</p>
  <a href="<?= site_url('contact') ?>?sujet=collaboration-entreprise" class="btn-primary" style="display:inline-flex">Me contacter →</a>
</div>
