<?php
use App\Models\CvModel;

$d = $cv['data'];
$p = $d['personal'];
$dir = $cv['langue'] === 'ar' ? 'rtl' : 'ltr';
$f = static fn (string $name, $value, string $label, string $type = 'text', string $ph = '', string $extra = ''): string =>
    '<div class="form-group"><label>' . esc($label) . '</label><input type="' . $type . '" name="' . $name . '" value="' . esc((string) $value) . '" class="form-input" placeholder="' . esc($ph) . '" ' . $extra . '></div>';

$expRow = static function ($i, array $e) use ($f): string {
    return '<div class="cv-row" style="border:1px solid var(--beige-dark);border-radius:12px;padding:1rem;margin-bottom:1rem;position:relative">'
        . '<button type="button" class="cv-remove" aria-label="Retirer" style="position:absolute;top:10px;inset-inline-end:10px;background:none;border:0;color:var(--rouge);cursor:pointer"><i class="fa-solid fa-xmark"></i></button>'
        . '<div class="cv-grid">'
        . $f("experiences[$i][title]", $e['title'] ?? '', 'Intitulé du poste *', 'text', 'Ex. Chargée de recrutement')
        . $f("experiences[$i][company]", $e['company'] ?? '', 'Entreprise *', 'text', 'Ex. Vermeg')
        . $f("experiences[$i][city]", $e['city'] ?? '', 'Ville', 'text', 'Ex. Tunis')
        . '<div class="cv-grid" style="grid-template-columns:1fr 1fr;gap:.75rem">'
        . $f("experiences[$i][start]", $e['start'] ?? '', 'Début *', 'month')
        . $f("experiences[$i][end]", $e['end'] ?? '', 'Fin', 'month')
        . '</div></div>'
        . '<label style="display:inline-flex;gap:.4rem;align-items:center;font-size:13px;margin:.25rem 0 .75rem;cursor:pointer"><input type="checkbox" name="experiences[' . $i . '][current]" value="1" ' . (! empty($e['current']) ? 'checked' : '') . '> Poste actuel</label>'
        . '<div class="form-group"><label>Réalisations (une par ligne, commencez par un verbe d’action, chiffrez)</label>'
        . '<textarea name="experiences[' . $i . '][bullets]" class="form-input" rows="4" placeholder="Recruté 25 profils IT en 6 mois&#10;Réduit le délai de recrutement de 30 %">' . esc(implode("\n", $e['bullets'] ?? [])) . '</textarea></div>'
        . '</div>';
};

$eduRow = static function ($i, array $e) use ($f): string {
    return '<div class="cv-row" style="border:1px solid var(--beige-dark);border-radius:12px;padding:1rem;margin-bottom:1rem;position:relative">'
        . '<button type="button" class="cv-remove" aria-label="Retirer" style="position:absolute;top:10px;inset-inline-end:10px;background:none;border:0;color:var(--rouge);cursor:pointer"><i class="fa-solid fa-xmark"></i></button>'
        . '<div class="cv-grid">'
        . $f("education[$i][degree]", $e['degree'] ?? '', 'Diplôme *', 'text', 'Ex. Master en GRH')
        . $f("education[$i][school]", $e['school'] ?? '', 'Établissement *', 'text', 'Ex. ISG Tunis')
        . $f("education[$i][city]", $e['city'] ?? '', 'Ville')
        . '<div class="cv-grid" style="grid-template-columns:1fr 1fr;gap:.75rem">'
        . $f("education[$i][start]", $e['start'] ?? '', 'Début', 'month')
        . $f("education[$i][end]", $e['end'] ?? '', 'Fin', 'month')
        . '</div></div>'
        . $f("education[$i][details]", $e['details'] ?? '', 'Détails (mention, projet, spécialité)')
        . '</div>';
};

