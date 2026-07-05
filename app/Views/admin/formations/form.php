<?php $f = $formation ?? []; $isEdit = !empty($f['id']); ?>
<div class="card admin-form-page">
    <div class="card-header">
        <span><?= $isEdit ? 'Modifier' : 'Nouvelle' ?> formation</span>
        <a href="<?= base_url('admin/formations') ?>" class="btn btn-secondary btn-sm">← Retour</a>
    </div>
    <div class="admin-form-content">
        <div class="form-preview-grid">
            <div class="form-panel">
                <form action="<?= $isEdit ? base_url('admin/formations/' . $f['id'] . '/update') : base_url('admin/formations/store') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="form-grid">
                        <div class="form-group full">
                            <label>Titre *</label>
                            <input type="text" name="titre" id="titreInput" value="<?= esc($f['titre'] ?? '') ?>" required>
                        </div>
                        <div class="form-group full">
                            <label>Photo de couverture</label>
                            <div class="cover-preview-wrapper">
                                <div class="cover-preview" id="coverPreview">
                                    <?php if (!empty($f['cover_image'])): ?>
                                        <img src="<?= base_url('assets/covers/' . esc($f['cover_image'])) ?>" alt="Cover preview">
                                    <?php else: ?>
                                        <span>Aperçu de la couverture</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <input type="file" name="cover_image" id="coverImageInput" accept="image/jpeg,image/png,image/webp" style="padding:6px">
                            <small style="color:#9ca3af">JPG/PNG/WEBP · max 2 Mo · recommandé 800×450px (16/9)</small>
                        </div>
                        <div class="form-group">
                            <label>Niveau</label>
                            <select name="niveau" id="niveauInput">
                                <?php foreach (['junior','experimente','tous'] as $n): ?>
                                    <option value="<?= $n ?>" <?= ($f['niveau'] ?? '') === $n ? 'selected' : '' ?>><?= ucfirst($n) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Thème</label>
                            <select name="theme" id="themeInput">
                                <?php foreach (['cv','entretien','recrutement','branding'] as $t): ?>
                                    <option value="<?= $t ?>" <?= ($f['theme'] ?? '') === $t ? 'selected' : '' ?>><?= ucfirst($t) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Durée (ex: 6h)</label>
                            <input type="text" name="heures" id="heuresInput" value="<?= esc($f['heures'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Prix (TND, 0 = gratuit)</label>
                            <input type="number" name="prix" id="prixInput" value="<?= esc($f['prix'] ?? 0) ?>" min="0" step="1">
                        </div>
                        <div class="form-group">
                            <label>Statut</label>
                            <select name="statut" id="statutInput">
                                <?php foreach (['disponible'=>'Disponible','bientot'=>'Bientôt disponible','archive'=>'Archivée'] as $val => $label): ?>
                                    <option value="<?= $val ?>" <?= ($f['statut'] ?? '') === $val ? 'selected' : '' ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group full">
                            <label>Description courte</label>
                            <textarea name="description_courte" id="descriptionCourteInput"><?= esc($f['description_courte'] ?? '') ?></textarea>
                        </div>
                        <div class="form-group full">
                            <label>Description longue</label>
                            <textarea name="description_longue" id="descriptionLongueInput" rows="6"><?= esc($f['description_longue'] ?? '') ?></textarea>
                        </div>
                    </div>
                    <div style="margin-top:1.5rem;display:flex;gap:1rem;flex-wrap:wrap">
                        <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
                        <a href="<?= base_url('admin/formations') ?>" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
            <aside class="preview-panel">
                <div class="preview-card">
                    <div class="preview-image" id="previewCoverImage">
                        <?php if (!empty($f['cover_image'])): ?>
                            <img src="<?= base_url('assets/covers/' . esc($f['cover_image'])) ?>" alt="Aperçu de la couverture">
                        <?php else: ?>
                            <span>Aucune image sélectionnée</span>
                        <?php endif; ?>
                    </div>
                    <div class="preview-body">
                        <div class="preview-meta" id="previewMeta">
                            <span class="badge badge-blue" id="previewStatus"><?= $f['statut'] ? ucfirst($f['statut']) : 'Statut' ?></span>
                            <span class="badge badge-green" id="previewLevel"><?= $f['niveau'] ? ucfirst($f['niveau']) : 'Niveau' ?></span>
                            <span class="badge badge-grey" id="previewTheme"><?= $f['theme'] ? ucfirst($f['theme']) : 'Thème' ?></span>
                        </div>
                        <h2 class="preview-title" id="previewTitle"><?= esc($f['titre'] ?? 'Titre de la formation') ?></h2>
                        <p class="preview-text preview-short" id="previewShort"><?= esc($f['description_courte'] ?? 'Résumé court de la formation qui sera affiché en aperçu.') ?></p>
                        <p class="preview-text preview-long" id="previewLong"><?= esc($f['description_longue'] ?? 'Description longue détaillée de la formation, mise à jour en temps réel lorsque vous modifiez le contenu.') ?></p>
                        <div class="preview-stats">
                            <div class="preview-stat"><strong>Durée</strong><br><span id="previewHeures"><?= esc($f['heures'] ?? '0h') ?></span></div>
                            <div class="preview-stat"><strong>Prix</strong><br><span id="previewPrix"><?= isset($f['prix']) ? (esc($f['prix']) === '0' ? 'Gratuit' : esc($f['prix']) . ' TND') : '0 TND' ?></span></div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>

