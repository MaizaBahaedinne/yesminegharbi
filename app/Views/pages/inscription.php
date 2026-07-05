<?php
// app/Views/pages/inscription.php
?>
<section class="section" style="background:var(--beige);min-height:70vh;display:flex;align-items:center">
    <div class="container" style="max-width:480px">
        <div style="background:#fff;border-radius:24px;padding:3rem;box-shadow:0 8px 32px rgba(0,0,0,.08)">
            <h1 style="font-family:'Playfair Display',serif;margin-bottom:.5rem;font-size:1.75rem">Créer un compte</h1>
            <p style="color:var(--gris);margin-bottom:2rem;font-size:.95rem">Accédez à votre espace et vos ressources</p>

            <form action="<?= base_url('inscription') ?>" method="post">
                <?= csrf_field() ?>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                    <div class="form-group">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" id="prenom" name="prenom" class="form-control" required placeholder="Votre prénom">
                    </div>
                    <div class="form-group">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" id="nom" name="nom" class="form-control" required placeholder="Votre nom">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required placeholder="votre@email.com">
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form-control" required placeholder="Minimum 8 caractères">
                </div>
                <button type="submit" class="btn-primary" style="width:100%;padding:.875rem;margin-top:.5rem">Créer mon compte</button>
            </form>

            <p style="text-align:center;margin-top:1.5rem;color:var(--gris);font-size:.9rem">
                Déjà un compte ?
                <a href="<?= base_url('connexion') ?>" style="color:var(--rouge);font-weight:600">Se connecter</a>
            </p>
        </div>
    </div>
</section>
