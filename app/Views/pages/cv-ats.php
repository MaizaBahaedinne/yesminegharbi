<div class="page-header">
  <div class="page-header-inner">
    <span class="section-tag"><?= esc(lang('Site.cv_ats.eyebrow')) ?></span>
    <h1><?= lang('Site.cv_ats.title') ?></h1>
    <p><?= esc(lang('Site.cv_ats.intro')) ?></p>
    <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:24px">
      <a href="<?= site_url(!empty($isLoggedIn) ? 'mon-compte/cv' : 'connexion') ?>" class="btn-primary">
        <?= esc(lang(!empty($isLoggedIn) ? 'Site.cv_ats.my_cvs' : 'Site.cv_ats.create_cv')) ?>
      </a>
    </div>
  </div>
</div>

<section>
  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:24px;max-width:1000px;margin:0 auto">
    <?php
    $steps = [
        ['icon' => 'fa-pen-to-square', 'titre' => lang('Site.cv_ats.step_1_title'), 'desc' => lang('Site.cv_ats.step_1_text')],
        ['icon' => 'fa-bullseye', 'titre' => lang('Site.cv_ats.step_2_title'), 'desc' => lang('Site.cv_ats.step_2_text')],
        ['icon' => 'fa-chart-column', 'titre' => lang('Site.cv_ats.step_3_title'), 'desc' => lang('Site.cv_ats.step_3_text')],
        ['icon' => 'fa-file-arrow-down', 'titre' => lang('Site.cv_ats.step_4_title'), 'desc' => lang('Site.cv_ats.step_4_text')],
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
    <?= esc(lang('Site.cv_ats.free_limit')) ?>
  </p>
</section>
