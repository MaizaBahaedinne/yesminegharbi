<?php
// app/Views/client/dashboard.php
?>
<section class="page-header" style="background:var(--noir)">
    <div class="container">
        <h1 style="color:#fff">Mon compte</h1>
        <p style="color:rgba(255,255,255,.85)">Bonjour <?= esc($user['prenom'] ?? 'utilisateur') ?> <i class="fa-solid fa-hand" aria-hidden="true"></i></p>
    </div>
</section>

<section class="section" style="background:var(--beige)">
    <div class="container" style="max-width:960px;margin:0 auto">
        <div>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success" style="margin-bottom:1rem"><?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error" style="margin-bottom:1rem"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>

            <div style="background:#fff;border-radius:16px;padding:2rem;box-shadow:0 4px 16px rgba(0,0,0,.06);margin-bottom:1.5rem">
                <h2 style="font-family:'Playfair Display',serif;margin-bottom:1.5rem;font-size:1.4rem">Gestion de mon profil</h2>

                <form action="<?= base_url('mon-compte/profil') ?>" method="post">
                    <?= csrf_field() ?>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                        <div class="form-group">
                            <label for="profil_prenom" class="form-label">Prénom</label>
                            <input type="text" id="profil_prenom" name="prenom" class="form-control" required value="<?= esc($profileUser['prenom'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="profil_nom" class="form-label">Nom</label>
                            <input type="text" id="profil_nom" name="nom" class="form-control" required value="<?= esc($profileUser['nom'] ?? '') ?>">
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                        <div class="form-group">
                            <label for="profil_date_naissance" class="form-label">Date de naissance</label>
                            <input type="date" id="profil_date_naissance" name="date_naissance" class="form-control" value="<?= esc($profileUser['date_naissance'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="profil_situation" class="form-label">Situation actuelle</label>
                            <?php $situation = (string) ($profileUser['situation_actuelle'] ?? ''); ?>
                            <select id="profil_situation" name="situation_actuelle" class="form-control">
                                <option value="">Choisissez votre situation</option>
                                <option value="Etudiant(e)" <?= $situation === 'Etudiant(e)' ? 'selected' : '' ?>>Etudiant(e)</option>
                                <option value="Salarie" <?= $situation === 'Salarie' ? 'selected' : '' ?>>Salarier</option>
                                <option value="Chef d'entreprise" <?= $situation === "Chef d'entreprise" ? 'selected' : '' ?>>Chef d'entreprise</option>
                                <option value="Freelance" <?= $situation === 'Freelance' ? 'selected' : '' ?>>Freelance</option>
                                <option value="A la recherche d'une nouvelle opportunite" <?= $situation === "A la recherche d'une nouvelle opportunite" ? 'selected' : '' ?>>A la recherche d'une nouvelle opportunite</option>
                                <option value="Recruteur" <?= $situation === 'Recruteur' ? 'selected' : '' ?>>Recruteur</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="profil_email" class="form-label">Email</label>
                        <input type="email" id="profil_email" class="form-control" value="<?= esc($profileUser['email'] ?? '') ?>" disabled>
                    </div>

                    <button type="submit" class="btn-primary" style="margin-top:.5rem">Mettre à jour mon profil</button>
                </form>
            </div>

            <div style="background:#fff;border-radius:16px;padding:2rem;box-shadow:0 4px 16px rgba(0,0,0,.06)">
                <h2 style="font-family:'Playfair Display',serif;margin-bottom:1.5rem;font-size:1.4rem">Changer mon mot de passe</h2>

                <form action="<?= base_url('mon-compte/mot-de-passe') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="current_password" class="form-label">Mot de passe actuel</label>
                        <input type="password" id="current_password" name="current_password" class="form-control" required>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                        <div class="form-group">
                            <label for="new_password" class="form-label">Nouveau mot de passe</label>
                            <input type="password" id="new_password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password_confirm" class="form-label">Confirmation</label>
                            <input type="password" id="new_password_confirm" name="password_confirm" class="form-control" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary" style="margin-top:.5rem">Mettre à jour mon mot de passe</button>
                </form>
            </div>
        </div>
    </div>
</section>
