<div class="page-header">
  <div class="page-header-inner">
    <span class="section-tag">Outil gratuit</span>
    <h1>Créez un CV lisible par les ATS, <em>puis testez-le</em></h1>
    <p>Une structure validée par le terrain, pré-remplie étape par étape. Collez ensuite une offre d’emploi : vous obtenez un score de compatibilité et les mots-clés à ajouter.</p>
    <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:24px">
      <a href="<?= site_url(!empty($isLoggedIn) ? 'mon-compte/cv' : 'connexion') ?>" class="btn-primary">
        <?= !empty($isLoggedIn) ? 'Accéder à mes CV →' : 'Créer mon CV gratuitement →' ?>
      </a>
    </div>
  </div>
</div>

<section>
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:24px;max-width:1000px;margin:0 auto">
    <?php
    $steps = [
        ['icon' => 'fa-pen-to-square', 'titre' => '1. Remplissez la structure ATS', 'desc' => 'Coordonnées, profil, expériences, formation, compétences : un format simple, sans colonnes ni images, que les logiciels de recrutement lisent sans erreur.'],
        ['icon' => 'fa-bullseye', 'titre' => '2. Collez une offre d’emploi', 'desc' => 'Copiez le texte de l’annonce qui vous intéresse et l’intitulé du poste.'],
        ['icon' => 'fa-chart-column', 'titre' => '3. Obtenez votre score', 'desc' => 'Score sur 100, mots-clés trouvés et manquants, conseils concrets pour améliorer votre CV.'],
        ['icon' => 'fa-file-arrow-down', 'titre' => '4. Téléchargez', 'desc' => 'Exportez votre CV en PDF ou en Word, en français, en anglais ou en arabe.'],
    ];
    foreach ($steps as $s): ?>
    <div style="background:white;border:1px solid var(--beige-dark);border-radius:16px;padding:28px">
      <div style="width:48px;height:48px;border-radius:12px;background:var(--rouge-light);color:var(--rouge);display:flex;align-items:center;justify-content:center;font-size:20px;margin-bottom:16px">
        <i class="fa-solid <?= $s['icon'] ?>" aria-hidden="true"></i>
      </div>
      <h3 style="font-size:17px;margin-bottom:8px"><?= esc($s['titre']) ?></h3>
      <p style="font-size:14px;color:var(--gris);line-height:1.6;margin:0"><?= esc($s['desc']) ?></p>
    </div>
    <?php endforeach; ?>
  </div>

  <p style="text-align:center;color:var(--gris);font-size:13px;margin-top:32px">
    Gratuit : jusqu’à 3 CV et 3 tests ATS par jour. Le score est une estimation : chaque logiciel ATS a ses propres règles.
  </p>
</section>
