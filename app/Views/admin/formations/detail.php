<?php
/**
 * admin/formations/detail.php
 * Gestion des chapitres et leçons d'une formation
 */
$typeIcons = ['video' => '<i class="fa-solid fa-circle-play" aria-hidden="true"></i>', 'quiz' => '<i class="fa-solid fa-circle-question" aria-hidden="true"></i>', 'document' => '<i class="fa-solid fa-file-lines" aria-hidden="true"></i>', 'texte' => '<i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>'];
$typeLabels = ['video' => 'Vidéo', 'quiz' => 'Quiz', 'document' => 'Document', 'texte' => 'Texte'];

// Calcul stats
$totalLecons = 0;
$totalMinutes = 0;
foreach ($modules as $m) {
    $totalLecons += count($m['lecons']);
    foreach ($m['lecons'] as $l) {
        $totalMinutes += (int)($l['duree'] ?? 0);
    }
}
$totalHeures = $totalMinutes > 0 ? floor($totalMinutes / 60) . 'h' . str_pad($totalMinutes % 60, 2, '0', STR_PAD_LEFT) : '0h';
?>

<!-- Breadcrumb + actions -->
<div class="d-flex align-items-center justify-between mb-4">
    <nav class="admin-breadcrumb">
        <a href="<?= base_url('admin/formations') ?>">Formations</a>
        <span>›</span>
        <a href="<?= base_url('admin/formations/' . $formation['id'] . '/edit') ?>"><?= esc($formation['titre']) ?></a>
        <span>›</span>
        <span>Chapitres</span>
    </nav>
    <div style="display:flex;gap:8px">
        <a href="<?= base_url('admin/formations/' . $formation['id'] . '/edit') ?>" class="admin-btn admin-btn-outline">
            <i class="fa-solid fa-pen" aria-hidden="true"></i> Modifier la formation
        </a>
        <a href="<?= site_url('formations/' . $formation['slug']) ?>" target="_blank" class="admin-btn admin-btn-outline">
            <i class="fa-solid fa-eye" aria-hidden="true"></i> Voir sur le site
        </a>
    </div>
</div>

<!-- Stats bar -->
<div class="detail-stats-bar mb-4">
    <div class="detail-stat">
        <span class="ds-value"><?= count($modules) ?></span>
        <span class="ds-label">Chapitres</span>
    </div>
    <div class="detail-stat">
        <span class="ds-value"><?= $totalLecons ?></span>
        <span class="ds-label">Leçons</span>
    </div>
    <div class="detail-stat">
        <span class="ds-value"><?= $totalHeures ?></span>
        <span class="ds-label">Durée totale</span>
    </div>
    <div class="detail-stat">
        <span class="ds-value"><?= $formation['has_quiz'] ? '<i class="fa-solid fa-circle-check" aria-hidden="true"></i>' : '—' ?></span>
        <span class="ds-label">Quiz</span>
    </div>
    <div class="detail-stat">
        <span class="ds-value"><?= $formation['has_certificate'] ? '<i class="fa-solid fa-circle-check" aria-hidden="true"></i>' : '—' ?></span>
        <span class="ds-label">Certificat</span>
    </div>
    <div class="detail-stat">
        <span class="ds-value <?= $formation['statut'] === 'disponible' ? 'text-green' : 'text-orange' ?>">
            <?= ucfirst($formation['statut']) ?>
        </span>
        <span class="ds-label">Statut</span>
    </div>
</div>

