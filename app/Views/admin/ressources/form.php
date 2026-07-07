<?php $r = $ressource ?? []; $isEdit = !empty($r['id']); ?>
<div class="card" style="max-width:800px">
    <div class="card-header">
        <span><?= $isEdit ? 'Modifier' : 'Nouvelle' ?> ressource</span>
        <a href="<?= base_url('admin/ressources') ?>" class="btn btn-secondary btn-sm">← Retour</a>
    </div>
    <div style="padding:1.5rem">
        <form action="<?= $isEdit ? base_url('admin/ressources/' . $r['id'] . '/update') : base_url('admin/ressources/store') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-grid">
                <div class="form-group full">
                    <label>Titre *</label>
                    <input type="text" name="titre" value="<?= esc($r['titre'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>Type</label>
                    <select name="type">
                        <?php foreach (['guide','template','checklist','ebook','kit'] as $t): ?>
                            <option value="<?= $t ?>" <?= ($r['type'] ?? '') === $t ? 'selected' : '' ?>><?= ucfirst($t) ?></option>
                        <?php endforeach; ?>
                    </select>
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
                    <label>Chemin du fichier (ex: /uploads/mon-fichier.pdf)</label>
                    <input type="text" name="fichier_path" value="<?= esc($r['fichier_path'] ?? '') ?>">
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
