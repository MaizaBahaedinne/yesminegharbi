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
                    <div class="news-editor" style="border:1px solid #ddd;border-radius:8px;overflow:hidden;background:#fff">
                        <div class="news-toolbar" role="toolbar" aria-label="Mise en forme de l’article" style="display:flex;flex-wrap:wrap;gap:4px;padding:8px;border-bottom:1px solid #e5e5e5;background:#fafafa">
                            <button type="button" data-command="formatBlock" data-value="p" title="Paragraphe" aria-label="Paragraphe"><i class="fa-solid fa-paragraph"></i></button>
                            <button type="button" data-command="formatBlock" data-value="h2" title="Titre de section" aria-label="Titre de section"><i class="fa-solid fa-heading"></i><small>2</small></button>
                            <button type="button" data-command="formatBlock" data-value="h3" title="Sous-titre" aria-label="Sous-titre"><i class="fa-solid fa-heading"></i><small>3</small></button>
                            <button type="button" data-command="bold" title="Gras" aria-label="Gras"><i class="fa-solid fa-bold"></i></button>
                            <button type="button" data-command="italic" title="Italique" aria-label="Italique"><i class="fa-solid fa-italic"></i></button>
                            <button type="button" data-command="underline" title="Souligné" aria-label="Souligné"><i class="fa-solid fa-underline"></i></button>
                            <button type="button" data-command="insertUnorderedList" title="Liste à puces" aria-label="Liste à puces"><i class="fa-solid fa-list-ul"></i></button>
                            <button type="button" data-command="insertOrderedList" title="Liste numérotée" aria-label="Liste numérotée"><i class="fa-solid fa-list-ol"></i></button>
                            <button type="button" data-command="formatBlock" data-value="blockquote" title="Citation" aria-label="Citation"><i class="fa-solid fa-quote-left"></i></button>
                            <button type="button" data-command="createLink" title="Ajouter un lien" aria-label="Ajouter un lien"><i class="fa-solid fa-link"></i></button>
                            <button type="button" data-command="unlink" title="Retirer le lien" aria-label="Retirer le lien"><i class="fa-solid fa-link-slash"></i></button>
                        </div>
                        <div id="news-editor" contenteditable="true" role="textbox" aria-multiline="true" aria-label="Contenu de l’article" style="min-height:360px;padding:20px;line-height:1.75;outline:none" data-placeholder="Rédigez votre article ici…"><?= old('contenu', $article['contenu'] ?? '') ?></div>
                        <textarea id="news-content" name="contenu" hidden><?= esc(old('contenu', $article['contenu'] ?? '')) ?></textarea>
                    </div>
                    <small style="color:#777">Écrivez et structurez l’article avec les outils. Le lecteur verra cette mise en forme. Les vidéos Facebook restent dans le champ dédié ci-dessous.</small>
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

<style>
    .news-toolbar button{height:34px;min-width:36px;padding:0 8px;border:1px solid transparent;border-radius:6px;background:transparent;color:#333;cursor:pointer}
    .news-toolbar button:hover,.news-toolbar button:focus-visible{background:#fff;border-color:#ddd;color:#EA2E00}
    #news-editor:empty::before{content:attr(data-placeholder);color:#999;pointer-events:none}
    #news-editor h2{font:700 1.5rem 'Playfair Display',serif;margin:1.4rem 0 .6rem}
    #news-editor h3{font:700 1.2rem 'Playfair Display',serif;margin:1.2rem 0 .5rem}
    #news-editor blockquote{margin:1rem 0;padding:.5rem 1rem;border-left:3px solid #EA2E00;background:#fff8f6;color:#555}
    #news-editor ul,#news-editor ol{padding-left:1.5rem}
</style>
<script>
(function () {
    const editor = document.getElementById('news-editor');
    const field = document.getElementById('news-content');
    const form = editor.closest('form');
    document.querySelectorAll('.news-toolbar button').forEach(function (button) {
        button.addEventListener('mousedown', function (event) { event.preventDefault(); });
        button.addEventListener('click', function () {
            editor.focus();
            if (button.dataset.command === 'createLink') {
                const url = window.prompt('Adresse du lien (https://…)');
                if (url) document.execCommand('createLink', false, url);
                return;
            }
            document.execCommand(button.dataset.command, false, button.dataset.value || null);
        });
    });
    form.addEventListener('submit', function (event) {
        field.value = editor.innerHTML.trim();
        if (!editor.innerText.trim()) {
            event.preventDefault();
            editor.focus();
            window.alert('Rédigez le contenu de l’article avant de l’enregistrer.');
        }
    });
})();
</script>
