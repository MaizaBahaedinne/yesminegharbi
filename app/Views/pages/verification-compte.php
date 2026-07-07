<?php
// app/Views/pages/verification-compte.php
?>
<section class="section" style="background:var(--beige);min-height:70vh;display:flex;align-items:center;justify-content:center">
    <div class="container" style="max-width:560px">
        <div style="background:#fff;border-radius:24px;padding:3rem;box-shadow:0 8px 32px rgba(0,0,0,.08)">
            <h1 style="font-family:'Playfair Display',serif;margin-bottom:.75rem;font-size:1.75rem">Valider votre compte</h1>
            <p style="color:var(--gris);margin-bottom:1.5rem;line-height:1.7">
                Entrez le code à 6 chiffres reçu par email pour continuer.
            </p>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error" style="margin-bottom:1rem"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success" style="margin-bottom:1rem"><?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif; ?>

            <form action="<?= base_url('verification-compte') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="verify_email" class="form-label">Email</label>
                    <input type="email" id="verify_email" name="email" class="form-control" required placeholder="votre@email.com" value="<?= esc(old('email') ?: ($email ?? '')) ?>">
                </div>
                <div class="form-group">
                    <label for="verify_code" class="form-label">Code de vérification (6 chiffres)</label>
                    <input type="text" id="verify_code" name="code" class="form-control" required maxlength="6" pattern="[0-9]{6}" placeholder="123456" value="<?= esc(old('code')) ?>">
                </div>
                <button type="submit" class="btn-primary" style="width:100%;padding:.875rem;margin-top:.5rem">Valider le code</button>
            </form>

            <p style="text-align:center;margin-top:1.5rem;color:var(--gris);font-size:.9rem">
                <a href="<?= base_url('connexion') ?>" style="color:var(--rouge);font-weight:600">Retour à la connexion</a>
            </p>
        </div>
    </div>
</section>
