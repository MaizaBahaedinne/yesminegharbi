<div class="stat-grid">
    <div class="stat-card">
        <div class="icon"><i class="fa-solid fa-graduation-cap" aria-hidden="true"></i></div>
        <div class="num"><?= $nb_formations ?></div>
        <div class="label">Formations</div>
    </div>
    <div class="stat-card">
        <div class="icon"><i class="fa-solid fa-file-lines" aria-hidden="true"></i></div>
        <div class="num"><?= $nb_ressources ?></div>
        <div class="label">Ressources</div>
    </div>
    <div class="stat-card">
        <div class="icon"><i class="fa-solid fa-envelope" aria-hidden="true"></i></div>
        <div class="num"><?= $nb_abonnes ?></div>
        <div class="label">Abonnés newsletter</div>
    </div>
    <div class="stat-card">
        <div class="icon"><i class="fa-solid fa-comments" aria-hidden="true"></i></div>
        <div class="num"><?= $nb_messages ?></div>
        <div class="label">Messages reçus</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem">

    <div class="card">
        <div class="card-header">
            <span>Derniers messages</span>
            <a href="<?= base_url('admin/messages') ?>" class="btn btn-secondary btn-sm">Voir tout</a>
        </div>
        <table>
            <thead><tr><th>Nom</th><th>Sujet</th><th>Date</th></tr></thead>
            <tbody>
            <?php foreach ($last_messages as $m): ?>
                <tr>
                    <td><?= esc($m['nom']) ?></td>
                    <td style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap"><?= esc($m['sujet'] ?? '—') ?></td>
                    <td style="color:#999;font-size:.8rem"><?= date('d/m', strtotime($m['created_at'])) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($last_messages)): ?>
                <tr><td colspan="3" style="text-align:center;color:#999;padding:2rem">Aucun message</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="card">
        <div class="card-header">
            <span>Derniers abonnés</span>
            <a href="<?= base_url('admin/newsletter') ?>" class="btn btn-secondary btn-sm">Voir tout</a>
        </div>
        <table>
            <thead><tr><th>Prénom</th><th>Email</th><th>Date</th></tr></thead>
            <tbody>
            <?php foreach ($last_abonnes as $a): ?>
                <tr>
                    <td><?= esc($a['prenom'] ?? '—') ?></td>
                    <td style="font-size:.85rem;color:#666"><?= esc($a['email']) ?></td>
                    <td style="color:#999;font-size:.8rem"><?= date('d/m', strtotime($a['created_at'])) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($last_abonnes)): ?>
                <tr><td colspan="3" style="text-align:center;color:#999;padding:2rem">Aucun abonné</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
