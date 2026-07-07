<div class="card">
    <div class="card-header">
        <span><?= count($ressources) ?> ressource(s) • <?= (int) ($totalCommandes ?? 0) ?> commande(s)</span>
        <a href="<?= base_url('admin/ressources/new') ?>" class="btn btn-primary btn-sm">+ Nouvelle ressource</a>
    </div>
    <table>
        <thead>
            <tr><th>Titre</th><th>Type</th><th>Accès</th><th>Prix</th><th>Vues</th><th>Téléchargements</th><th>Commandes</th><th>Actions</th></tr>
        </thead>
        <tbody>
        <?php foreach ($ressources as $r): ?>
            <tr>
                <td><strong><?= esc($r['titre']) ?></strong></td>
                <td><?= esc($r['type'] ?? '—') ?></td>
                <td>
                    <?php if (! ($r['is_premium'] ?? 0)): ?>
                        <span class="badge badge-green">Gratuite</span>
                    <?php else: ?>
                        <span class="badge badge-blue">Premium</span>
                    <?php endif; ?>
                </td>
                <td><?= ($r['prix'] ?? 0) > 0 ? number_format($r['prix'], 0, ',', ' ') . ' TND' : '—' ?></td>
                <td><?= (int) ($r['view_count'] ?? 0) ?></td>
                <td><?= (int) ($r['download_count'] ?? 0) ?></td>
                <td><?= (int) ($r['commandes_count'] ?? 0) ?></td>
                <td style="display:flex;gap:.5rem">
                    <a href="<?= base_url('admin/ressources/' . $r['id'] . '/edit') ?>" class="btn btn-secondary btn-sm">Modifier</a>
                    <form action="<?= base_url('admin/ressources/' . $r['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Supprimer ?')">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($ressources)): ?>
            <tr><td colspan="8" style="text-align:center;color:#999;padding:2rem">Aucune ressource</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
