<div class="page-header" style="background:var(--noir);color:white">
  <div class="page-header-inner">
    <span class="section-tag" style="color:var(--sauge)">À propos</span>
    <h1 style="color:white">Yesmine Gharbi</h1>
    <p style="color:rgba(255,255,255,0.7)">Spécialiste Recrutement &amp; Créatrice de contenu RH</p>
  </div>
</div>

<section>
  <div class="apropos-mini" style="max-width:960px;margin:0 auto 80px">
    <div class="apropos-photo">
      <img src="<?= base_url('assets/img/yesmine.jpg') ?>" alt="Yesmine Gharbi" style="width:100%;height:100%;object-fit:cover">
    </div>
    <div class="apropos-content">
      <h2>Bonjour, je suis Yesmine</h2>
      <span class="apropos-title">Spécialiste Recrutement &amp; Personal Branding</span>
      <p>Après plusieurs années en cabinet de recrutement et en entreprise, j'ai décidé de partager ce que j'ai appris sur le terrain — pas dans les manuels.</p>
      <p>Mon objectif : rendre les ressources RH accessibles, pratiques et vraiment utiles, que vous soyez candidat, recruteur ou entreprise.</p>
      <div class="social-links">
        <?php
        $socialSvg = [
            'tiktok'    => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.18 8.18 0 0 0 4.78 1.52V6.76a4.85 4.85 0 0 1-1.01-.07z"/></svg>',
            'instagram' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>',
            'linkedin'  => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
            'facebook'  => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
        ];
        $nets = [
            ['key'=>'tiktok',    'label'=>'TikTok'],
            ['key'=>'instagram', 'label'=>'Instagram'],
            ['key'=>'linkedin',  'label'=>'LinkedIn'],
            ['key'=>'facebook',  'label'=>'Facebook'],
        ];
        foreach ($nets as $n):
            $url   = $settings[$n['key'].'_url'] ?? '#';
            $count = $settings[$n['key'].'_followers'] ?? '';
        ?>
        <a href="<?= esc($url) ?>" class="social-link" target="_blank" rel="noopener">
          <?= $socialSvg[$n['key']] ?> <?= $n['label'] ?><?= $count ? ' <strong style="font-weight:700;color:var(--noir)">'.$count.'</strong>' : '' ?>
        </a>
        <?php endforeach; ?>
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
