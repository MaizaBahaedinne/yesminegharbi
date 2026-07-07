<?php $testimonial = $testimonial ?? null; $isEdit = !empty($testimonial['id']); ?>

<div class="card" style="max-width:760px">
    <div class="card-header">
        <span><?= $isEdit ? 'Modifier' : 'Ajouter' ?> un témoignage</span>
        <a href="<?= base_url('admin/testimonials') ?>" class="btn btn-secondary btn-sm">← Retour</a>
    </div>
    <div style="padding:1.5rem">
        <form action="<?= $isEdit ? base_url('admin/testimonials/' . $testimonial['id'] . '/update') : base_url('admin/testimonials/store') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-grid">
                <div class="form-group full">
                    <label>Texte du témoignage *</label>
                    <textarea name="quote" rows="5" required><?= esc($testimonial['quote'] ?? '') ?></textarea>
                </div>
                <div class="form-group">
                    <label>Nom *</label>
                    <input type="text" name="author_name" value="<?= esc($testimonial['author_name'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>Fonction / ville</label>
                    <input type="text" name="author_role" value="<?= esc($testimonial['author_role'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Note</label>
                    <select name="rating">
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <option value="<?= $i ?>" <?= (($testimonial['rating'] ?? 5) == $i) ? 'selected' : '' ?>><?= $i ?> étoile<?= $i > 1 ? 's' : '' ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Initiales</label>
                    <input type="text" name="avatar_initials" value="<?= esc($testimonial['avatar_initials'] ?? '') ?>" placeholder="ex: SD">
                </div>
                <div class="form-group">
                    <label>Couleur de l'avatar</label>
                    <input type="text" name="avatar_color" value="<?= esc($testimonial['avatar_color'] ?? '') ?>" placeholder="ex: #EA2E00">
                </div>
                <div class="form-group">
                    <label>Ordre d'affichage</label>
                    <input type="number" name="sort_order" value="<?= esc($testimonial['sort_order'] ?? 0) ?>" min="0">
                </div>
                <div class="form-group full" style="display:flex;align-items:center;gap:1rem;">
                    <label style="margin-right:1rem">Actif</label>
                    <input type="checkbox" name="is_active" value="1" <?= !empty($testimonial['is_active']) ? 'checked' : '' ?>>
                </div>
            </div>
            <div style="margin-top:1.5rem;display:flex;gap:1rem;flex-wrap:wrap">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> Enregistrer</button>
                <a href="<?= base_url('admin/testimonials') ?>" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
