<?php
// app/Views/pages/mot-de-passe-oublie.php
?>
<section class="section" style="background:var(--beige);min-height:70vh;display:flex;align-items:center;justify-content:center">
    <div class="container" style="max-width:560px">
        <div style="background:#fff;border-radius:24px;padding:3rem;box-shadow:0 8px 32px rgba(0,0,0,.08)">
            <h1 style="font-family:'Playfair Display',serif;margin-bottom:.75rem;font-size:1.75rem">Mot de passe oublié ?</h1>
            <p style="color:var(--gris);margin-bottom:1.5rem;line-height:1.7">Entrez votre email et nous vous enverrons un lien de réinitialisation.</p>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success" style="margin-bottom:1rem"><?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error" style="margin-bottom:1rem"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('debug_reset_url')): ?>
                <div class="alert alert-success" style="margin-bottom:1rem">
                    Lien de test (dev):
                    <a href="<?= esc(session()->getFlashdata('debug_reset_url')) ?>" style="color:var(--rouge);font-weight:600">Ouvrir le lien</a>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('mot-de-passe-oublie') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required placeholder="votre@email.com" value="<?= esc(old('email')) ?>">
                </div>
                <button type="submit" class="btn-primary" style="width:100%;padding:.875rem;margin-top:.5rem">Envoyer le lien</button>
            </form>

            <div style="display:flex;gap:1rem;flex-wrap:wrap">
                <a href="<?= base_url('connexion') ?>" class="btn-primary">Retour à la connexion</a>
                <a href="<?= base_url('/') ?>" class="btn-secondary">Retour à l’accueil</a>
            </div>
        </div>
    </div>
</section>
