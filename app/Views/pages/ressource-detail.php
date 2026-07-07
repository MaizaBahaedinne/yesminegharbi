<?php
// app/Views/pages/ressource-detail.php
/** @var array $ressource */

$iconesType = [
    'checklist' => '<i class="fa-solid fa-clipboard-list" aria-hidden="true"></i>',
    'template'  => '<i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>',
    'ebook'     => '<i class="fa-solid fa-lightbulb" aria-hidden="true"></i>',
    'guide'     => '<i class="fa-solid fa-chart-column" aria-hidden="true"></i>',
    'kit'       => '<i class="fa-solid fa-bullseye" aria-hidden="true"></i>',
];
$labelProfil = [
    'junior'       => 'Junior',
    'experimente'  => 'Expérimenté',
    'recruteur'    => 'Recruteur',
    'tous'         => 'Tous profils',
];
$isFree = !(bool)($ressource['is_premium'] ?? false);
?>

<!-- ENTETE RESSOURCE -->
<section class="page-header formation-header">
  <div class="formation-header-inner">
    <div class="formation-header-left">

      <div class="breadcrumb" role="navigation" aria-label="Fil d'Ariane">
        <a href="<?= site_url($isFree ? 'ressources-gratuites' : 'ressources-premium') ?>">Ressources</a>
        <span>›</span>
        <span><?= esc($ressource['titre']) ?></span>
      </div>

      <div class="formation-badges" style="margin:16px 0 20px">
        <?php if (!empty($ressource['type'])): ?>
          <span class="badge-theme"><?= $iconesType[$ressource['type']] ?? '<i class="fa-solid fa-file-lines" aria-hidden="true"></i>' ?> <?= esc(ucfirst($ressource['type'])) ?></span>
        <?php endif; ?>
        <?php if (!empty($ressource['profil'])): ?>
          <span class="badge-niveau"><?= esc($labelProfil[$ressource['profil']] ?? ucfirst($ressource['profil'])) ?></span>
        <?php endif; ?>
        <?php if ($isFree): ?>
          <span class="badge-statut-dispo"><i class="fa-solid fa-circle-check" aria-hidden="true"></i> Gratuit</span>
        <?php else: ?>
          <span style="background:var(--or);color:#fff;font-size:12px;font-weight:600;padding:5px 12px;border-radius:20px"><i class="fa-solid fa-star" aria-hidden="true"></i> Premium</span>
        <?php endif; ?>
      </div>

      <h1 style="color:#fff"><?= esc($ressource['titre']) ?></h1>

      <?php if (!empty($ressource['description_courte'])): ?>
        <p class="formation-header-sub"><?= esc($ressource['description_courte']) ?></p>
      <?php endif; ?>

      <div style="display:flex;gap:.75rem;flex-wrap:wrap;margin-top:1rem">
        <span style="background:rgba(255,255,255,.16);color:#fff;font-size:.82rem;font-weight:600;padding:.45rem .75rem;border-radius:999px">
          <i class="fa-solid fa-eye" aria-hidden="true"></i> <?= (int) ($ressource['view_count'] ?? 0) ?> vues
        </span>
        <span style="background:rgba(255,255,255,.16);color:#fff;font-size:.82rem;font-weight:600;padding:.45rem .75rem;border-radius:999px">
          <i class="fa-solid fa-download" aria-hidden="true"></i> <?= (int) ($ressource['download_count'] ?? 0) ?> téléchargements
        </span>
      </div>

    </div>
  </div>
</section>

