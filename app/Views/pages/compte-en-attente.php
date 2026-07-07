<?php
// app/Views/pages/compte-en-attente.php
?>
<section class="section" style="background:var(--beige);min-height:70vh;display:flex;align-items:center;justify-content:center">
    <div class="container" style="max-width:640px">
        <div style="background:#fff;border-radius:24px;padding:3rem;box-shadow:0 8px 32px rgba(0,0,0,.08)">
            <h1 style="font-family:'Playfair Display',serif;margin-bottom:.75rem;font-size:1.75rem">Vérifiez votre compte</h1>
            <p style="color:var(--gris);margin-bottom:1.5rem;line-height:1.7">
                Votre compte existe bien, mais il doit encore être vérifié avant que vous puissiez accéder à votre espace client.
            </p>

            <div style="background:var(--beige);border:1px solid #e8ddcf;border-radius:16px;padding:1.25rem 1.4rem;margin-bottom:1.5rem">
                <strong>Adresse utilisée :</strong> <?= esc($email ?? '') ?>
            </div>

            <h2 style="font-size:1.1rem;margin-bottom:.75rem">Comment vérifier votre profil ?</h2>
            <ol style="padding-left:1.2rem;color:var(--gris);line-height:1.8">
                <li>Ouvrez votre boîte mail et récupérez votre code à 6 chiffres.</li>
                <li>Entrez ce code sur la page de vérification.</li>
                <li>Créez votre mot de passe pour finaliser l’activation du compte.</li>
            </ol>

            <div style="margin-top:1.8rem;display:flex;gap:1rem;flex-wrap:wrap">
                <a href="<?= base_url('verification-compte?email=' . rawurlencode($email ?? '')) ?>" class="btn-primary">Saisir mon code</a>
                <a href="<?= base_url('connexion') ?>" class="btn-primary">Retour à la connexion</a>
                <a href="<?= base_url('/') ?>" class="btn-secondary">Retour à l’accueil</a>
            </div>
        </div>
    </div>
</section>
