<?php $f = $formation ?? []; $isEdit = !empty($f['id']); ?>
<div class="card" style="max-width:800px">
    <div class="card-header">
        <span><?= $isEdit ? 'Modifier' : 'Nouvelle' ?> formation</span>
        <a href="<?= base_url('admin/formations') ?>" class="btn btn-secondary btn-sm">← Retour</a>
    </div>
    <div style="padding:1.5rem">
        <form action="<?= $isEdit ? base_url('admin/formations/' . $f['id'] . '/update') : base_url('admin/formations/store') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="form-grid">
                <div class="form-group full">
                    <label>Titre *</label>
                    <input type="text" name="titre" value="<?= esc($f['titre'] ?? '') ?>" required>
                </div>
                <div class="form-group full">
                    <label>Photo de couverture</label>
                    <?php if (!empty($f['cover_image'])): ?>
                        <div style="margin-bottom:8px">
                            <img src="<?= base_url('assets/covers/' . esc($f['cover_image'])) ?>" alt="Cover" style="height:80px;border-radius:6px;border:1px solid #e5e7eb;object-fit:cover">
                            <span style="font-size:12px;color:#6b7280;margin-left:8px"><?= esc($f['cover_image']) ?></span>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="cover_image" accept="image/jpeg,image/png,image/webp" style="padding:6px">
                    <small style="color:#9ca3af">JPG/PNG/WEBP · max 2 Mo · recommandé 800×450px (16/9)</small>
                </div>
                <div class="form-group">
                    <label>Niveau</label>
                    <select name="niveau">
                        <?php foreach (['junior','experimente','tous'] as $n): ?>
                            <option value="<?= $n ?>" <?= ($f['niveau'] ?? '') === $n ? 'selected' : '' ?>><?= ucfirst($n) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Thème</label>
                    <select name="theme">
                        <?php foreach (['cv','entretien','recrutement','branding'] as $t): ?>
                            <option value="<?= $t ?>" <?= ($f['theme'] ?? '') === $t ? 'selected' : '' ?>><?= ucfirst($t) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Durée (ex: 6h)</label>
                    <input type="text" name="heures" value="<?= esc($f['heures'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Prix (TND, 0 = gratuit)</label>
                    <input type="number" name="prix" value="<?= esc($f['prix'] ?? 0) ?>" min="0" step="1">
                </div>
                <div class="form-group">
                    <label>Statut</label>
                    <select name="statut">
                        <?php foreach (['disponible'=>'Disponible','bientot'=>'Bientôt disponible','archive'=>'Archivée'] as $val => $label): ?>
                            <option value="<?= $val ?>" <?= ($f['statut'] ?? '') === $val ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group full">
                    <label>Description courte</label>
                    <textarea name="description_courte"><?= esc($f['description_courte'] ?? '') ?></textarea>
                </div>
                <div class="form-group full">
                    <label>Description longue</label>
                    <textarea name="description_longue" rows="6"><?= esc($f['description_longue'] ?? '') ?></textarea>
                </div>
            </div>
            <div style="margin-top:1.5rem;display:flex;gap:1rem">
                <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
                <a href="<?= base_url('admin/formations') ?>" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
