<?php
/** @var array $ressource */
?>

<section class="page-header" style="background:var(--noir)">
  <div class="container">
    <h1 style="color:#fff">Vérification avant téléchargement</h1>
    <p style="color:rgba(255,255,255,.85)">Pour sécuriser l'accès, confirmez votre identité avec un code email à 6 chiffres.</p>
  </div>
</section>

<section class="section" style="background:var(--beige)">
  <div class="container" style="max-width:560px;margin:0 auto">
    <div style="background:#fff;border-radius:16px;padding:2rem;box-shadow:0 4px 16px rgba(0,0,0,.06)">
      <h2 style="font-family:'Playfair Display',serif;margin:0 0 .65rem;font-size:1.4rem"><?= esc($ressource['titre'] ?? '') ?></h2>
      <p style="color:var(--gris);margin-bottom:1rem">Entrez le code reçu par email pour continuer.</p>

      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success" style="margin-bottom:1rem"><?= esc(session()->getFlashdata('success')) ?></div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error" style="margin-bottom:1rem"><?= esc(session()->getFlashdata('error')) ?></div>
      <?php endif; ?>

      <form action="<?= site_url('ressources/download/verification/' . ($ressource['slug'] ?? '')) ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-group">
          <label for="download_verify_code" class="form-label">Code de vérification (6 chiffres)</label>
          <input type="text" id="download_verify_code" name="code" maxlength="6" class="form-control" inputmode="numeric" pattern="[0-9]{6}" placeholder="123456" required value="<?= esc(old('code')) ?>">
        </div>

        <button type="submit" class="btn-primary" style="width:100%;justify-content:center;margin-top:.25rem">Valider et télécharger</button>
      </form>

      <a href="<?= site_url('ressources/download/request-code/' . ($ressource['slug'] ?? '')) ?>" class="btn-secondary" style="display:flex;justify-content:center;margin-top:.75rem;text-decoration:none">
        Renvoyer un nouveau code
      </a>
    </div>
  </div>
</section>