<script>
(function() {
    const preview = {
        title: document.getElementById('previewTitle'),
        short: document.getElementById('previewShort'),
        long: document.getElementById('previewLong'),
        niveau: document.getElementById('previewLevel'),
        theme: document.getElementById('previewTheme'),
        statut: document.getElementById('previewStatus'),
        heures: document.getElementById('previewHeures'),
        prix: document.getElementById('previewPrix'),
        cover: document.getElementById('previewCoverImage'),
    };

    const inputs = {
        titre: document.getElementById('titreInput'),
        descriptionCourte: document.getElementById('descriptionCourteInput'),
        descriptionLongue: document.getElementById('descriptionLongueInput'),
        niveau: document.getElementById('niveauInput'),
        theme: document.getElementById('themeInput'),
        statut: document.getElementById('statutInput'),
        heures: document.getElementById('heuresInput'),
        prix: document.getElementById('prixInput'),
        cover: document.getElementById('coverImageInput'),
    };

    function formatPrice(value) {
        if (value === '' || value === null) {
            return '0 TND';
        }
        return Number(value) === 0 ? 'Gratuit' : value + ' TND';
    }

    function updatePreview() {
        preview.title.textContent = inputs.titre.value.trim() || 'Titre de la formation';
        preview.short.textContent = inputs.descriptionCourte.value.trim() || 'Résumé court de la formation qui sera affiché en aperçu.';
        preview.long.textContent = inputs.descriptionLongue.value.trim() || 'Description longue détaillée de la formation, mise à jour en temps réel lorsque vous modifiez le contenu.';
        preview.niveau.textContent = inputs.niveau.value ? inputs.niveau.value.charAt(0).toUpperCase() + inputs.niveau.value.slice(1) : 'Niveau';
        preview.theme.textContent = inputs.theme.value ? inputs.theme.value.charAt(0).toUpperCase() + inputs.theme.value.slice(1) : 'Thème';
        preview.statut.textContent = inputs.statut.options[inputs.statut.selectedIndex].text || 'Statut';
        preview.heures.textContent = inputs.heures.value.trim() || '0h';
        preview.prix.textContent = formatPrice(inputs.prix.value.trim());
    }

    function updateCoverPreview(file) {
        if (! file) {
            return;
        }

        const reader = new FileReader();
        reader.onload = function(event) {
            preview.cover.innerHTML = '';
            const img = document.createElement('img');
            img.src = event.target.result;
            img.alt = 'Aperçu de la couverture';
            preview.cover.appendChild(img);
        };
        reader.readAsDataURL(file);
    }

    inputs.titre.addEventListener('input', updatePreview);
    inputs.descriptionCourte.addEventListener('input', updatePreview);
    inputs.descriptionLongue.addEventListener('input', updatePreview);
    inputs.niveau.addEventListener('change', updatePreview);
    inputs.theme.addEventListener('change', updatePreview);
    inputs.statut.addEventListener('change', updatePreview);
    inputs.heures.addEventListener('input', updatePreview);
    inputs.prix.addEventListener('input', updatePreview);

    inputs.cover.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            updateCoverPreview(this.files[0]);
        }
    });

    updatePreview();
})();
</script>
