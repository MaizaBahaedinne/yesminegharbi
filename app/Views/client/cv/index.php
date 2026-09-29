<?php use App\Models\CvModel; ?>
<section class="page-header" style="background:var(--noir)">
  <div class="page-header-inner">
    <span class="section-tag" style="color:var(--sauge)">CV ATS</span>
    <h1 style="color:#fff">Mes CV</h1>
    <p style="color:rgba(255,255,255,.7)"><?= count($cvs) ?>/<?= (int) $maxCv ?> CV · <?= (int) $testsLeft ?> test(s) ATS restant(s) aujourd’hui</p>
  </div>
</section>

<section style="background:var(--beige)">
  <div style="max-width:960px;margin:0 auto">
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success" style="margin-bottom:1rem"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-error" style="margin-bottom:1rem"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?php if ($cvs): ?>
      <div style="display:grid;gap:1rem;margin-bottom:2rem">
        <?php foreach ($cvs as $c): ?>
          <div style="background:#fff;border-radius:16px;padding:1.25rem 1.5rem;display:flex;flex-wrap:wrap;justify-content:space-between;align-items:center;gap:1rem;box-shadow:0 4px 16px rgba(0,0,0,.05)">
            <div>
              <strong style="font-size:17px"><?= esc($c['titre']) ?></strong>
              <div style="color:var(--gris);font-size:13px;margin-top:4px">
                <?= esc(CvModel::LANGUES[$c['langue']] ?? $c['langue']) ?> · modifié le <?= esc(date('d/m/Y', strtotime((string) $c['updated_at']))) ?>
              </div>
            </div>
            <div style="display:flex;flex-wrap:wrap;gap:.5rem">
              <a href="<?= site_url('mon-compte/cv/' . $c['id']) ?>" class="btn-secondary" style="padding:8px 14px;font-size:13px"><i class="fa-solid fa-pen" aria-hidden="true"></i> Modifier</a>
              <a href="<?= site_url('mon-compte/cv/' . $c['id'] . '/test-ats') ?>" class="btn-primary" style="padding:8px 14px;font-size:13px"><i class="fa-solid fa-bullseye" aria-hidden="true"></i> Test ATS</a>
              <a href="<?= site_url('mon-compte/cv/' . $c['id'] . '/apercu?print=1') ?>" target="_blank" rel="noopener" class="btn-secondary" style="padding:8px 14px;font-size:13px"><i class="fa-solid fa-file-pdf" aria-hidden="true"></i> PDF</a>
              <a href="<?= site_url('mon-compte/cv/' . $c['id'] . '/word') ?>" class="btn-secondary" style="padding:8px 14px;font-size:13px"><i class="fa-solid fa-file-word" aria-hidden="true"></i> Word</a>
              <form action="<?= site_url('mon-compte/cv/' . $c['id'] . '/supprimer') ?>" method="post" onsubmit="return confirm('Supprimer ce CV et ses tests ATS ?')" style="margin:0">
                <?= csrf_field() ?>
                <button type="submit" class="btn-secondary" style="padding:8px 14px;font-size:13px;color:var(--rouge)" aria-label="Supprimer"><i class="fa-solid fa-trash" aria-hidden="true"></i></button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if (count($cvs) < $maxCv): ?>
      <form action="<?= site_url('mon-compte/cv') ?>" method="post" style="background:#fff;border-radius:16px;padding:1.5rem;box-shadow:0 4px 16px rgba(0,0,0,.05)">
        <?= csrf_field() ?>
        <h2 style="font-family:'Playfair Display',serif;font-size:1.3rem;margin-bottom:1rem"><?= $cvs ? 'Créer un autre CV' : 'Créer mon premier CV' ?></h2>
        <div style="display:grid;grid-template-columns:2fr 1fr auto;gap:1rem;align-items:end">
          <div class="form-group">
            <label for="cv_titre">Nom du CV (pour vous)</label>
            <input type="text" id="cv_titre" name="titre" class="form-input" maxlength="120" placeholder="Ex. CV Chargée de recrutement">
          </div>
          <div class="form-group">
            <label for="cv_langue">Langue du CV</label>
            <select id="cv_langue" name="langue" class="form-input">
              <?php foreach (CvModel::LANGUES as $k => $label): ?>
                <option value="<?= esc($k) ?>"><?= esc($label) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <button type="submit" class="btn-primary">Créer →</button>
        </div>
      </form>
    <?php else: ?>
      <p style="text-align:center;color:var(--gris)">Limite de <?= (int) $maxCv ?> CV gratuits atteinte. Supprimez un CV pour en créer un nouveau.</p>
    <?php endif; ?>
  </div>
</section>