$langRow = static fn ($i, array $l): string => '<div class="cv-row cv-grid" style="grid-template-columns:1fr 1fr auto;align-items:end;margin-bottom:.5rem">'
    . $f("languages[$i][name]", $l['name'] ?? '', 'Langue', 'text', 'Ex. Anglais')
    . $f("languages[$i][level]", $l['level'] ?? '', 'Niveau', 'text', 'Ex. Courant (C1)')
    . '<button type="button" class="cv-remove" aria-label="Retirer" style="background:none;border:0;color:var(--rouge);cursor:pointer;padding-bottom:12px"><i class="fa-solid fa-xmark"></i></button></div>';

$certRow = static fn ($i, array $c): string => '<div class="cv-row cv-grid" style="grid-template-columns:2fr 2fr 1fr auto;align-items:end;margin-bottom:.5rem">'
    . $f("certifications[$i][name]", $c['name'] ?? '', 'Certification', 'text', 'Ex. SHRM-CP')
    . $f("certifications[$i][org]", $c['org'] ?? '', 'Organisme')
    . $f("certifications[$i][year]", $c['year'] ?? '', 'Année', 'text', '2025', 'maxlength="4"')
    . '<button type="button" class="cv-remove" aria-label="Retirer" style="background:none;border:0;color:var(--rouge);cursor:pointer;padding-bottom:12px"><i class="fa-solid fa-xmark"></i></button></div>';

$card = 'background:#fff;border-radius:16px;padding:1.5rem;box-shadow:0 4px 16px rgba(0,0,0,.05);margin-bottom:1.5rem';
$hint = 'font-size:13px;color:var(--gris);margin:-.25rem 0 1rem';
?>
<style>
  .cv-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
  @media (max-width:700px){.cv-grid{grid-template-columns:1fr !important}}
  .cv-editor h2{font-family:'Playfair Display',serif;font-size:1.25rem;margin-bottom:.5rem}
</style>

<section class="page-header" style="background:var(--noir)">
  <div class="page-header-inner">
    <a href="<?= site_url('mon-compte/cv') ?>" style="color:rgba(255,255,255,.7);font-size:14px">← Mes CV</a>
    <h1 style="color:#fff;margin-top:8px"><?= esc($cv['titre']) ?></h1>
    <p style="color:rgba(255,255,255,.7)">Structure ATS · <?= esc(CvModel::LANGUES[$cv['langue']] ?? '') ?> · une seule colonne, pas de photo, pas de tableau : c’est ce que les ATS lisent le mieux.</p>
  </div>
</section>

