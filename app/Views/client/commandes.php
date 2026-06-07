<?php
// app/Views/client/commandes.php
?>
<section class="page-header" style="background:var(--noir)">
    <div class="container">
        <h1>Mes commandes</h1>
    </div>
</section>

<section class="section" style="background:var(--beige)">
    <div class="container" style="display:grid;grid-template-columns:240px 1fr;gap:2rem;align-items:start">

        <nav style="background:#fff;border-radius:16px;padding:1.5rem;box-shadow:0 4px 16px rgba(0,0,0,.06)">
            <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:.25rem">
                <li><a href="<?= base_url('mon-compte') ?>" style="display:block;padding:.75rem 1rem;border-radius:10px;color:var(--gris)">Tableau de bord</a></li>
                <li><a href="<?= base_url('mon-compte/commandes') ?>" style="display:block;padding:.75rem 1rem;border-radius:10px;color:var(--rouge);background:var(--rouge-light);font-weight:600">Mes commandes</a></li>
                <li><a href="<?= base_url('deconnexion') ?>" style="display:block;padding:.75rem 1rem;border-radius:10px;color:var(--gris)">Se déconnecter</a></li>
            </ul>
        </nav>

        <div style="background:#fff;border-radius:16px;padding:2rem;box-shadow:0 4px 16px rgba(0,0,0,.06)">
            <h2 style="font-family:'Playfair Display',serif;margin-bottom:1.5rem;font-size:1.4rem">Mes commandes</h2>
            <p style="color:var(--gris);text-align:center;padding:3rem 0">Vous n'avez pas encore de commandes.</p>
        </div>

    </div>
</section>
