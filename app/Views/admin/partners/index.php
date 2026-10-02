<div class="card">
    <div class="card-header">
        <span><?= count($partners) ?> partenaire(s)</span>
        <a href="<?= base_url('admin/partners/new') ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus" aria-hidden="true"></i> Ajouter un partenaire</a>
    </div>
    <table>
        <thead><tr><th>Partenaire</th><th>Reel Instagram</th><th>Position</th><th>Visibilité</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($partners as $partner): ?>
            <tr>
                <td style="display:flex;align-items:center;gap:12px;min-width:220px">
                    <img src="<?= base_url(esc($partner['logo'])) ?>" alt="" width="88" height="56" style="object-fit:contain;padding:6px;border:1px solid #eee;border-radius:6px;background:#fff">
                    <strong><?= esc($partner['nom']) ?></strong>
                </td>
                <td>
                    <?php if (!empty($partner['instagram_url'])): ?>
                        <a href="<?= esc($partner['instagram_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm"><i class="fa-brands fa-instagram" aria-hidden="true"></i> Voir le Reel</a>
                    <?php else: ?>—<?php endif; ?>
                </td>
                <td><?= (int) $partner['position'] ?></td>
                <td><span class="badge <?= $partner['is_active'] ? 'badge-green' : 'badge-grey' ?>"><?= $partner['is_active'] ? 'Affiché' : 'Masqué' ?></span></td>
                <td style="display:flex;gap:.5rem;align-items:center">
                    <a href="<?= base_url('admin/partners/' . $partner['id'] . '/edit') ?>" class="btn btn-secondary btn-sm">Modifier</a>
                    <form action="<?= base_url('admin/partners/' . $partner['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Supprimer ce partenaire ?')">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger btn-sm" aria-label="Supprimer"><i class="fa-solid fa-trash" aria-hidden="true"></i></button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$partners): ?><tr><td colspan="5" style="text-align:center;color:#999;padding:2rem">Aucun partenaire pour le moment.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
