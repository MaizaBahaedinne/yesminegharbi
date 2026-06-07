<div class="card">
    <div class="card-header">
        <span><?= count($formations) ?> formation(s)</span>
        <a href="<?= base_url('admin/formations/new') ?>" class="btn btn-primary btn-sm">+ Nouvelle formation</a>
    </div>
    <table>
        <thead>
            <tr><th>Titre</th><th>Niveau</th><th>Thème</th><th>Prix</th><th>Statut</th><th>Actions</th></tr>
        </thead>
        <tbody>
        <?php foreach ($formations as $f): ?>
            <tr>
                <td><strong><?= esc($f['titre']) ?></strong></td>
                <td><?= esc($f['niveau'] ?? '—') ?></td>
                <td><?= esc($f['theme'] ?? '—') ?></td>
                <td><?= ($f['prix'] ?? 0) > 0 ? number_format($f['prix'], 0, ',', ' ') . ' TND' : '<span style="color:green">Gratuite</span>' ?></td>
                <td>
                    <?php
                    $badges = ['disponible'=>'badge-green','bientot'=>'badge-blue','archive'=>'badge-grey'];
                    $labels = ['disponible'=>'Disponible','bientot'=>'Bientôt','archive'=>'Archivée'];
                    $s = $f['statut'] ?? 'bientot';
                    ?>
                    <span class="badge <?= $badges[$s] ?? 'badge-grey' ?>"><?= $labels[$s] ?? $s ?></span>
                </td>
                <td style="display:flex;gap:.5rem">
                    <a href="<?= base_url('admin/formations/' . $f['id'] . '/edit') ?>" class="btn btn-secondary btn-sm">Modifier</a>
                    <form action="<?= base_url('admin/formations/' . $f['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Supprimer cette formation ?')">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($formations)): ?>
            <tr><td colspan="6" style="text-align:center;color:#999;padding:2rem">Aucune formation</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
