<?php $r = $ressource ?? []; $isEdit = !empty($r['id']); ?>
<div class="card" style="max-width:800px">
    <div class="card-header">
        <span><?= $isEdit ? 'Modifier' : 'Nouvelle' ?> ressource</span>
        <a href="<?= base_url('admin/ressources') ?>" class="btn btn-secondary btn-sm">← Retour</a>
    </div>
    <div style="padding:1.5rem">
        <form action="<?= $isEdit ? base_url('admin/ressources/' . $r['id'] . '/update') : base_url('admin/ressources/store') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="form-grid">
                <div class="form-group full">
                    <label>Titre *</label>
                    <input type="text" name="titre" value="<?= esc($r['titre'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>Type</label>
                    <select name="type">
                        <?php
                        $types = \App\Models\RessourceModel::TYPES;
                        if (!empty($r['type']) && !isset($types[$r['type']])) {
                            $types[$r['type']] = ucfirst($r['type']);
                        }
                        foreach ($types as $t => $label): ?>
                            <option value="<?= esc($t) ?>" <?= ($r['type'] ?? '') === $t ? 'selected' : '' ?>><?= esc($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Thématique principale</label>
                    <select name="thematique">
                        <option value="">— Aucune —</option>
                        <?php foreach (\App\Models\RessourceModel::THEMATIQUES as $k => $label): ?>
                            <option value="<?= esc($k) ?>" <?= ($r['thematique'] ?? '') === $k ? 'selected' : '' ?>><?= esc($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group full">
                    <label>Thématiques secondaires</label>
                    <?php $secondaires = array_filter(explode(',', (string) ($r['thematiques_secondaires'] ?? ''))); ?>
                    <div style="display:flex;flex-wrap:wrap;gap:.5rem 1.25rem">
                        <?php foreach (\App\Models\RessourceModel::THEMATIQUES as $k => $label): ?>
                            <label style="display:flex;align-items:center;gap:.4rem;font-weight:400;cursor:pointer">
                                <input type="checkbox" name="thematiques_secondaires[]" value="<?= esc($k) ?>" <?= in_array($k, $secondaires, true) ? 'checked' : '' ?> style="width:auto">
                                <?= esc($label) ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label>Profil cible</label>
                    <select name="profil">
                        <?php foreach (['junior','experimente','recruteur','tous'] as $p): ?>
                            <option value="<?= $p ?>" <?= ($r['profil'] ?? '') === $p ? 'selected' : '' ?>><?= ucfirst($p) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group full">
                    <label>Description courte</label>
                    <textarea name="description_courte"><?= esc($r['description_courte'] ?? '') ?></textarea>
                </div>
                <div class="form-group full">
                    <label>Description longue</label>
                    <textarea name="description_longue" rows="5"><?= esc($r['description_longue'] ?? '') ?></textarea>
                </div>
                <div class="form-group full">
                    <label>Fichier (PDF, Word, Excel, PowerPoint, ZIP, image, audio, MP4 — 200 Mo max)</label>
                    <?php if (!empty($r['fichier_path'])): ?>
                        <div style="font-size:13px;margin-bottom:.5rem">
                            Fichier actuel : <strong><?= esc(basename($r['fichier_path'])) ?></strong>
                            <label style="display:inline-flex;align-items:center;gap:.35rem;margin-left:1rem;font-weight:400;cursor:pointer">
                                <input type="checkbox" name="remove_file" value="1" style="width:auto"> Retirer le fichier
                            </label>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="fichier" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.png,.jpg,.jpeg,.mp3,.mp4">
                    <small style="color:#6b7280">Le fichier est stocké hors du dossier public : seuls les utilisateurs ayant accès peuvent le télécharger.</small>
                </div>
                <div class="form-group full">
                    <label>Vidéo YouTube (lien)</label>
                    <input type="url" name="video_url" value="<?= esc(old('video_url', $r['video_url'] ?? '')) ?>" placeholder="https://www.youtube.com/watch?v=...">
                    <small style="color:#6b7280">Réglez la vidéo en « Non répertoriée » sur YouTube (une vidéo « Privée » ne peut pas être lue sur le site). Elle ne s'affiche qu'aux utilisateurs ayant accès à la ressource.</small>
                </div>
                <div class="form-group">
                    <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer">
                        <input type="checkbox" name="is_premium" value="1" <?= ($r['is_premium'] ?? 0) ? 'checked' : '' ?> style="width:auto">
                        Ressource premium (payante)
                    </label>
                </div>
                <div class="form-group">
                    <label>Prix si premium (TND)</label>
                    <input type="number" name="prix" value="<?= esc($r['prix'] ?? 0) ?>" min="0" step="1">
                </div>
            </div>
            <div style="margin-top:1.5rem;display:flex;gap:1rem">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> Enregistrer</button>
                <a href="<?= base_url('admin/ressources') ?>" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
