<?php
$iconeRessource = [
    'checklist' => '📋',
    'template'  => '📝',
    'ebook'     => '💡',
    'guide'     => '📊',
    'kit'       => '🎯',
];
?>

<div class="page-header">
  <div class="page-header-inner">
    <span class="section-tag" style="color:var(--sauge)">100% Gratuit</span>
    <h1>Ressources gratuites</h1>
    <p>Téléchargez gratuitement nos guides, templates et checklists. Aucun paiement requis, juste votre email.</p>
  </div>
</div>

<section>
  <?php if (empty($ressources)): ?>
  <p style="text-align:center;color:var(--gris);padding:60px 0">Aucune ressource gratuite disponible pour le moment.</p>
  <?php else: ?>
  <div class="ressources-full-grid">
    <?php foreach ($ressources as $r): ?>
    <div class="ressource-card-full">
      <div class="ri-icon" style="width:52px;height:52px;font-size:24px;border-radius:12px;background:var(--sauge-light);display:flex;align-items:center;justify-content:center;margin-bottom:14px">
        <?= $iconeRessource[$r['type']] ?? '📄' ?>
      </div>
      <span class="ri-badge badge-free" style="margin-bottom:10px;display:inline-block">Gratuit</span>
      <h3 style="font-family:'Playfair Display',serif;font-size:18px;margin-bottom:8px"><?= esc($r['titre']) ?></h3>
      <p style="font-size:14px;color:var(--gris);line-height:1.6;margin-bottom:16px;flex:1"><?= esc($r['description_courte']) ?></p>
      <div style="display:flex;align-items:center;justify-content:space-between;padding-top:14px;border-top:1px solid var(--beige-dark)">
        <span style="font-size:12px;color:var(--gris)"><?= strtoupper(esc($r['type'])) ?></span>
        <button class="btn-primary open-download"
                data-id="<?= (int)$r['id'] ?>"
                data-titre="<?= esc($r['titre']) ?>">
          Télécharger →
        </button>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</section>

<!-- CTA vers Premium -->
<div class="cta-final" style="background:var(--beige)">
  <span class="section-tag">Vous en voulez plus ?</span>
  <h2>Passez aux ressources premium</h2>
  <p>Guides approfondis, templates professionnels et kits complets à des prix adaptés.</p>
  <a href="<?= site_url('ressources-premium') ?>" class="btn-primary" style="display:inline-flex;margin:0 auto">Voir les ressources premium →</a>
</div>
