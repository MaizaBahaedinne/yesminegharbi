<?php
$res = $test['result'] ?? null;
$score = (int) ($test['score'] ?? 0);
$color = $score >= 75 ? 'var(--sauge)' : ($score >= 50 ? 'var(--or)' : 'var(--rouge)');
$verdict = $score >= 75 ? 'Très bonne compatibilité' : ($score >= 50 ? 'Compatibilité moyenne : quelques ajustements à faire' : 'Compatibilité faible : CV à adapter à cette offre');
$card = 'background:#fff;border-radius:16px;padding:1.5rem;box-shadow:0 4px 16px rgba(0,0,0,.05);margin-bottom:1.5rem';
?>
<section class="page-header" style="background:var(--noir)">
  <div class="page-header-inner">
    <a href="<?= site_url('mon-compte/cv') ?>" style="color:rgba(255,255,255,.7);font-size:14px">← Mes CV</a>
    <h1 style="color:#fff;margin-top:8px">Test ATS · <?= esc($cv['titre']) ?></h1>
    <p style="color:rgba(255,255,255,.7)"><?= (int) $testsLeft ?> test(s) gratuit(s) restant(s) aujourd’hui</p>
  </div>
</section>

<section style="background:var(--beige)">
  <div style="max-width:900px;margin:0 auto">
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-error" style="margin-bottom:1rem"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success" style="margin-bottom:1rem"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>

    <?php if ($res): ?>
      <div style="<?= $card ?>;display:flex;flex-wrap:wrap;gap:2rem;align-items:center">
        <div style="width:140px;height:140px;border-radius:50%;border:10px solid <?= $color ?>;display:flex;flex-direction:column;align-items:center;justify-content:center;flex-shrink:0">
          <span style="font-family:'Playfair Display',serif;font-size:42px;font-weight:700;line-height:1"><?= $score ?></span>
          <span style="font-size:12px;color:var(--gris)">/ 100</span>
        </div>
        <div style="flex:1;min-width:240px">
          <h2 style="font-family:'Playfair Display',serif;font-size:1.4rem;margin-bottom:.25rem"><?= esc($verdict) ?></h2>
          <?php if (!empty($test['job_title'])): ?>
            <p style="color:var(--gris);margin:0 0 1rem">Poste : <strong><?= esc($test['job_title']) ?></strong> · <?= esc(date('d/m/Y H:i', strtotime((string) $test['created_at']))) ?></p>
          <?php endif; ?>
          <?php foreach ($res['sections'] ?? [] as $s): $pct = $s['max'] > 0 ? round(100 * $s['points'] / $s['max']) : 0; ?>
            <div style="margin-bottom:.6rem">
              <div style="display:flex;justify-content:space-between;font-size:14px"><span><?= esc($s['label']) ?></span><strong><?= esc((string) round($s['points'])) ?>/<?= (int) $s['max'] ?></strong></div>
              <div style="height:8px;background:var(--beige);border-radius:8px;overflow:hidden"><div style="height:100%;width:<?= (int) $pct ?>%;background:<?= $color ?>"></div></div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div style="<?= $card ?>">
        <h2 style="font-family:'Playfair Display',serif;font-size:1.25rem;margin-bottom:1rem">Mots-clés de l’offre</h2>
        <p style="font-size:14px;margin-bottom:.5rem"><strong style="color:var(--sauge)">Trouvés dans votre CV (<?= count($res['matched'] ?? []) ?>)</strong></p>
        <div style="display:flex;flex-wrap:wrap;gap:.4rem;margin-bottom:1.25rem">
          <?php foreach ($res['matched'] ?? [] as $k): ?>
            <span style="background:var(--sauge-light);color:#2f5f5a;padding:4px 10px;border-radius:20px;font-size:13px"><i class="fa-solid fa-check" aria-hidden="true"></i> <?= esc($k) ?></span>
          <?php endforeach; ?>
        </div>
        <p style="font-size:14px;margin-bottom:.5rem"><strong style="color:var(--rouge)">Manquants (<?= count($res['missing'] ?? []) ?>)</strong></p>
        <div style="display:flex;flex-wrap:wrap;gap:.4rem">
          <?php foreach ($res['missing'] ?? [] as $k): ?>
            <span style="background:var(--rouge-light);color:var(--rouge);padding:4px 10px;border-radius:20px;font-size:13px"><?= esc($k) ?></span>
          <?php endforeach; ?>
        </div>
        <p style="font-size:12px;color:var(--gris);margin-top:1rem">N’ajoutez que les mots-clés qui correspondent vraiment à votre expérience : un recruteur relira votre CV.</p>
      </div>

      <?php $tips = array_merge(...array_map(static fn ($s) => $s['tips'] ?? [], $res['sections'] ?? [])); ?>
      <?php if ($tips): ?>
        <div style="<?= $card ?>">
          <h2 style="font-family:'Playfair Display',serif;font-size:1.25rem;margin-bottom:1rem">Comment améliorer votre score</h2>
          <ul style="padding-inline-start:1.2rem;margin:0;display:grid;gap:.5rem;font-size:15px">
            <?php foreach ($tips as $t): ?><li><?= esc($t) ?></li><?php endforeach; ?>
          </ul>
          <a href="<?= site_url('mon-compte/cv/' . $cv['id']) ?>" class="btn-primary" style="margin-top:1.25rem;display:inline-flex">Modifier mon CV →</a>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <form action="<?= site_url('mon-compte/cv/' . $cv['id'] . '/test-ats') ?>" method="post" style="<?= $card ?>">
      <?= csrf_field() ?>
      <h2 style="font-family:'Playfair Display',serif;font-size:1.25rem;margin-bottom:.5rem"><?= $res ? 'Tester contre une autre offre' : 'Tester mon CV contre une offre' ?></h2>
      <p style="font-size:13px;color:var(--gris);margin-bottom:1rem">Copiez-collez l’annonce complète (missions, profil recherché, compétences).</p>
      <div class="form-group" style="margin-bottom:1rem">
        <label for="job_title">Intitulé du poste</label>
        <input type="text" id="job_title" name="job_title" class="form-input" maxlength="190" value="<?= esc(old('job_title', '')) ?>" placeholder="Ex. Chargé(e) de recrutement IT">
      </div>
      <div class="form-group" style="margin-bottom:1rem">
        <label for="offer_text">Texte de l’offre *</label>
        <textarea id="offer_text" name="offer_text" class="form-input" rows="10" required minlength="200"><?= esc(old('offer_text', '')) ?></textarea>
      </div>
      <button type="submit" class="btn-primary" <?= $testsLeft <= 0 ? 'disabled' : '' ?>>Lancer le test ATS →</button>
      <?php if ($testsLeft <= 0): ?>
        <p style="font-size:13px;color:var(--rouge);margin-top:.5rem">Limite de tests gratuits atteinte pour aujourd’hui.</p>
      <?php endif; ?>
    </form>

    <?php if (!empty($history)): ?>
      <div style="<?= $card ?>">
        <h2 style="font-family:'Playfair Display',serif;font-size:1.25rem;margin-bottom:1rem">Historique des tests</h2>
        <ul style="list-style:none;padding:0;margin:0;display:grid;gap:.5rem">
          <?php foreach ($history as $h): ?>
            <li>
              <a href="<?= site_url('mon-compte/cv/test/' . $h['id']) ?>" style="display:flex;justify-content:space-between;gap:1rem;padding:.6rem .8rem;border:1px solid var(--beige-dark);border-radius:10px;color:var(--noir)">
                <span><?= esc($h['job_title'] ?: 'Offre sans titre') ?> <span style="color:var(--gris);font-size:13px">· <?= esc(date('d/m/Y', strtotime((string) $h['created_at']))) ?></span></span>
                <strong><?= (int) $h['score'] ?>/100</strong>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>
  </div>
</section>
