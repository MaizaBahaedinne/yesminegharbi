<?php $testimonials = $testimonials ?? []; ?>

<?php if (session()->getFlashdata('success')): ?>
<div style="background:#e6f4ea;border:1px solid #a8d5b0;color:#1a7a34;padding:12px 18px;border-radius:8px;margin-bottom:20px;font-size:14px">
    ✅ <?= esc(session()->getFlashdata('success')) ?>
</div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div style="background:#fff1ec;border:1px solid #f8c3b5;color:#bf2c00;padding:12px 18px;border-radius:8px;margin-bottom:20px;font-size:14px">
    ⚠️ <?= esc(session()->getFlashdata('error')) ?>
</div>
<?php endif; ?>

<div class="card" style="padding:1.5rem;">
    <div class="card-header" style="display:flex;align-items:center;justify-content:space-between;">
        <span>Témoignages</span>
        <a href="<?= base_url('admin/testimonials/new') ?>" class="btn btn-primary btn-sm">+ Ajouter</a>
    </div>
    <div style="padding:1rem 0">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Auteur</th>
                    <th>Texte</th>
                    <th>Actif</th>
                    <th>Ordre</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($testimonials)): ?>
                    <tr><td colspan="6" style="text-align:center;color:#999;padding:2rem">Aucun témoignage trouvé.</td></tr>
                <?php else: ?>
                    <?php foreach ($testimonials as $testimonial): ?>
                        <tr>
                            <td><?= esc($testimonial['id']) ?></td>
                            <td>
                                <strong><?= esc($testimonial['author_name']) ?></strong><br>
                                <span style="color:#666;font-size:.85rem"><?= esc($testimonial['author_role']) ?></span>
                            </td>
                            <td style="max-width:420px; white-space:pre-wrap; word-wrap:break-word"><?= esc($testimonial['quote']) ?></td>
                            <td><?= $testimonial['is_active'] ? 'Oui' : 'Non' ?></td>
                            <td><?= esc($testimonial['sort_order']) ?></td>
                            <td style="display:flex;gap:.5rem">
                                <a href="<?= base_url('admin/testimonials/' . $testimonial['id'] . '/edit') ?>" class="btn btn-secondary btn-sm">Modifier</a>
                                <form action="<?= base_url('admin/testimonials/' . $testimonial['id'] . '/delete') ?>" method="post" style="display:inline" onsubmit="return confirm('Supprimer ce témoignage ?');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