<!-- ─── CHAPITRES ──────────────────────────────────────────── -->
<div class="admin-card" id="modules">
    <div class="admin-card-header" style="display:flex;align-items:center;justify-content:space-between">
        <h2 class="admin-card-title"><i class="fa-solid fa-book-open" aria-hidden="true"></i> Programme de la formation</h2>
        <button class="admin-btn admin-btn-primary" onclick="toggleForm('addModuleForm')">
            + Ajouter un chapitre
        </button>
    </div>

    <!-- Formulaire ajout chapitre -->
    <div id="addModuleForm" style="display:none;background:#f8f7ff;border:1px solid #e0dff5;border-radius:10px;padding:16px;margin-bottom:20px">
        <form method="POST" action="<?= base_url('admin/formations/' . $formation['id'] . '/modules/store') ?>">
            <?= csrf_field() ?>
            <div style="display:grid;grid-template-columns:1fr auto;gap:12px;align-items:end">
                <div>
                    <label class="admin-label">Titre du chapitre *</label>
                    <input type="text" name="titre" class="admin-input" placeholder="ex : Chapitre 1 — Les bases du CV" required>
                </div>
                <button type="submit" class="admin-btn admin-btn-primary">Ajouter</button>
            </div>
        </form>
    </div>

    <!-- Liste des chapitres -->
    <?php if (empty($modules)): ?>
        <div class="admin-empty">Aucun chapitre pour l'instant. Ajoutez le premier chapitre ci-dessus.</div>
    <?php else: ?>
        <div class="modules-list">
            <?php foreach ($modules as $mi => $module): ?>
            <div class="module-block" id="module-<?= $module['id'] ?>">

                <!-- En-tête du chapitre -->
                <div class="module-block-header">
                    <div class="module-block-left">
                        <span class="module-idx"><?= $mi + 1 ?></span>
                        <div>
                            <strong><?= esc($module['titre']) ?></strong>
                            <span class="module-meta"><?= count($module['lecons']) ?> leçon<?= count($module['lecons']) > 1 ? 's' : '' ?></span>
                        </div>
                    </div>
                    <div class="module-block-actions">
                        <button class="admin-btn admin-btn-xs" onclick="toggleForm('editModule<?= $module['id'] ?>')"><i class="fa-solid fa-pen" aria-hidden="true"></i></button>
                        <button class="admin-btn admin-btn-xs admin-btn-primary" onclick="toggleForm('addLecon<?= $module['id'] ?>')">+ Leçon</button>
                        <form method="POST" action="<?= base_url('admin/modules/' . $module['id'] . '/delete') ?>" style="display:inline" onsubmit="return confirm('Supprimer ce chapitre et ses leçons ?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="admin-btn admin-btn-xs admin-btn-danger"><i class="fa-solid fa-trash" aria-hidden="true"></i></button>
                        </form>
                    </div>
                </div>

                <!-- Formulaire édition chapitre -->
                <div id="editModule<?= $module['id'] ?>" style="display:none;padding:12px 16px;background:#fffbf5;border-top:1px solid #e8e0d5">
                    <form method="POST" action="<?= base_url('admin/modules/' . $module['id'] . '/update') ?>">
                        <?= csrf_field() ?>
                        <div style="display:grid;grid-template-columns:1fr auto;gap:12px;align-items:end">
                            <div>
                                <label class="admin-label">Titre du chapitre</label>
                                <input type="text" name="titre" class="admin-input" value="<?= esc($module['titre']) ?>" required>
                            </div>
                            <button type="submit" class="admin-btn admin-btn-primary">Sauvegarder</button>
                        </div>
                    </form>
                </div>

                <!-- Formulaire ajout leçon -->
                <div id="addLecon<?= $module['id'] ?>" style="display:none;padding:12px 16px;background:#f0fff8;border-top:1px solid #c3ebd4">
                    <form method="POST" action="<?= base_url('admin/modules/' . $module['id'] . '/lecons/store') ?>">
                        <?= csrf_field() ?>
                        <div class="lecon-form-grid">
                            <div>
                                <label class="admin-label">Titre de la leçon *</label>
                                <input type="text" name="titre" class="admin-input" placeholder="ex : Créer un CV ATS" required>
                            </div>
                            <div>
                                <label class="admin-label">Type</label>
                                <select name="type" class="admin-input">
                                    <option value="video"><i class="fa-solid fa-circle-play" aria-hidden="true"></i> Vidéo</option>
                                    <option value="quiz"><i class="fa-solid fa-circle-question" aria-hidden="true"></i> Quiz</option>
                                    <option value="document"><i class="fa-solid fa-file-lines" aria-hidden="true"></i> Document</option>
                                    <option value="texte"><i class="fa-solid fa-pen-to-square" aria-hidden="true"></i> Texte</option>
                                </select>
                            </div>
                            <div>
                                <label class="admin-label">Durée (min)</label>
                                <input type="number" name="duree" class="admin-input" value="5" min="0" max="999">
                            </div>
                            <div>
                                <label class="admin-label">URL vidéo</label>
                                <input type="url" name="video_url" class="admin-input" placeholder="https://...">
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:16px;margin-top:10px">
                            <label style="display:flex;align-items:center;gap:6px;font-size:13px;cursor:pointer">
                                <input type="checkbox" name="is_free" value="1"> Leçon gratuite (aperçu)
                            </label>
                            <button type="submit" class="admin-btn admin-btn-primary">Ajouter la leçon</button>
                        </div>
                    </form>
                </div>

                <!-- Liste des leçons -->
                <?php if (!empty($module['lecons'])): ?>
                <div class="lecons-list-admin">
                    <?php foreach ($module['lecons'] as $li => $lecon): ?>
                    <div class="lecon-row" id="lecon-<?= $lecon['id'] ?>">
                        <div class="lecon-row-main">
                            <span class="lecon-type-icon" title="<?= $typeLabels[$lecon['type']] ?? '' ?>"><?= $typeIcons[$lecon['type']] ?? '<i class="fa-solid fa-circle-play" aria-hidden="true"></i>' ?></span>
                            <span class="lecon-num"><?= $mi + 1 ?>.<?= $li + 1 ?></span>
                            <span class="lecon-titre"><?= esc($lecon['titre']) ?></span>
                            <?php if ($lecon['is_free']): ?>
                                <span class="badge-free-lecon">Aperçu gratuit</span>
                            <?php endif; ?>
                            <span class="lecon-duree-badge"><?= $lecon['duree'] > 0 ? $lecon['duree'] . ' min' : '—' ?></span>
                        </div>
                        <div class="lecon-row-actions">
                            <button class="admin-btn admin-btn-xs" onclick="toggleForm('editLecon<?= $lecon['id'] ?>')"><i class="fa-solid fa-pen" aria-hidden="true"></i></button>
                            <form method="POST" action="<?= base_url('admin/lecons/' . $lecon['id'] . '/delete') ?>" style="display:inline" onsubmit="return confirm('Supprimer cette leçon ?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="admin-btn admin-btn-xs admin-btn-danger"><i class="fa-solid fa-trash" aria-hidden="true"></i></button>
                            </form>
                        </div>
                    </div>

                    <!-- Formulaire édition leçon inline -->
                    <div id="editLecon<?= $lecon['id'] ?>" style="display:none;padding:12px 16px;background:#f9fafb;border-top:1px dashed #ddd">
                        <form method="POST" action="<?= base_url('admin/lecons/' . $lecon['id'] . '/update') ?>">
                            <?= csrf_field() ?>
                            <div class="lecon-form-grid">
                                <div>
                                    <label class="admin-label">Titre</label>
                                    <input type="text" name="titre" class="admin-input" value="<?= esc($lecon['titre']) ?>" required>
                                </div>
                                <div>
                                    <label class="admin-label">Type</label>
                                    <select name="type" class="admin-input">
                                        <?php foreach ($typeLabels as $val => $lbl): ?>
                                            <option value="<?= $val ?>" <?= $lecon['type'] === $val ? 'selected' : '' ?>><?= $lbl ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div>
                                    <label class="admin-label">Durée (min)</label>
                                    <input type="number" name="duree" class="admin-input" value="<?= (int)$lecon['duree'] ?>" min="0">
                                </div>
                                <div>
                                    <label class="admin-label">URL vidéo</label>
                                    <input type="url" name="video_url" class="admin-input" value="<?= esc($lecon['video_url'] ?? '') ?>">
                                </div>
                            </div>
                            <div style="display:flex;align-items:center;gap:16px;margin-top:10px">
                                <label style="display:flex;align-items:center;gap:6px;font-size:13px;cursor:pointer">
                                    <input type="checkbox" name="is_free" value="1" <?= $lecon['is_free'] ? 'checked' : '' ?>>
                                    Leçon gratuite (aperçu)
                                </label>
                                <button type="submit" class="admin-btn admin-btn-primary">Sauvegarder</button>
                                <button type="button" class="admin-btn admin-btn-outline" onclick="toggleForm('editLecon<?= $lecon['id'] ?>')">Annuler</button>
                            </div>
                        </form>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                    <div style="padding:12px 16px;color:#999;font-size:13px;font-style:italic">Aucune leçon — cliquez "+ Leçon" pour ajouter</div>
                <?php endif; ?>

            </div><!-- /.module-block -->
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- ─── OPTIONS QUIZ & CERTIFICAT ──────────────────────────── -->
<div class="admin-card" style="margin-top:20px">
    <div class="admin-card-header">
        <h2 class="admin-card-title"><i class="fa-solid fa-gear" aria-hidden="true"></i> Options de la formation</h2>
    </div>
    <form method="POST" action="<?= base_url('admin/formations/' . $formation['id'] . '/update') ?>">
        <?= csrf_field() ?>
        <!-- Champs cachés pour les données de base (obligatoires pour le update) -->
        <input type="hidden" name="titre"              value="<?= esc($formation['titre']) ?>">
        <input type="hidden" name="description_courte" value="<?= esc($formation['description_courte']) ?>">
        <input type="hidden" name="description_longue" value="<?= esc($formation['description_longue'] ?? '') ?>">
        <input type="hidden" name="objectifs"          value="<?= esc($formation['objectifs'] ?? '') ?>">
        <input type="hidden" name="prerequis"          value="<?= esc($formation['prerequis'] ?? '') ?>">
        <input type="hidden" name="niveau"             value="<?= esc($formation['niveau']) ?>">
        <input type="hidden" name="theme"              value="<?= esc($formation['theme']) ?>">
        <input type="hidden" name="heures"             value="<?= esc($formation['heures']) ?>">
        <input type="hidden" name="prix"               value="<?= esc($formation['prix']) ?>">
        <input type="hidden" name="statut"             value="<?= esc($formation['statut']) ?>">

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
            <label class="option-toggle">
                <input type="checkbox" name="has_quiz" value="1" <?= $formation['has_quiz'] ? 'checked' : '' ?>>
                <div class="option-toggle-card">
                    <span class="option-icon"><i class="fa-solid fa-circle-question" aria-hidden="true"></i></span>
                    <div>
                        <strong>Quiz inclus</strong>
                        <p>La formation inclut des évaluations de connaissances</p>
                    </div>
                </div>
            </label>
            <label class="option-toggle">
                <input type="checkbox" name="has_certificate" value="1" <?= $formation['has_certificate'] ? 'checked' : '' ?>>
                <div class="option-toggle-card">
                    <span class="option-icon"><i class="fa-solid fa-trophy" aria-hidden="true"></i></span>
                    <div>
                        <strong>Certificat de réussite</strong>
                        <p>Un certificat est délivré à la fin de la formation</p>
                    </div>
                </div>
            </label>
        </div>

        <div style="margin-top:16px">
            <button type="submit" class="admin-btn admin-btn-primary">Sauvegarder les options</button>
        </div>
    </form>
</div>

<script>
function toggleForm(id) {
    const el = document.getElementById(id);
    if (el) el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
</script>
