<?php
/** @var array $ressource */
/** @var array $checkoutUser */
/** @var array $pricing */
/** @var array $promo */

$promoCodeValue = old('promo_code', $promoCode ?? '');
?>

<section class="page-header" style="background:var(--noir)">
  <div class="container">
    <h1 style="color:#fff">Finaliser mon achat</h1>
    <p style="color:#fff;opacity:.9;margin-top:.5rem">Validation de commande, code promo et paiement en ligne (simulation)</p>
  </div>
</section>

<section class="section" style="background:var(--beige)">
  <div class="container" style="max-width:980px;margin:0 auto;display:grid;grid-template-columns:1.1fr .9fr;gap:1.2rem;align-items:start">

    <div style="background:#fff;border-radius:16px;padding:1.25rem 1.25rem 1.4rem;box-shadow:0 4px 16px rgba(0,0,0,.06)">
      <div style="display:flex;gap:.5rem;flex-wrap:wrap;margin-bottom:1rem">
        <span style="padding:.35rem .65rem;border-radius:999px;background:var(--rouge-light);color:var(--rouge);font-weight:700;font-size:.78rem">1. Validation</span>
        <span style="padding:.35rem .65rem;border-radius:999px;background:#f4efe5;color:var(--gris);font-weight:700;font-size:.78rem">2. Code promo</span>
        <span style="padding:.35rem .65rem;border-radius:999px;background:#f4efe5;color:var(--gris);font-weight:700;font-size:.78rem">3. Paiement simulé</span>
      </div>

      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success" style="margin-bottom:1rem"><?= esc(session()->getFlashdata('success')) ?></div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error" style="margin-bottom:1rem"><?= esc(session()->getFlashdata('error')) ?></div>
      <?php endif; ?>

      <div style="border:1px solid #eee;border-radius:12px;padding:1rem;margin-bottom:1rem">
        <h3 style="font-family:'Playfair Display',serif;margin:0 0 .35rem;font-size:1.2rem"><?= esc($ressource['titre'] ?? '') ?></h3>
        <p style="color:var(--gris);margin:0"><?= esc($ressource['description_courte'] ?? '') ?></p>
      </div>

      <div style="border:1px solid #eee;border-radius:12px;padding:1rem;margin-bottom:1rem">
        <h4 style="margin:0 0 .6rem;font-size:1rem">Compte utilisé</h4>
        <p style="margin:0;color:var(--gris)">
          <?= esc(trim((string) (($checkoutUser['prenom'] ?? '') . ' ' . ($checkoutUser['nom'] ?? ''))) ?: ($checkoutUser['email'] ?? '')) ?>
          - <?= esc($checkoutUser['email'] ?? '') ?>
        </p>
      </div>

      <form action="<?= site_url('ressources/acheter/' . ($ressource['slug'] ?? '')) ?>" method="post" style="margin-bottom:1rem">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="apply_promo">
        <div class="form-group" style="margin-bottom:.6rem">
          <label for="promo_code">Code promo</label>
          <input type="text" id="promo_code" name="promo_code" class="form-input" placeholder="Ex: BIENVENUE10" value="<?= esc($promoCodeValue) ?>">
        </div>
        <button type="submit" class="btn-secondary" style="width:100%;justify-content:center">Appliquer le code promo</button>
      </form>

      <form action="<?= site_url('ressources/acheter/' . ($ressource['slug'] ?? '')) ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="pay">
        <input type="hidden" name="promo_code" value="<?= esc($promoCodeValue) ?>">

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.8rem">
          <div class="form-group">
            <label for="card_holder">Titulaire</label>
            <input type="text" id="card_holder" name="card_holder" class="form-input" placeholder="Nom du titulaire" value="<?= esc(old('card_holder')) ?>" required>
          </div>
          <div class="form-group">
            <label for="card_number">Carte (simulation)</label>
            <input type="text" id="card_number" name="card_number" class="form-input" inputmode="numeric" maxlength="19" placeholder="4242 4242 4242 4242" value="<?= esc(old('card_number')) ?>" required>
          </div>
          <div class="form-group">
            <label for="card_expiry">Expiration</label>
            <input type="text" id="card_expiry" name="card_expiry" class="form-input" maxlength="5" placeholder="MM/AA" value="<?= esc(old('card_expiry')) ?>" required>
          </div>
          <div class="form-group">
            <label for="card_cvv">CVV</label>
            <input type="password" id="card_cvv" name="card_cvv" class="form-input" inputmode="numeric" maxlength="4" placeholder="123" required>
          </div>
        </div>

        <label style="display:flex;align-items:flex-start;gap:.6rem;margin:.7rem 0 1rem;color:var(--gris)">
          <input type="checkbox" name="accept_terms" value="1" <?= old('accept_terms') ? 'checked' : '' ?> style="margin-top:.2rem">
          <span>Je confirme la commande et j'accepte les conditions de vente.</span>
        </label>

        <button type="submit" class="btn-primary" style="width:100%;justify-content:center">Payer maintenant (simulation)</button>
      </form>
    </div>

    <aside style="background:#fff;border-radius:16px;padding:1.25rem;box-shadow:0 4px 16px rgba(0,0,0,.06)">
      <h3 style="font-family:'Playfair Display',serif;margin:0 0 1rem;font-size:1.2rem">Récapitulatif</h3>
      <div style="display:flex;justify-content:space-between;margin-bottom:.5rem;color:var(--gris)">
        <span>Prix de base</span>
        <strong style="color:var(--noir)"><?= number_format((float) ($pricing['base'] ?? 0), 0, ',', ' ') ?> TND</strong>
      </div>
      <div style="display:flex;justify-content:space-between;margin-bottom:.5rem;color:var(--gris)">
        <span>Remise<?= !empty($promoCodeValue) ? ' (' . esc($promoCodeValue) . ')' : '' ?></span>
        <strong style="color:var(--sauge)">-<?= number_format((float) ($pricing['discount'] ?? 0), 0, ',', ' ') ?> TND</strong>
      </div>
      <hr style="border:none;border-top:1px solid #eee;margin:.8rem 0">
      <div style="display:flex;justify-content:space-between;align-items:center">
        <span style="font-size:1rem;font-weight:700">Total</span>
        <span style="font-size:1.25rem;font-weight:800;color:var(--rouge)"><?= number_format((float) ($pricing['total'] ?? 0), 0, ',', ' ') ?> TND</span>
      </div>
      <p style="font-size:.8rem;color:var(--gris);margin-top:1rem">Paiement 100% simulé pour la phase actuelle. Aucune transaction réelle n'est effectuée.</p>
    </aside>

  </div>
</section>
