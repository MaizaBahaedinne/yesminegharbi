<footer>
  <a href="<?= site_url('/') ?>" class="footer-logo">Yesmine <span>Gharbi</span></a>

  <ul class="footer-links">
    <li><a href="<?= site_url('formations') ?>">Formations</a></li>
    <li><a href="<?= site_url('ressources-gratuites') ?>">Ressources</a></li>
    <li><a href="<?= site_url('entreprises') ?>">Entreprises</a></li>
    <li><a href="<?= site_url('a-propos') ?>">À propos</a></li>
    <li><a href="<?= site_url('contact') ?>">Contact</a></li>
    <li><a href="#">Mentions légales</a></li>
  </ul>

  <span class="footer-copy">© <?= date('Y') ?> Yesmine Gharbi · yesminegharbi.com</span>
</footer>

<!-- Modal téléchargement ressource gratuite -->
<div class="modal-overlay" id="downloadModal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="downloadModalTitle">
  <div class="modal-box">
    <button class="modal-close" id="closeDownloadModal" aria-label="Fermer">✕</button>
    <div class="modal-icon">📥</div>
    <h3 id="downloadModalTitle">Télécharger gratuitement</h3>
    <p id="downloadModalDesc">Créez votre compte pour recevoir la ressource.</p>
    <form id="downloadForm">
      <?= csrf_field() ?>
      <input type="hidden" name="resource_id" id="downloadResourceId">
      <div class="form-group">
        <label for="dl_prenom">Prénom</label>
        <input type="text" id="dl_prenom" name="prenom" class="form-input" placeholder="Votre prénom" required>
      </div>
      <div class="form-group">
        <label for="dl_nom">Nom</label>
        <input type="text" id="dl_nom" name="nom" class="form-input" placeholder="Votre nom" required>
      </div>
      <div class="form-group">
        <label for="dl_date_naissance">Date de naissance</label>
        <input type="date" id="dl_date_naissance" name="date_naissance" class="form-input" required>
      </div>
      <div class="form-group">
        <label for="dl_email">Email</label>
        <input type="email" id="dl_email" name="email" class="form-input" placeholder="votre@email.com" required>
      </div>
      <div id="downloadMsg"></div>
      <button type="submit" class="btn-primary" style="width:100%;justify-content:center">Créer mon accès →</button>
      <p style="font-size:12px;color:var(--gris);margin-top:10px;text-align:center">Un lien d’activation vous sera envoyé pour accéder à la ressource.</p>
    </form>
  </div>
</div>
