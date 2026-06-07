<?php
// app/Views/pages/connexion.php
?>
<section class="section" style="background:var(--beige);min-height:70vh;display:flex;align-items:center">
    <div class="container" style="max-width:460px">
        <div style="background:#fff;border-radius:24px;padding:3rem;box-shadow:0 8px 32px rgba(0,0,0,.08)">
            <h1 style="font-family:'Playfair Display',serif;margin-bottom:.5rem;font-size:1.75rem">Connexion</h1>
            <p style="color:var(--gris);margin-bottom:2rem;font-size:.95rem">Accédez à votre espace client</p>

            <form action="<?= base_url('connexion') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required placeholder="votre@email.com">
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form-control" required placeholder="••••••••">
                </div>
                <button type="submit" class="btn-primary" style="width:100%;padding:.875rem;margin-top:.5rem">Se connecter</button>
            </form>

            <p style="text-align:center;margin-top:1.5rem;color:var(--gris);font-size:.9rem">
                Pas encore de compte ?
                <a href="<?= base_url('inscription') ?>" style="color:var(--rouge);font-weight:600">Créer un compte</a>
            </p>
        </div>
    </div>
</section>
