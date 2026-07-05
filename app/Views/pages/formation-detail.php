<?php
/**
 * formation-detail.php — Style Udemy
 * Colonnes : $formation, $modules[]
 */
$iconTheme  = ['cv'=>'📄','entretien'=>'🎤','recrutement'=>'💼','branding'=>'🔗'];
$lblNiveau  = ['junior'=>'Junior','experimente'=>'Expérimenté','tous'=>'Tous niveaux'];
$icoType    = ['video'=>'▶','quiz'=>'❓','document'=>'📄','texte'=>'📝'];
$lblType    = ['video'=>'Vidéo','quiz'=>'Quiz','document'=>'Document','texte'=>'Texte'];

// Stats
$nbLecons = 0; $totalMin = 0;
foreach ($modules as $m) {
    $nbLecons += count($m['lecons']);
    foreach ($m['lecons'] as $l) $totalMin += (int)($l['duree'] ?? 0);
}
$duree = $totalMin > 0 ? floor($totalMin/60).'h '.str_pad($totalMin%60,2,'0',STR_PAD_LEFT).'min'
       : ($formation['heures'] ?? '');

$isFree   = empty($formation['prix']) || (float)$formation['prix'] == 0;
$hasCert  = !empty($formation['has_certificate']);
$hasQuiz  = !empty($formation['has_quiz']);
$dispo    = ($formation['statut'] ?? '') === 'disponible';

$objectifs = array_filter(array_map('trim', explode("\n", $formation['objectifs'] ?? '')));
$prerequis = array_filter(array_map('trim', explode("\n", $formation['prerequis'] ?? '')));
?>
<style>
/* ═══ FORMATION DETAIL — styles isolés ═══ */

/* Hero banner */
.fpage { font-family: 'DM Sans', system-ui, sans-serif; }
.fhero {
    background: #1c1d1f;
    padding: 40px 0 0;
}
.fhero-wrap {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 24px 40px;
}
.fhero-left { max-width: 800px; }

