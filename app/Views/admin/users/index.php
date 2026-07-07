<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title">Utilisateurs enregistrés</h2>
        <a href="<?= base_url('admin') ?>" class="admin-btn admin-btn-outline">← Retour</a>
    </div>
    <div style="padding:1.25rem 1.5rem">
        <?php if (empty($users)): ?>
            <div class="admin-empty">Aucun utilisateur pour le moment.</div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Date naissance</th>
                        <th>Statut</th>
                        <th>Créé le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= esc(trim(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')) ?: '—') ?></td>
                            <td><?= esc($user['email'] ?? '') ?></td>
                            <td><?= esc($user['date_naissance'] ?? '—') ?></td>
                            <td>
                                <span class="badge <?= !empty($user['is_active']) ? 'badge-green' : 'badge-grey' ?>">
                                    <?= !empty($user['is_active']) ? 'Actif' : 'Inactif' ?>
                                </span>
                            </td>
                            <td><?= esc($user['created_at'] ?? '—') ?></td>
                            <td>
                                <form action="<?= base_url('admin/users/' . $user['id'] . '/toggle') ?>" method="post" style="display:inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="admin-btn admin-btn-outline admin-btn-xs">
                                        <?= !empty($user['is_active']) ? 'Désactiver' : 'Activer' ?>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
