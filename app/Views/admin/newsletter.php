<div class="card">
    <div class="card-header">
        <span><?= count($abonnes) ?> abonné(s)</span>
        <?php if (!empty($abonnes)): ?>
            <a href="data:text/csv;charset=utf-8,Prénom,Email,Tag,Date<?php foreach ($abonnes as $a): echo urlencode("\n" . $a['prenom'] . ',' . $a['email'] . ',' . ($a['tag'] ?? '') . ',' . $a['created_at']); endforeach; ?>" download="newsletter.csv" class="btn btn-secondary btn-sm"><i class="fa-solid fa-download" aria-hidden="true"></i> Exporter CSV</a>
        <?php endif; ?>
    </div>
    <table>
        <thead>
            <tr><th>Prénom</th><th>Email</th><th>Tag</th><th>Date</th><th>Action</th></tr>
        </thead>
        <tbody>
        <?php foreach ($abonnes as $a): ?>
            <tr>
                <td><?= esc($a['prenom'] ?? '—') ?></td>
                <td><?= esc($a['email']) ?></td>
                <td><?= $a['tag'] ? '<span class="badge badge-blue">' . esc($a['tag']) . '</span>' : '—' ?></td>
                <td style="color:#999;font-size:.85rem"><?= date('d/m/Y', strtotime($a['created_at'])) ?></td>
                <td>
                    <form action="<?= base_url('admin/newsletter/' . $a['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Supprimer cet abonné ?')">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($abonnes)): ?>
            <tr><td colspan="5" style="text-align:center;color:#999;padding:2rem">Aucun abonné</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
