<?php
// app/Views/pages/inscription.php
?>
<section class="section" style="background:var(--beige);min-height:70vh;display:flex;align-items:center;justify-content:center">
    <div class="container" style="max-width:480px">
        <div style="background:#fff;border-radius:24px;padding:3rem;box-shadow:0 8px 32px rgba(0,0,0,.08)">
            <h1 style="font-family:'Playfair Display',serif;margin-bottom:.5rem;font-size:1.75rem">Créer un compte</h1>
            <p style="color:var(--gris);margin-bottom:2rem;font-size:.95rem">Accédez à votre espace et vos ressources</p>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success" style="margin-bottom:1rem"><?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error" style="margin-bottom:1rem"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>

            <form action="<?= base_url('inscription') ?>" method="post">
                <?= csrf_field() ?>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                    <div class="form-group">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" id="prenom" name="prenom" class="form-control" required placeholder="Votre prénom" value="<?= esc(old('prenom')) ?>">
                    </div>
                    <div class="form-group">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" id="nom" name="nom" class="form-control" required placeholder="Votre nom" value="<?= esc(old('nom')) ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="date_naissance" class="form-label">Date de naissance</label>
                    <input type="date" id="date_naissance" name="date_naissance" class="form-control" required value="<?= esc(old('date_naissance')) ?>">
                </div>
                <div class="form-group">
                    <label for="situation_actuelle" class="form-label">Situation actuelle</label>
                    <?php $oldSituation = (string) old('situation_actuelle'); ?>
                    <select id="situation_actuelle" name="situation_actuelle" class="form-control" required>
                        <option value="">Choisissez votre situation</option>
                        <option value="Etudiant(e)" <?= $oldSituation === 'Etudiant(e)' ? 'selected' : '' ?>>Etudiant(e)</option>
                        <option value="Salarie" <?= $oldSituation === 'Salarie' ? 'selected' : '' ?>>Salarier</option>
                        <option value="Chef d'entreprise" <?= $oldSituation === "Chef d'entreprise" ? 'selected' : '' ?>>Chef d'entreprise</option>
                        <option value="Freelance" <?= $oldSituation === 'Freelance' ? 'selected' : '' ?>>Freelance</option>
                        <option value="A la recherche d'une nouvelle opportunite" <?= $oldSituation === "A la recherche d'une nouvelle opportunite" ? 'selected' : '' ?>>A la recherche d'une nouvelle opportunite</option>
                        <option value="Recruteur" <?= $oldSituation === 'Recruteur' ? 'selected' : '' ?>>Recruteur</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required placeholder="votre@email.com" value="<?= esc(old('email')) ?>">
                </div>
                <button type="submit" class="btn-primary" style="width:100%;padding:.875rem;margin-top:.5rem">Continuer</button>
                <p style="font-size:12px;color:var(--gris);margin-top:10px;text-align:center">Un code de vérification à 6 chiffres vous sera envoyé par email.</p>
            </form>

            <p style="text-align:center;margin-top:1.5rem;color:var(--gris);font-size:.9rem">
                Déjà un compte ?
                <a href="<?= base_url('connexion') ?>" style="color:var(--rouge);font-weight:600">Se connecter</a>
            </p>
        </div>
    </div>
</section>
