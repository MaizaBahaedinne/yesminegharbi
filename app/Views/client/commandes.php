<?php
// app/Views/client/commandes.php
?>
<section class="page-header" style="background:var(--noir)">
    <div class="container">
        <h1 style="color:#fff">Mes commandes</h1>
    </div>
</section>

<section class="section" style="background:var(--beige)">
    <div class="container" style="max-width:960px;margin:0 auto">
        <div style="background:#fff;border-radius:16px;padding:2rem;box-shadow:0 4px 16px rgba(0,0,0,.06)">
            <h2 style="font-family:'Playfair Display',serif;margin-bottom:1.5rem;font-size:1.4rem">Mes commandes</h2>
            <?php if (empty($resources)): ?>
                <p style="color:var(--gris);text-align:center;padding:3rem 0">Vous n'avez pas encore de commandes.</p>
            <?php else: ?>
                <ul style="list-style:none;padding:0;margin:0;display:grid;gap:1rem">
                    <?php foreach ($resources as $resource): ?>
                        <li style="border:1px solid #eee;border-radius:12px;padding:1rem 1.1rem;display:flex;justify-content:space-between;align-items:center;gap:1rem">
                            <div>
                                <strong><?= esc($resource['titre'] ?? '') ?></strong>
                                <?php
                                    $rid = (int) ($resource['id'] ?? 0);
                                    $paidTotal = (float) (($orderTotalsByResource[$rid] ?? null) ?? 0);
                                    $defaultPrice = (float) ($resource['prix'] ?? 0);
                                    $displayPrice = array_key_exists($rid, $orderTotalsByResource ?? []) ? $paidTotal : $defaultPrice;
                                ?>
                                <div style="color:var(--gris);font-size:.9rem;margin-top:.25rem">
                                    Prix: <?= $displayPrice > 0 ? number_format($displayPrice, 0, ',', ' ') . ' TND' : 'Gratuit' ?>
                                </div>
                            </div>
                            <a href="<?= site_url('ressources/' . ($resource['slug'] ?? '')) ?>" class="btn-primary" style="display:inline-flex">Consulter</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</section>
