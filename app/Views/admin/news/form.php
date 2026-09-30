<?php $article = $article ?? []; $isEdit = !empty($article['id']); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css">
<div class="card" style="max-width:1000px">
    <div class="card-header">
        <span><?= $isEdit ? 'Modifier l’article' : 'Nouvel article' ?></span>
        <a href="<?= base_url('admin/news') ?>" class="btn btn-secondary btn-sm">← Retour</a>
    </div>
    <div style="padding:1.5rem">
        <form action="<?= $isEdit ? base_url('admin/news/' . $article['id'] . '/update') : base_url('admin/news/store') ?>" method="post" enctype="multipart/form-data">
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
                    <label for="news-thumbnail">Miniature de l’article *</label>
                    <?php if (!empty($article['thumbnail'])): ?>
                        <div style="max-width:420px;margin-bottom:12px">
                            <img src="<?= base_url(esc($article['thumbnail'])) ?>" alt="Miniature actuelle de l’article" style="display:block;width:100%;aspect-ratio:16/9;object-fit:cover;border-radius:8px;border:1px solid #ddd">
                            <small style="display:block;color:#777;margin-top:5px">Choisissez une nouvelle image pour remplacer la miniature actuelle.</small>
                        </div>
                    <?php endif; ?>
                    <input id="news-thumbnail" type="file" name="thumbnail" accept="image/jpeg,image/png,image/webp" <?= empty($article['thumbnail']) ? 'required' : '' ?>>
                    <small style="color:#777">JPG, PNG ou WebP · 5 Mo maximum · format conseillé : paysage 16:9.</small>
                    <div id="thumbnailPreview" style="display:none;max-width:420px;margin-top:12px">
                        <img alt="Aperçu de la nouvelle miniature" style="display:block;width:100%;aspect-ratio:16/9;object-fit:cover;border-radius:8px;border:1px solid #ddd">
                    </div>
                </div>
                <div class="form-group full">
                    <label for="news-content">Article *</label>
                    <div class="news-editor" style="border:1px solid #ddd;border-radius:8px;overflow:hidden;background:#fff">
                        <textarea id="news-content" name="contenu" hidden><?= esc(old('contenu', $article['contenu'] ?? '')) ?></textarea>
                        <div id="news-editor" aria-label="Mise en forme de l’article"></div>
                    </div>
                    <small style="color:#777">Titres, styles de texte, listes à puces ou numérotées, citations, liens, retraits et annulation/rétablissement. Les vidéos Facebook restent dans le champ dédié ci-dessous.</small>
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
    .ql-toolbar.ql-snow{border:0;border-bottom:1px solid #e5e5e5;background:#fafafa}
    #news-editor{min-height:380px;font-size:15px;line-height:1.75}
    #news-editor .ql-editor{min-height:380px;padding:20px}
    #news-editor .ql-editor h2{font:700 1.5rem 'Playfair Display',serif;margin:1.4rem 0 .6rem}
    #news-editor .ql-editor h3{font:700 1.2rem 'Playfair Display',serif;margin:1.2rem 0 .5rem}
    #news-editor .ql-editor blockquote{margin:1rem 0;padding:.5rem 1rem;border-left:3px solid #EA2E00;background:#fff8f6;color:#555}
    #news-editor .ql-editor ol,#news-editor .ql-editor ul{padding-left:1.5rem}
    .ql-snow .ql-tooltip{z-index:30}
</style>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
(function () {
    const input = document.getElementById('news-thumbnail');
    const preview = document.querySelector('#thumbnailPreview img');
    const previewWrap = document.getElementById('thumbnailPreview');
    input.addEventListener('change', function () {
        const file = input.files && input.files[0];
        if (!file) {
            previewWrap.style.display = 'none';
            preview.removeAttribute('src');
            return;
        }
        preview.src = URL.createObjectURL(file);
        previewWrap.style.display = 'block';
    });
})();

(function () {
    const field = document.getElementById('news-content');
    const form = field.closest('form');
    const quill = new Quill('#news-editor', {
        theme: 'snow',
        placeholder: 'Rédigez votre article ici…',
        modules: {
            toolbar: {
                container: [
                    [{ header: [2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    [{ indent: '-1' }, { indent: '+1' }],
                    ['blockquote', 'link'],
                    ['clean']
                ]
            },
            history: { delay: 800, maxStack: 100, userOnly: true }
        }
    });
    const toolbar = document.querySelector('#news-editor .ql-toolbar') || document.querySelector('.ql-toolbar');
    [['undo', 'Annuler', 'fa-rotate-left'], ['redo', 'Rétablir', 'fa-rotate-right']].forEach(function (item) {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'ql-history-' + item[0];
        button.title = item[1];
        button.setAttribute('aria-label', item[1]);
        button.innerHTML = '<i class="fa-solid ' + item[2] + '" aria-hidden="true"></i>';
        button.addEventListener('mousedown', function (event) { event.preventDefault(); });
        button.addEventListener('click', function () { quill.history[item[0]](); });
        toolbar.appendChild(button);
    });
    quill.clipboard.dangerouslyPasteHTML(field.value || '');
    form.addEventListener('submit', function (event) {
        field.value = quill.root.innerHTML.trim();
        if (!quill.getText().trim()) {
            event.preventDefault();
            quill.focus();
            window.alert('Rédigez le contenu de l’article avant de l’enregistrer.');
        }
    });
})();
</script>
