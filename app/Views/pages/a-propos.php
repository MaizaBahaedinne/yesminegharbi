<div class="page-header" style="background:var(--noir);color:white">
  <div class="page-header-inner">
    <span class="section-tag" style="color:var(--sauge)">À propos</span>
    <h1 style="color:white">Yesmine Gharbi</h1>
    <p style="color:rgba(255,255,255,0.7)">Spécialiste Recrutement &amp; Créatrice de contenu RH</p>
  </div>
</div>

<section>
  <div class="apropos-mini" style="max-width:960px;margin:0 auto 80px">
    <div class="apropos-photo">👩‍💼</div>
    <div class="apropos-content">
      <h2>Bonjour, je suis Yesmine</h2>
      <span class="apropos-title">Spécialiste Recrutement &amp; Personal Branding</span>
      <p>Après plusieurs années en cabinet de recrutement et en entreprise, j'ai décidé de partager ce que j'ai appris sur le terrain — pas dans les manuels.</p>
      <p>Mon objectif : rendre les ressources RH accessibles, pratiques et vraiment utiles, que vous soyez candidat, recruteur ou entreprise.</p>
      <div class="social-links">
        <a href="https://tiktok.com/@yesminegharbi"    class="social-link" target="_blank" rel="noopener">📱 TikTok</a>
        <a href="https://instagram.com/yesminegharbi"  class="social-link" target="_blank" rel="noopener">📸 Instagram</a>
        <a href="https://linkedin.com/in/yesminegharbi" class="social-link" target="_blank" rel="noopener">💼 LinkedIn</a>
        <a href="https://facebook.com/yesminegharbi"   class="social-link" target="_blank" rel="noopener">👥 Facebook</a>
      </div>
    </div>
  </div>
</section>

<!-- Stats -->
<section class="section-alt">
  <div class="section-header">
    <span class="section-tag">En chiffres</span>
    <h2>Ce que j'ai accompli</h2>
  </div>
  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:24px;max-width:900px;margin:0 auto">
    <?php
    $stats = [
        ['num' => '+50K',  'label' => 'Abonnés réseaux'],
        ['num' => '+200',  'label' => 'Contenus publiés'],
        ['num' => '3 ans', 'label' => "d'expérience terrain"],
        ['num' => '+10',   'label' => 'Ressources créées'],
    ];
    foreach ($stats as $s): ?>
    <div style="text-align:center;padding:32px 20px;background:white;border-radius:16px;border:1px solid var(--beige-dark)">
      <span style="display:block;font-family:'Playfair Display',serif;font-size:36px;font-weight:700;color:var(--rouge)"><?= $s['num'] ?></span>
      <span style="font-size:13px;color:var(--gris)"><?= $s['label'] ?></span>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- Ma philosophie -->
<section>
  <div style="max-width:760px;margin:0 auto;text-align:center">
    <span class="section-tag">Ma philosophie</span>
    <h2>Pourquoi « Du terrain, pas des manuels » ?</h2>
    <p style="font-size:17px;color:var(--gris);line-height:1.8;margin-bottom:32px">
      Parce que la réalité du marché de l'emploi n'est pas dans les livres. Elle est dans les centaines d'entretiens que j'ai conduits, les CV que j'ai triés, les candidats que j'ai accompagnés. C'est cette expérience que je partage — concrète, actuelle, adaptée au marché tunisien.
    </p>
    <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap">
      <a href="<?= site_url('formations') ?>" class="btn-primary">Voir les formations →</a>
      <a href="<?= site_url('contact') ?>" class="btn-secondary">Me contacter</a>
    </div>
  </div>
</section>
