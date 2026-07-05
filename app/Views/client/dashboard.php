<?php
// app/Views/client/dashboard.php
?>
<section class="page-header" style="background:var(--noir)">
    <div class="container">
        <h1>Mon compte</h1>
        <p style="color:#ccc">Bonjour <?= esc($user['prenom'] ?? 'utilisateur') ?> 👋</p>
    </div>
</section>

<section class="section" style="background:var(--beige)">
    <div class="container" style="display:grid;grid-template-columns:240px 1fr;gap:2rem;align-items:start">

        <!-- Sidebar nav -->
        <nav style="background:#fff;border-radius:16px;padding:1.5rem;box-shadow:0 4px 16px rgba(0,0,0,.06)">
            <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:.25rem">
                <li><a href="<?= base_url('mon-compte') ?>" style="display:block;padding:.75rem 1rem;border-radius:10px;color:var(--noir);font-weight:600;background:var(--rouge-light);color:var(--rouge)">Tableau de bord</a></li>
                <li><a href="<?= base_url('mon-compte/commandes') ?>" style="display:block;padding:.75rem 1rem;border-radius:10px;color:var(--gris)">Mes commandes</a></li>
                <li><a href="<?= base_url('deconnexion') ?>" style="display:block;padding:.75rem 1rem;border-radius:10px;color:var(--gris)">Se déconnecter</a></li>
            </ul>
        </nav>

        <!-- Content -->
        <div>
            <div style="background:#fff;border-radius:16px;padding:2rem;box-shadow:0 4px 16px rgba(0,0,0,.06)">
                <h2 style="font-family:'Playfair Display',serif;margin-bottom:1.5rem;font-size:1.4rem">Tableau de bord</h2>
                <p style="color:var(--gris)">Bienvenue dans votre espace client. Vous pouvez consulter vos commandes et accéder à vos ressources achetées.</p>
                <a href="<?= base_url('formations') ?>" class="btn-primary" style="margin-top:1.5rem;display:inline-block">Voir les formations</a>
            </div>
        </div>

    </div>
</section>
