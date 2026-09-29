<?php
use App\Models\CvModel;

$d = $cv['data'];
$p = $d['personal'];
$lang = $cv['langue'];
$L = CvModel::LABELS[$lang] ?? CvModel::LABELS['fr'];
$contact = array_filter([$p['email'], $p['phone'], $p['city'], $p['linkedin'], $p['website']]);
?>
<!DOCTYPE html>
<html lang="<?= esc($lang) ?>" dir="<?= $lang === 'ar' ? 'rtl' : 'ltr' ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex">
  <title>CV — <?= esc($p['full_name'] ?: $cv['titre']) ?></title>
  <style>
    @page { size: A4; margin: 14mm 16mm; }
    * { box-sizing: border-box; }
    body { font-family: Arial, Helvetica, "Segoe UI", Tahoma, sans-serif; color: #111; font-size: 10.5pt; line-height: 1.4; margin: 0; background: #f2f2f2; }
    .page { background: #fff; max-width: 210mm; margin: 20px auto; padding: 14mm 16mm; box-shadow: 0 2px 12px rgba(0,0,0,.1); }
    h1 { font-size: 20pt; margin: 0; }
    .headline { font-size: 12pt; margin: 2px 0 4px; }
    .contact { font-size: 9.5pt; color: #333; }
    h2 { font-size: 11.5pt; text-transform: uppercase; letter-spacing: .5px; border-bottom: 1px solid #444; padding-bottom: 2px; margin: 16px 0 6px; }
    [dir="rtl"] h2 { text-transform: none; letter-spacing: 0; }
    .item { margin-bottom: 8px; page-break-inside: avoid; }
    .item-title { font-weight: bold; }
    .meta { font-style: italic; color: #333; font-size: 9.5pt; }
    ul { margin: 3px 0 0; padding-inline-start: 18px; }
    li { margin-bottom: 2px; }
    p { margin: 0; }
    .toolbar { position: sticky; top: 0; background: #1f1f1f; color: #fff; padding: 10px 16px; display: flex; gap: 10px; justify-content: center; align-items: center; font-family: Arial, sans-serif; font-size: 14px; }
    .toolbar a, .toolbar button { background: #EA2E00; color: #fff; border: 0; border-radius: 6px; padding: 8px 14px; font-size: 14px; cursor: pointer; text-decoration: none; }
    .toolbar a.secondary { background: #444; }
    @media print { body { background: #fff; } .toolbar { display: none; } .page { box-shadow: none; margin: 0; padding: 0; max-width: none; } }
  </style>
</head>
<body>
  <div class="toolbar" dir="ltr">
    <a class="secondary" href="<?= site_url('mon-compte/cv/' . $cv['id']) ?>">← Modifier</a>
    <button type="button" onclick="window.print()">Télécharger en PDF</button>
    <span style="opacity:.75;font-size:12px">Choisissez « Enregistrer au format PDF » comme imprimante</span>
  </div>

  <div class="page">
    <h1><?= esc($p['full_name']) ?></h1>
    <?php if ($p['headline'] !== ''): ?><div class="headline"><?= esc($p['headline']) ?></div><?php endif; ?>
    <?php if ($contact): ?><div class="contact"><?= esc(implode(' | ', $contact)) ?></div><?php endif; ?>

    <?php if ($d['summary'] !== ''): ?>
      <h2><?= esc($L['summary']) ?></h2>
      <p><?= nl2br(esc($d['summary'])) ?></p>
    <?php endif; ?>

    <?php if ($d['experiences']): ?>
      <h2><?= esc($L['experience']) ?></h2>
      <?php foreach ($d['experiences'] as $e): ?>
        <div class="item">
          <div class="item-title"><?= esc(trim($e['title'] . ' — ' . $e['company'], ' —')) ?></div>
          <?php $meta = implode(' | ', array_filter([CvModel::period($e, $lang), $e['city']])); ?>
          <?php if ($meta !== ''): ?><div class="meta"><?= esc($meta) ?></div><?php endif; ?>
          <?php if ($e['bullets']): ?>
            <ul><?php foreach ($e['bullets'] as $b): ?><li><?= esc($b) ?></li><?php endforeach; ?></ul>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>

    <?php if ($d['education']): ?>
      <h2><?= esc($L['education']) ?></h2>
      <?php foreach ($d['education'] as $e): ?>
        <div class="item">
          <div class="item-title"><?= esc(trim($e['degree'] . ' — ' . $e['school'], ' —')) ?></div>
          <?php $meta = implode(' | ', array_filter([CvModel::period($e, $lang), $e['city']])); ?>
          <?php if ($meta !== ''): ?><div class="meta"><?= esc($meta) ?></div><?php endif; ?>
          <?php if ($e['details'] !== ''): ?><p><?= esc($e['details']) ?></p><?php endif; ?>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>

    <?php if ($d['skills']): ?>
      <h2><?= esc($L['skills']) ?></h2>
      <p><?= esc(implode(', ', $d['skills'])) ?></p>
    <?php endif; ?>

    <?php if ($d['languages']): ?>
      <h2><?= esc($L['languages']) ?></h2>
      <?php foreach ($d['languages'] as $l): ?>
        <p><?= esc($l['name'] . ($l['level'] !== '' ? ' : ' . $l['level'] : '')) ?></p>
      <?php endforeach; ?>
    <?php endif; ?>

    <?php if ($d['certifications']): ?>
      <h2><?= esc($L['certifications']) ?></h2>
      <?php foreach ($d['certifications'] as $c): ?>
        <p><?= esc(implode(' — ', array_filter([$c['name'], $c['org'], $c['year']]))) ?></p>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <?php if (!empty($autoPrint)): ?>
    <script>window.addEventListener('load', function () { setTimeout(function () { window.print(); }, 300); });</script>
  <?php endif; ?>
</body>
</html>
