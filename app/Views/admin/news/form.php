<?php $article = $article ?? []; $isEdit = !empty($article['id']); ?>
<div class="card" style="max-width:1000px">
    <div class="card-header">
        <span><?= $isEdit ? 'Modifier l’article' : 'Nouvel article' ?></span>
        <a href="<?= base_url('admin/news') ?>" class="btn btn-secondary btn-sm">← Retour</a>
    </div>
    <div style="padding:1.5rem">
        <form action="<?= $isEdit ? base_url('admin/news/' . $article['id'] . '/update') : base_url('admin/news/store') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-grid">
                <div class="form-group full">
                    <label for="news-title">Titre *</label>
                    <input id="news-title" type="text" name="titre" maxlength="220" value="<?= esc(old('titre', $article['titre'] ?? '')) ?>" required>
                </div>
                <div class="form-group">
                    <label for="news-status">Publication</label>
                    <?php $status = old('statut', $article['statut'] ?? 'brouillon'); ?>
                    <select id="news-status" name="statut">
                        <option value="brouillon" <?= $status === 'brouillon' ? 'selected' : '' ?>>Brouillon</option>
                        <option value="publie" <?= $status === 'publie' ? 'selected' : '' ?>>Publier maintenant</option>
                    </select>
                </div>
                <div class="form-group full">
                    <label for="news-excerpt">Résumé (facultatif)</label>
                    <textarea id="news-excerpt" name="extrait" rows="3" maxlength="1000" placeholder="Résumé visible dans la liste des articles"><?= esc(old('extrait', $article['extrait'] ?? '')) ?></textarea>
                </div>
                <div class="form-group full">
                    <label for="news-content">Article *</label>
                    <textarea id="news-content" name="contenu" rows="18" required placeholder="Rédigez votre article ici. Séparez les paragraphes par une ligne vide."><?= esc(old('contenu', $article['contenu'] ?? '')) ?></textarea>
                    <small style="color:#777">Texte brut : les paragraphes séparés par une ligne vide seront mis en forme automatiquement.</small>
                </div>
                <div class="form-group full">
                    <label for="news-videos">Vidéos Facebook (une URL publique par ligne)</label>
                    <textarea id="news-videos" name="video_urls" rows="4" placeholder="https://www.facebook.com/nom-de-page/videos/123456789/&#10;https://fb.watch/AbCdEf123/"><?= esc(old('video_urls', $article['video_urls'] ?? '')) ?></textarea>
                    <small style="color:#777">Seules les vidéos ou publications vidéo Facebook publiques peuvent être intégrées. Une vidéo réglée sur « Amis » ou « Privée » ne s’affichera pas sur le site.</small>
                </div>
            </div>
            <div style="margin-top:1.5rem;display:flex;gap:1rem">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> <?= $status === 'publie' ? 'Enregistrer et publier' : 'Enregistrer le brouillon' ?></button>
                <a href="<?= base_url('admin/news') ?>" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
