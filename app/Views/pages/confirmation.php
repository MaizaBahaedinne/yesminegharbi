<?php
// app/Views/pages/confirmation.php
?>
<section class="section" style="background:#fff;min-height:60vh;display:flex;align-items:center">
    <div class="container" style="text-align:center;max-width:600px">
        <div style="font-size:4rem;margin-bottom:1.5rem">✅</div>
        <h1 style="font-family:'Playfair Display',serif;margin-bottom:1rem">Message envoyé !</h1>
        <p style="color:var(--gris);font-size:1.1rem;line-height:1.7;margin-bottom:2rem">
            Merci pour votre message. Je vous répondrai dans les plus brefs délais, généralement sous 24-48 heures.
        </p>
        <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap">
            <a href="<?= base_url('/') ?>" class="btn-primary">Retour à l'accueil</a>
            <a href="<?= base_url('formations') ?>" class="btn-secondary">Voir les formations</a>
        </div>
    </div>
</section>
