<?php
// app/Views/pages/reinitialiser-mot-de-passe.php
?>
<section class="section" style="background:var(--beige);min-height:70vh;display:flex;align-items:center;justify-content:center">
    <div class="container" style="max-width:560px">
        <div style="background:#fff;border-radius:24px;padding:3rem;box-shadow:0 8px 32px rgba(0,0,0,.08)">
            <h1 style="font-family:'Playfair Display',serif;margin-bottom:.75rem;font-size:1.75rem">Nouveau mot de passe</h1>
            <p style="color:var(--gris);margin-bottom:1.5rem;line-height:1.7">Choisissez un nouveau mot de passe sécurisé pour votre compte.</p>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error" style="margin-bottom:1rem"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>

            <form action="<?= base_url('reinitialiser-mot-de-passe/' . (int) ($userId ?? 0) . '/' . ($token ?? '')) ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="password" class="form-label">Nouveau mot de passe</label>
                    <input type="password" id="password" name="password" class="form-control" required placeholder="Au moins 8 caractères">
                </div>
                <div class="form-group">
                    <label for="password_confirm" class="form-label">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirm" name="password_confirm" class="form-control" required placeholder="Retapez le mot de passe">
                </div>
                <button type="submit" class="btn-primary" style="width:100%;padding:.875rem;margin-top:.5rem">Enregistrer le nouveau mot de passe</button>
            </form>

            <p style="text-align:center;margin-top:1.5rem;color:var(--gris);font-size:.9rem">
                <a href="<?= base_url('connexion') ?>" style="color:var(--rouge);font-weight:600">Retour à la connexion</a>
            </p>
        </div>
    </div>
</section>