/* Breadcrumb */
.fbc { display: flex; gap: 6px; align-items: center; font-size: 12px; color: #ccc; margin-bottom: 16px; }
.fbc a { color: #ccc; text-decoration: underline; }
.fbc span { color: #888; }

/* Titre hero */
.fhero h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(24px, 3.2vw, 38px);
    font-weight: 700;
    color: #fff;
    line-height: 1.2;
    margin: 0 0 14px;
}
.fhero-sub { font-size: 16px; color: #d1d7dc; line-height: 1.6; margin: 0 0 18px; }

/* Badges */
.fhero-tags { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 18px; }
.ftag { font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 100px; }
.ftag-outline { border: 1px solid rgba(255,255,255,.35); color: #fff; }
.ftag-gold { background: #c49a3c; color: #fff; }
.ftag-green { background: rgba(110,231,183,.15); color: #6ee7b7; border: 1px solid rgba(110,231,183,.3); }
.ftag-orange { background: rgba(251,191,36,.15); color: #fbbf24; border: 1px solid rgba(251,191,36,.3); }

/* Stats hero */
.fhero-stats { display: flex; flex-wrap: wrap; gap: 20px; }
.fhero-stats span { font-size: 13px; color: #9ca3af; display: flex; align-items: center; gap: 6px; }
.fhero-stats strong { color: #fff; }

/* ── Carte CTA (sidebar dans le hero) ── */
.fcta-box {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 16px rgba(0,0,0,.25);
    overflow: hidden;
}
.fcta-thumb {
    background: linear-gradient(135deg, #ea2e00, #c72600);
    height: 190px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 64px;
    overflow: hidden;
}
.fcta-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.fcta-inner { padding: 20px; }
.fcta-price {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    font-weight: 700;
    color: #1c1d1f;
    margin-bottom: 14px;
    line-height: 1;
}
.fcta-price-free { color: #ea2e00; }
.fcta-price small { font-size: .9rem; font-weight: 400; color: #6b7280; font-family: 'DM Sans', sans-serif; }
.fcta-btn {
    display: block;
    width: 100%;
    text-align: center;
    background: #ea2e00;
    color: #fff;
    font-size: 16px;
    font-weight: 700;
    padding: 14px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    margin-bottom: 12px;
    font-family: inherit;
    transition: background .15s;
    text-decoration: none;
}
.fcta-btn:hover { background: #c72600; color: #fff; }
.fcta-btn-disabled { background: #d1d5db; cursor: not-allowed; }
.fcta-btn-disabled:hover { background: #d1d5db; }
.fcta-guarantee { font-size: 12px; color: #6b7280; text-align: center; margin-bottom: 16px; }
.fcta-guarantee a { color: #ea2e00; }
.fcta-includes { border-top: 1px solid #f3f4f6; padding-top: 14px; }
.fcta-includes h4 { font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 10px; }
.fcta-row { display: flex; align-items: center; gap: 10px; font-size: 13px; color: #6b7280; padding: 5px 0; }
.fcta-row-icon { width: 18px; text-align: center; font-size: 14px; flex-shrink: 0; }

/* ═══ CORPS DE PAGE ═══ */
.fbody {
    max-width: 1180px;
    margin: 0 auto;
    padding: 40px 24px;
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 40px;
    align-items: start;
}
.fmain { min-width: 0; }
.fsidebar { position: sticky; top: 80px; }

/* Section bloc */
.fblock {
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 24px;
}
.fblock-head {
    background: #f9fafb;
    padding: 16px 20px;
    border-bottom: 1px solid #e5e7eb;
    font-size: 15px;
    font-weight: 700;
    color: #1c1d1f;
    display: flex;
    align-items: center;
    gap: 8px;
}
.fblock-body { padding: 20px; }

/* Grille objectifs */
.fobj-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.fobj-item { display: flex; gap: 10px; align-items: flex-start; font-size: 13.5px; color: #374151; line-height: 1.5; }
.fobj-check { color: #16a34a; font-weight: 700; flex-shrink: 0; margin-top: 1px; }

/* Description */
.fprose { font-size: 15px; color: #4b5563; line-height: 1.85; }
.fprose p { margin-bottom: .7rem; }

/* Prérequis */
.fpre-list { list-style: none; display: flex; flex-direction: column; gap: 8px; }
.fpre-item { font-size: 14px; color: #4b5563; display: flex; gap: 8px; }
.fpre-item::before { content: '•'; color: #ea2e00; flex-shrink: 0; }

/* Programme accordéon */
.fsyllabus-meta { font-size: 13px; color: #6b7280; margin-bottom: 12px; }
.fchapter { border-bottom: 1px solid #e5e7eb; }
.fchapter:last-child { border-bottom: none; }
.fchapter-sum {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 20px;
    background: #f9fafb;
    cursor: pointer;
    list-style: none;
    user-select: none;
    transition: background .12s;
}
.fchapter-sum:hover { background: #f3f4f6; }
.fchapter-sum::-webkit-details-marker { display: none; }
details[open] .fchapter-sum { background: #f3f4f6; }
.fchap-arrow { font-size: 10px; color: #ea2e00; transition: transform .2s; flex-shrink: 0; }
details[open] .fchap-arrow { transform: rotate(90deg); }
.fchap-title { font-size: 14px; font-weight: 600; color: #1c1d1f; flex: 1; }
.fchap-meta { font-size: 12px; color: #9ca3af; }

/* Leçons */
.flecons { list-style: none; }
.flecon {
    display: flex;
    align-items: center;
    padding: 10px 20px;
    border-top: 1px solid #f3f4f6;
    gap: 12px;
    transition: background .1s;
}
.flecon:hover { background: #f9fafb; }
.flecon-icon { width: 28px; height: 28px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; color: #6b7280; flex-shrink: 0; }
.flecon-title { font-size: 13px; color: #374151; flex: 1; }
.flecon-preview { font-size: 11px; color: #ea2e00; border: 1px solid #ea2e00; padding: 2px 7px; border-radius: 4px; margin-left: 6px; white-space: nowrap; }
.flecon-preview:hover { background: #ea2e00; color: #fff; }
.flecon-type { font-size: 11px; color: #9ca3af; }
.flecon-dur { font-size: 12px; color: #9ca3af; background: #f3f4f6; padding: 2px 8px; border-radius: 4px; }

/* Badges quiz / certificat */
.fbadge-card { display: flex; align-items: flex-start; gap: 16px; padding: 18px; border-radius: 8px; }
.fbadge-quiz { background: #fffbeb; border: 1px solid #fde68a; }
.fbadge-cert { background: #fffbf0; border: 2px solid #c49a3c; }
.fbadge-ico { font-size: 2rem; flex-shrink: 0; }
.fbadge-card h3 { font-size: 15px; font-weight: 700; color: #1c1d1f; margin-bottom: 4px; }
.fbadge-card p { font-size: 13px; color: #6b7280; margin: 0; line-height: 1.6; }

/* Responsive */
@media (max-width: 900px) {
    .fbody { grid-template-columns: 1fr; }
    .fsidebar { position: static; }
    .fobj-grid { grid-template-columns: 1fr; }
}
@media (max-width: 600px) {
    .fhero { padding: 24px 0 0; }
    .fhero-wrap, .fbody { padding-left: 16px; padding-right: 16px; }
}
</style>

<div class="fpage">

<!-- ══════════ HERO ══════════ -->
<div class="fhero">
  <div class="fhero-wrap">

    <!-- Colonne gauche : infos -->
    <div class="fhero-left">

      <!-- Breadcrumb -->
      <div class="fbc">
        <a href="<?= site_url('formations') ?>">Formations</a>
        <span>›</span>
        <span><?= esc(ucfirst($formation['theme'] ?? '')) ?></span>
        <span>›</span>
        <span><?= esc($formation['titre']) ?></span>
      </div>

      <!-- Titre -->
      <h1><?= esc($formation['titre']) ?></h1>

      <!-- Sous-titre -->
      <?php if (!empty($formation['description_courte'])): ?>
        <p class="fhero-sub"><?= esc($formation['description_courte']) ?></p>
      <?php endif; ?>

      <!-- Tags -->
      <div class="fhero-tags">
        <?php if (!empty($formation['is_populaire'])): ?>
          <span class="ftag ftag-gold">⭐ Populaire</span>
        <?php endif; ?>
        <?php if (!empty($formation['niveau']) && $formation['niveau'] !== 'tous'): ?>
          <span class="ftag ftag-outline"><?= esc($lblNiveau[$formation['niveau']] ?? '') ?></span>
        <?php endif; ?>
        <?php if (!empty($formation['theme'])): ?>
          <span class="ftag ftag-outline"><?= ($iconTheme[$formation['theme']] ?? '📚') ?> <?= esc(ucfirst($formation['theme'])) ?></span>
        <?php endif; ?>
        <?php if ($hasQuiz): ?>
          <span class="ftag ftag-outline">❓ Quiz</span>
        <?php endif; ?>
        <?php if ($hasCert): ?>
          <span class="ftag ftag-gold">🏆 Certificat</span>
        <?php endif; ?>
        <?php if ($dispo): ?>
          <span class="ftag ftag-green">✅ Disponible</span>
        <?php else: ?>
          <span class="ftag ftag-orange">🔜 Bientôt</span>
        <?php endif; ?>
      </div>

      <!-- Stats -->
      <div class="fhero-stats">
        <?php if ($nbLecons > 0): ?>
          <span>🎬 <strong><?= $nbLecons ?></strong> leçons</span>
        <?php elseif (!empty($formation['modules_count'])): ?>
          <span>🎬 <strong><?= (int)$formation['modules_count'] ?></strong> modules</span>
        <?php endif; ?>
        <?php if (!empty($duree)): ?>
          <span>⏱ <strong><?= esc($duree) ?></strong></span>
        <?php endif; ?>
        <span>📱 Accès à vie</span>
        <?php if (!$isFree): ?>
          <span>💳 <strong><?= number_format((float)$formation['prix'],0,',',' ') ?> TND</strong></span>
        <?php endif; ?>
      </div>

    </div>

  </div><!-- /fhero-wrap -->
</div><!-- /fhero -->

<!-- ══════════ CORPS ══════════ -->
<div class="fbody">

  <!-- MAIN -->
  <div class="fmain">

    <!-- ── Objectifs ── -->
    <?php if (!empty($objectifs)): ?>
    <div class="fblock">
      <div class="fblock-head">🎯 Ce que vous apprendrez</div>
      <div class="fblock-body">
        <div class="fobj-grid">
          <?php foreach ($objectifs as $o): ?>
            <div class="fobj-item"><span class="fobj-check">✓</span><?= esc($o) ?></div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <!-- ── Description ── -->
    <?php if (!empty($formation['description_longue']) || !empty($formation['description_courte'])): ?>
    <div class="fblock">
      <div class="fblock-head">📖 Description</div>
      <div class="fblock-body">
        <div class="fprose">
          <?php if (!empty($formation['description_longue'])): ?>
            <?= $formation['description_longue'] ?>
          <?php else: ?>
            <p><?= esc($formation['description_courte']) ?></p>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <!-- ── Prérequis ── -->
    <?php if (!empty($prerequis)): ?>
    <div class="fblock">
      <div class="fblock-head">📋 Prérequis</div>
      <div class="fblock-body">
        <ul class="fpre-list">
          <?php foreach ($prerequis as $p): ?>
            <li class="fpre-item"><?= esc($p) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
    <?php endif; ?>

    <!-- ── Programme ── -->
    <?php if (!empty($modules)): ?>
    <div class="fblock">
      <div class="fblock-head">📚 Programme de la formation</div>
      <div class="fblock-body" style="padding:0">
        <?php if ($nbLecons > 0): ?>
          <p class="fsyllabus-meta" style="padding:14px 20px 0"><?= count($modules) ?> chapitres · <?= $nbLecons ?> leçons · <?= esc($duree) ?></p>
        <?php endif; ?>
        <?php foreach ($modules as $mi => $module):
          $mMin = array_sum(array_column($module['lecons'], 'duree'));
          $mDur = $mMin > 0 ? floor($mMin/60).'h'.str_pad($mMin%60,2,'0',STR_PAD_LEFT) : '';
        ?>
        <details class="fchapter" <?= $mi === 0 ? 'open' : '' ?>>
          <summary class="fchapter-sum">
            <span class="fchap-arrow">▶</span>
            <span class="fchap-title"><?= esc($module['titre']) ?></span>
            <span class="fchap-meta"><?= count($module['lecons']) ?> leçon<?= count($module['lecons'])>1?'s':'' ?><?= $mDur ? ' · '.$mDur : '' ?></span>
          </summary>
          <ul class="flecons">
            <?php foreach ($module['lecons'] as $li => $lecon): ?>
            <li class="flecon">
              <div class="flecon-icon"><?= $icoType[$lecon['type']] ?? '▶' ?></div>
              <span class="flecon-title">
                <?= esc($lecon['titre']) ?>
                <?php if ($lecon['is_free'] && !empty($lecon['video_url'])): ?>
                  <a href="<?= esc($lecon['video_url']) ?>" target="_blank" class="flecon-preview">Aperçu</a>
                <?php elseif ($lecon['is_free']): ?>
                  <span class="flecon-preview" style="cursor:default">Gratuit</span>
                <?php endif; ?>
              </span>
              <span class="flecon-type"><?= $lblType[$lecon['type']] ?? '' ?></span>
              <?php if ($lecon['duree'] > 0): ?>
                <span class="flecon-dur"><?= $lecon['duree'] ?> min</span>
              <?php endif; ?>
            </li>
            <?php endforeach; ?>
          </ul>
        </details>
        <?php endforeach; ?>
      </div>
    </div>
    <?php elseif (empty($objectifs)): ?>
    <!-- Pas de modules ni d'objectifs : affichage générique -->
    <div class="fblock">
      <div class="fblock-head">📚 Ce que vous apprendrez</div>
      <div class="fblock-body">
        <div class="fobj-grid">
          <div class="fobj-item"><span class="fobj-check">✓</span>Techniques pratiques issues du terrain</div>
          <div class="fobj-item"><span class="fobj-check">✓</span>Méthodes adaptées au marché tunisien &amp; francophone</div>
          <div class="fobj-item"><span class="fobj-check">✓</span>Exercices et exemples concrets</div>
          <div class="fobj-item"><span class="fobj-check">✓</span>Accès à vie au contenu</div>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <!-- ── Quiz ── -->
    <?php if ($hasQuiz): ?>
    <div class="fblock">
      <div class="fblock-body">
        <div class="fbadge-card fbadge-quiz">
          <div class="fbadge-ico">❓</div>
          <div>
            <h3>Quiz d'évaluation inclus</h3>
            <p>Testez vos connaissances à chaque étape et mesurez votre progression tout au long de la formation.</p>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <!-- ── Certificat ── -->
    <?php if ($hasCert): ?>
    <div class="fblock">
      <div class="fblock-body">
        <div class="fbadge-card fbadge-cert">
          <div class="fbadge-ico">🏆</div>
          <div>
            <h3>Certificat de réussite</h3>
            <p>Obtenez un certificat officiel Yesmine Gharbi à la fin de cette formation — valorisable sur LinkedIn et auprès de vos employeurs.</p>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>

  </div><!-- /fmain -->

  <!-- SIDEBAR (desktop) -->
  <aside class="fsidebar">
    <div class="fcta-box">
      <div class="fcta-thumb">
        <?php if (!empty($formation['cover_image'])): ?>
          <img src="<?= base_url('assets/covers/' . esc($formation['cover_image'])) ?>" alt="<?= esc($formation['titre']) ?>">
        <?php else: ?>
          <?= $iconTheme[$formation['theme']] ?? '🎓' ?>
        <?php endif; ?>
      </div>
      <div class="fcta-inner">
        <?php if (!$isFree): ?>
          <div class="fcta-price"><?= number_format((float)$formation['prix'],0,',',' ') ?> <small>TND</small></div>
        <?php else: ?>
          <div class="fcta-price fcta-price-free">Gratuite</div>
        <?php endif; ?>

        <?php if ($dispo): ?>
          <a class="fcta-btn" href="mailto:hello@yesminegharbi.com?subject=Inscription : <?= urlencode($formation['titre']) ?>">
            S'inscrire maintenant
          </a>
        <?php else: ?>
          <span class="fcta-btn fcta-btn-disabled">Bientôt disponible</span>
        <?php endif; ?>

        <p class="fcta-guarantee">Questions ? <a href="<?= site_url('contact') ?>">Contactez-moi</a></p>

        <div class="fcta-includes">
          <h4>Cette formation inclut :</h4>
          <?php if (!empty($duree)): ?>
            <div class="fcta-row"><span class="fcta-row-icon">⏱</span><?= esc($duree) ?> de contenu vidéo</div>
          <?php endif; ?>
          <?php if ($nbLecons > 0): ?>
            <div class="fcta-row"><span class="fcta-row-icon">🎬</span><?= $nbLecons ?> leçons</div>
          <?php elseif (!empty($formation['modules_count'])): ?>
            <div class="fcta-row"><span class="fcta-row-icon">📚</span><?= (int)$formation['modules_count'] ?> chapitres</div>
          <?php endif; ?>
          <div class="fcta-row"><span class="fcta-row-icon">📱</span>Accès sur tous les appareils</div>
          <div class="fcta-row"><span class="fcta-row-icon">♾️</span>Accès à vie</div>
          <?php if ($hasCert): ?>
            <div class="fcta-row"><span class="fcta-row-icon">🏆</span>Certificat de réussite</div>
          <?php endif; ?>
          <?php if ($hasQuiz): ?>
            <div class="fcta-row"><span class="fcta-row-icon">❓</span>Quiz d'évaluation</div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </aside>

</div><!-- /fbody -->

</div><!-- /fpage -->
