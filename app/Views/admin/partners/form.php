<?php $partner = $partner ?? []; $isEdit = !empty($partner['id']); ?>
<div class="card" style="max-width:850px">
    <div class="card-header">
        <span><?= $isEdit ? 'Modifier le partenaire' : 'Nouveau partenaire' ?></span>
        <a href="<?= base_url('admin/partners') ?>" class="btn btn-secondary btn-sm">← Retour</a>
    </div>
    <div style="padding:1.5rem">
        <form action="<?= $isEdit ? base_url('admin/partners/' . $partner['id'] . '/update') : base_url('admin/partners/store') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="form-grid">
                <div class="form-group full">
                    <label for="partner-name">Nom du partenaire *</label>
                    <input id="partner-name" type="text" name="nom" maxlength="160" value="<?= esc(old('nom', $partner['nom'] ?? '')) ?>" required>
                </div>
                <div class="form-group full">
                    <label for="partner-logo">Logo *</label>
                    <?php if (!empty($partner['logo'])): ?>
                        <div style="margin-bottom:12px">
                            <img src="<?= base_url(esc($partner['logo'])) ?>" alt="Logo actuel de <?= esc($partner['nom']) ?>" style="width:200px;height:110px;object-fit:contain;padding:12px;background:#fff;border:1px solid #eee;border-radius:8px">
                            <small style="display:block;color:#777;margin-top:6px">Choisissez une nouvelle image pour remplacer le logo actuel.</small>
                        </div>
                    <?php endif; ?>
                    <input id="partner-logo" type="file" name="logo" accept="image/jpeg,image/png,image/webp" <?= empty($partner['logo']) ? 'required' : '' ?>>
                    <small style="color:#777">PNG, JPG ou WebP · 4 Mo maximum. Un logo PNG avec fond transparent est idéal.</small>
                    <div id="partnerLogoPreview" style="display:none;margin-top:12px"><img alt="Aperçu du logo" style="width:200px;height:110px;object-fit:contain;padding:12px;background:#fff;border:1px solid #eee;border-radius:8px"></div>
                </div>
                <div class="form-group full">
                    <label for="instagram-url">Reel Instagram (URL publique)</label>
                    <input id="instagram-url" type="url" name="instagram_url" value="<?= esc(old('instagram_url', $partner['instagram_url'] ?? '')) ?>" placeholder="https://www.instagram.com/reel/ABC123/">
                    <small style="color:#777">Le compte ou le Reel doit être public et autoriser l’intégration. La vidéo s’affichera sous le logo.</small>
                </div>
                <div class="form-group">
                    <label for="partner-position">Ordre d’affichage</label>
                    <input id="partner-position" type="number" name="position" min="0" step="1" value="<?= esc(old('position', $partner['position'] ?? 0)) ?>">
                </div>
                <div class="form-group">
                    <label for="partner-active">Visibilité</label>
                    <select id="partner-active" name="is_active">
                        <option value="1" <?= (string) old('is_active', $partner['is_active'] ?? 1) === '1' ? 'selected' : '' ?>>Afficher</option>
                        <option value="0" <?= (string) old('is_active', $partner['is_active'] ?? 1) === '0' ? 'selected' : '' ?>>Masquer</option>
                    </select>
                </div>
            </div>
            <div style="margin-top:1.5rem;display:flex;gap:1rem">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> Enregistrer</button>
                <a href="<?= base_url('admin/partners') ?>" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
<script>
(function () {
    const input = document.getElementById('partner-logo');
    const preview = document.querySelector('#partnerLogoPreview img');
    const wrap = document.getElementById('partnerLogoPreview');
    input.addEventListener('change', function () {
        const file = input.files && input.files[0];
        if (!file) {
            wrap.style.display = 'none';
            preview.removeAttribute('src');
            return;
        }
        preview.src = URL.createObjectURL(file);
        wrap.style.display = 'block';
    });
})();
</script>