<section style="background:var(--beige)">
  <form action="<?= site_url('mon-compte/cv/' . $cv['id']) ?>" method="post" class="cv-editor" dir="<?= $dir ?>" style="max-width:900px;margin:0 auto">
    <?= csrf_field() ?>

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success" style="margin-bottom:1rem"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>

    <div style="<?= $card ?>">
      <?= $f('titre', $cv['titre'], 'Nom du CV (visible uniquement par vous)', 'text', '', 'maxlength="120"') ?>
    </div>

    <div style="<?= $card ?>">
      <h2>1. Coordonnées</h2>
      <p style="<?= $hint ?>">En texte simple, en haut du CV. Pas d’icônes ni de photo.</p>
      <div class="cv-grid">
        <?= $f('personal[full_name]', $p['full_name'], 'Nom complet *') ?>
        <?= $f('personal[headline]', $p['headline'], 'Titre du poste visé *', 'text', 'Ex. Chargée de recrutement IT') ?>
        <?= $f('personal[email]', $p['email'], 'E-mail *', 'email') ?>
        <?= $f('personal[phone]', $p['phone'], 'Téléphone *', 'tel', '+216 ...') ?>
        <?= $f('personal[city]', $p['city'], 'Ville, pays', 'text', 'Tunis, Tunisie') ?>
        <?= $f('personal[linkedin]', $p['linkedin'], 'LinkedIn', 'text', 'linkedin.com/in/...') ?>
        <?= $f('personal[website]', $p['website'], 'Site / portfolio') ?>
      </div>
    </div>

    <div style="<?= $card ?>">
      <h2>2. Profil</h2>
      <p style="<?= $hint ?>">3 à 5 lignes : qui vous êtes, vos années d’expérience, vos points forts et le poste visé. Reprenez les mots-clés de vos offres cibles.</p>
      <textarea name="summary" class="form-input" rows="5" maxlength="1500"><?= esc($d['summary']) ?></textarea>
    </div>

    <div style="<?= $card ?>">
      <h2>3. Expérience professionnelle</h2>
      <p style="<?= $hint ?>">De la plus récente à la plus ancienne. Dates au format mois/année.</p>
      <div class="cv-list" data-template="tpl-exp">
        <?php foreach ($d['experiences'] as $i => $e) { echo $expRow($i, $e); } ?>
      </div>
      <button type="button" class="btn-secondary cv-add" data-target="tpl-exp">+ Ajouter une expérience</button>
    </div>

    <div style="<?= $card ?>">
      <h2>4. Formation</h2>
      <div class="cv-list" data-template="tpl-edu">
        <?php foreach ($d['education'] as $i => $e) { echo $eduRow($i, $e); } ?>
      </div>
      <button type="button" class="btn-secondary cv-add" data-target="tpl-edu">+ Ajouter une formation</button>
    </div>

    <div style="<?= $card ?>">
      <h2>5. Compétences</h2>
      <p style="<?= $hint ?>">Séparées par des virgules. Privilégiez les compétences techniques et outils cités dans les offres (ex. Sourcing, Entretien structuré, Excel, SAP SuccessFactors).</p>
      <textarea name="skills" class="form-input" rows="3"><?= esc(implode(', ', $d['skills'])) ?></textarea>
    </div>

    <div style="<?= $card ?>">
      <h2>6. Langues</h2>
      <div class="cv-list" data-template="tpl-lang">
        <?php foreach ($d['languages'] as $i => $l) { echo $langRow($i, $l); } ?>
      </div>
      <button type="button" class="btn-secondary cv-add" data-target="tpl-lang">+ Ajouter une langue</button>
    </div>

    <div style="<?= $card ?>">
      <h2>7. Certifications <span style="font-weight:400;font-size:14px;color:var(--gris)">(facultatif)</span></h2>
      <div class="cv-list" data-template="tpl-cert">
        <?php foreach ($d['certifications'] as $i => $c) { echo $certRow($i, $c); } ?>
      </div>
      <button type="button" class="btn-secondary cv-add" data-target="tpl-cert">+ Ajouter une certification</button>
    </div>

    <div style="position:sticky;bottom:0;background:var(--beige);padding:1rem 0;display:flex;flex-wrap:wrap;gap:.75rem;justify-content:flex-end;border-top:1px solid var(--beige-dark)">
      <button type="submit" name="next" value="stay" class="btn-secondary">Enregistrer</button>
      <button type="submit" name="next" value="preview" class="btn-secondary">Enregistrer et prévisualiser</button>
      <button type="submit" name="next" value="ats" class="btn-primary">Enregistrer et tester (ATS) →</button>
    </div>
  </form>
</section>

<template id="tpl-exp"><?= $expRow('__i__', []) ?></template>
<template id="tpl-edu"><?= $eduRow('__i__', []) ?></template>
<template id="tpl-lang"><?= $langRow('__i__', []) ?></template>
<template id="tpl-cert"><?= $certRow('__i__', []) ?></template>

<script>
(function () {
  let counter = Date.now();
  document.querySelectorAll('.cv-add').forEach(function (btn) {
    btn.addEventListener('click', function () {
      const tpl = document.getElementById(btn.dataset.target);
      const list = document.querySelector('.cv-list[data-template="' + btn.dataset.target + '"]');
      const wrap = document.createElement('div');
      wrap.innerHTML = tpl.innerHTML.replace(/__i__/g, String(counter++));
      const row = wrap.firstElementChild;
      list.appendChild(row);
      const first = row.querySelector('input,textarea');
      if (first) first.focus();
    });
  });
  document.addEventListener('click', function (e) {
    const btn = e.target.closest('.cv-remove');
    if (btn) btn.closest('.cv-row').remove();
  });
  document.querySelectorAll('.cv-list').forEach(function (list) {
    if (!list.children.length) document.querySelector('.cv-add[data-target="' + list.dataset.template + '"]').click();
  });
  window.scrollTo(0, 0);
})();
</script>