<!-- CORPS -->
<section class="section" style="background:#fff">
  <div class="formation-detail-grid">

    <!-- Colonne gauche -->
    <div class="formation-detail-content">

      <?php if (!empty($ressource['description_longue'])): ?>
        <div class="prose" style="line-height:1.85;color:var(--gris);margin-bottom:2rem">
          <?= $ressource['description_longue'] ?>
        </div>
      <?php elseif (!empty($ressource['description_courte'])): ?>
        <div class="prose" style="line-height:1.85;color:var(--gris);margin-bottom:2rem">
          <p><?= esc($ressource['description_courte']) ?></p>
        </div>
      <?php endif; ?>

      <?php if (!empty($ressource['profil']) && $ressource['profil'] !== 'tous'): ?>
        <div style="margin-top:1.5rem;padding:1.5rem;background:var(--beige);border-radius:16px">
          <h3 style="font-family:'Playfair Display',serif;margin-bottom:.75rem;font-size:1.1rem;color:var(--noir)">Pour qui ?</h3>
          <p style="color:var(--gris);margin:0"><?= esc($labelProfil[$ressource['profil']] ?? ucfirst($ressource['profil'])) ?></p>
        </div>
      <?php endif; ?>

    </div>

    <!-- Colonne droite : CTA -->
    <aside class="formation-detail-aside">
      <div class="formation-cta-card">

        <?php if ($isFree): ?>
          <div style="text-align:center;margin-bottom:1.25rem">
            <span style="background:var(--sauge-light);color:var(--sauge);padding:.5rem 1.25rem;border-radius:100px;font-size:.9rem;font-weight:600"><i class="fa-solid fa-circle-check" aria-hidden="true"></i> Gratuit</span>
          </div>
          <?php if (!empty($isLoggedIn) && !empty($hasAccess)): ?>
            <span style="display:block;text-align:center;font-weight:700;color:var(--sauge);margin-bottom:.75rem"><i class="fa-solid fa-circle-check" aria-hidden="true"></i> Déjà commandé</span>
            <a href="<?= site_url('ressources/download/request-code/' . ($ressource['slug'] ?? '')) ?>" class="btn-primary" style="display:block;width:100%;text-align:center;padding:1rem 1.5rem;font-size:1rem">
              Vérifier et télécharger
            </a>
          <?php elseif (!empty($isLoggedIn)): ?>
            <button type="button" class="btn-primary resource-claim-btn"
                    data-id="<?= (int)$ressource['id'] ?>"
                    data-slug="<?= esc($ressource['slug'] ?? '') ?>"
                    style="display:block;width:100%;text-align:center;padding:1rem 1.5rem;font-size:1rem">
              Passer la commande
            </button>
            <p style="font-size:.8rem;color:var(--gris);text-align:center;margin-top:.75rem">
              Vérification de votre compte puis téléchargement immédiat.
            </p>
          <?php else: ?>
            <button class="btn-primary open-download"
                    data-id="<?= (int)$ressource['id'] ?>"
                    data-titre="<?= esc($ressource['titre']) ?>"
                    style="display:block;width:100%;text-align:center;padding:1rem 1.5rem;font-size:1rem">
              Télécharger gratuitement
            </button>
            <p style="font-size:.8rem;color:var(--gris);text-align:center;margin-top:.75rem">
              Entrez votre email pour recevoir le fichier
            </p>
          <?php endif; ?>

        <?php else: ?>
          <?php if (!empty($ressource['prix']) && (float)$ressource['prix'] > 0): ?>
            <div class="cta-price"><?= number_format((float)$ressource['prix'], 0, ',', ' ') ?> TND</div>
          <?php endif; ?>
          <div class="cta-meta-row"><span><i class="fa-solid fa-circle-check" aria-hidden="true"></i></span> Compte connecté et vérifié requis</div>
          <div class="cta-meta-row"><span><i class="fa-solid fa-tags" aria-hidden="true"></i></span> Code promo pris en charge</div>
          <div class="cta-meta-row"><span><i class="fa-solid fa-download" aria-hidden="true"></i></span> Téléchargement immédiat</div>
          <div class="cta-meta-row"><span><i class="fa-solid fa-mobile-screen-button" aria-hidden="true"></i></span> Accès sur tous les appareils</div>
          <div class="cta-meta-row"><span><i class="fa-solid fa-infinity" aria-hidden="true"></i></span> Accès à vie</div>
          <?php if (!empty($isLoggedIn) && !empty($hasAccess)): ?>
            <span style="display:block;text-align:center;font-weight:700;color:var(--sauge);margin:.9rem 0 .75rem"><i class="fa-solid fa-circle-check" aria-hidden="true"></i> Déjà acheté</span>
            <?php if (!empty($ressource['fichier_path'])): ?>
              <a href="<?= site_url('ressources/download/request-code/' . ($ressource['slug'] ?? '')) ?>"
                 class="btn-primary" style="display:block;text-align:center;margin-top:1.5rem;padding:1rem 1.5rem;font-size:1rem">
                Vérifier et télécharger
              </a>
            <?php else: ?>
              <a href="<?= site_url('mon-compte/commandes') ?>"
                 class="btn-primary" style="display:block;text-align:center;margin-top:1.5rem;padding:1rem 1.5rem;font-size:1rem">
                Voir mes commandes
              </a>
            <?php endif; ?>
          <?php else: ?>
            <a href="<?= site_url('ressources/acheter/' . ($ressource['slug'] ?? '')) ?>"
               class="btn-primary" style="display:block;text-align:center;margin-top:1.5rem;padding:1rem 1.5rem;font-size:1rem">
              Commencer l'achat
            </a>
          <?php endif; ?>
        <?php endif; ?>

        <p style="font-size:.8rem;color:var(--gris);text-align:center;margin-top:.75rem">
          Questions ? <a href="<?= site_url('contact') ?>" style="color:var(--rouge)">Contactez-moi</a>
        </p>
      </div>
    </aside>

  </div>
</section>
