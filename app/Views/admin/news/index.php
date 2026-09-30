<div class="card">
    <div class="card-header">
        <span><?= count($articles) ?> article(s)</span>
        <a href="<?= base_url('admin/news/new') ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus" aria-hidden="true"></i> Nouvel article</a>
    </div>
    <table>
        <thead>
            <tr><th>Titre</th><th>Statut</th><th>Publication</th><th>Vidéos</th><th>Actions</th></tr>
        </thead>
        <tbody>
        <?php foreach ($articles as $article): ?>
            <?php $videos = \App\Models\NewsArticleModel::videoUrlsFromStored($article['video_urls'] ?? ''); ?>
            <tr>
                <td><strong><?= esc($article['titre']) ?></strong><br><small style="color:#888">/actualites/<?= esc($article['slug']) ?></small></td>
                <td><span class="badge <?= $article['statut'] === 'publie' ? 'badge-green' : 'badge-grey' ?>"><?= $article['statut'] === 'publie' ? 'Publié' : 'Brouillon' ?></span></td>
                <td><?= !empty($article['published_at']) ? esc(date('d/m/Y H:i', strtotime($article['published_at']))) : '—' ?></td>
                <td><?= count($videos) ?></td>
                <td style="display:flex;gap:.5rem;align-items:center">
                    <a href="<?= base_url('admin/news/' . $article['id'] . '/edit') ?>" class="btn btn-secondary btn-sm">Modifier</a>
                    <?php if ($article['statut'] === 'publie' && strtotime($article['published_at']) <= time()): ?>
                    <a href="<?= site_url('actualites/' . $article['slug']) ?>" target="_blank" rel="noopener" class="btn btn-secondary btn-sm" aria-label="Voir"><i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
                    <?php endif; ?>
                    <form action="<?= base_url('admin/news/' . $article['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Supprimer cet article ?')">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger btn-sm" aria-label="Supprimer"><i class="fa-solid fa-trash" aria-hidden="true"></i></button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($articles)): ?>
            <tr><td colspan="5" style="text-align:center;color:#999;padding:2rem">Aucun article pour le moment. Créez votre premier article ci-dessus.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
