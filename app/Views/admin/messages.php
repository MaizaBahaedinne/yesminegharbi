<div class="card">
    <div class="card-header">
        <span><?= count($messages) ?> message(s)</span>
    </div>
    <table>
        <thead>
            <tr><th>Nom</th><th>Email</th><th>Sujet</th><th>Message</th><th>Date</th><th>Action</th></tr>
        </thead>
        <tbody>
        <?php foreach ($messages as $m): ?>
            <tr>
                <td><strong><?= esc($m['nom']) ?></strong></td>
                <td style="font-size:.85rem;color:#666"><?= esc($m['email']) ?></td>
                <td><?= esc($m['sujet'] ?? '—') ?></td>
                <td style="max-width:220px;font-size:.85rem;color:#666;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                    <?= esc(substr($m['message'] ?? '', 0, 80)) ?>…
                </td>
                <td style="color:#999;font-size:.85rem;white-space:nowrap"><?= date('d/m/Y H:i', strtotime($m['created_at'])) ?></td>
                <td>
                    <form action="<?= base_url('admin/messages/' . $m['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Supprimer ce message ?')">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($messages)): ?>
            <tr><td colspan="6" style="text-align:center;color:#999;padding:2rem">Aucun message</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
