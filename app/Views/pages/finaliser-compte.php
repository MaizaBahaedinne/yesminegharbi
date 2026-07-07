<?php
// app/Views/pages/finaliser-compte.php
?>
<section class="section" style="background:var(--beige);min-height:70vh;display:flex;align-items:center;justify-content:center">
    <div class="container" style="max-width:560px">
        <div style="background:#fff;border-radius:24px;padding:3rem;box-shadow:0 8px 32px rgba(0,0,0,.08)">
            <h1 style="font-family:'Playfair Display',serif;margin-bottom:.75rem;font-size:1.75rem">Créer votre mot de passe</h1>
            <p style="color:var(--gris);margin-bottom:1.5rem;line-height:1.7">
                Votre code est validé. Définissez maintenant votre mot de passe pour activer le compte.
            </p>

            <?php if (! empty($email)): ?>
                <div style="background:var(--beige);border:1px solid #e8ddcf;border-radius:16px;padding:1.25rem 1.4rem;margin-bottom:1.5rem">
                    <strong>Compte :</strong> <?= esc($email) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error" style="margin-bottom:1rem"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>

            <form action="<?= base_url('finaliser-compte') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form-control" required placeholder="Au moins 8 caractères">
                </div>
                <div class="form-group">
                    <label for="password_confirm" class="form-label">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirm" name="password_confirm" class="form-control" required placeholder="Retapez le mot de passe">
                </div>
                <button type="submit" class="btn-primary" style="width:100%;padding:.875rem;margin-top:.5rem">Activer mon compte</button>
            </form>
        </div>
    </div>
</section>
