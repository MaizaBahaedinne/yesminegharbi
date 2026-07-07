<footer>
  <a href="<?= site_url('/') ?>" class="footer-logo">Yesmine <span>Gharbi</span></a>

  <ul class="footer-links">
    <li><a href="<?= site_url('formations') ?>">Formations</a></li>
    <li><a href="<?= site_url('ressources') ?>">Ressources</a></li>
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
    <button class="modal-close" id="closeDownloadModal" aria-label="Fermer"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
    <div class="modal-icon"><i class="fa-solid fa-download" aria-hidden="true"></i></div>
    <h3 id="downloadModalTitle">Télécharger gratuitement</h3>
    <p id="downloadModalDesc">Avez-vous déjà un compte ?</p>

    <div id="downloadChoiceStep">
      <div style="display:grid;gap:.7rem;margin-top:1rem">
        <button type="button" id="showLoginStep" class="btn-secondary" style="width:100%;justify-content:center">J'ai déjà un compte</button>
        <a href="<?= base_url('auth/google') ?>" class="btn-secondary" style="width:100%;justify-content:center;display:flex;text-decoration:none;border-color:#d8d8d8;color:#222;background:#fff">
          Continuer avec Google
        </a>
        <button type="button" id="showRegisterStep" class="btn-primary" style="width:100%;justify-content:center">Je crée mon compte</button>
      </div>
    </div>

    <form id="downloadLoginForm" action="<?= base_url('connexion') ?>" method="post" style="display:none;margin-top:1rem">
      <?= csrf_field() ?>
      <div class="form-group">
        <label for="dl_login_email">Email</label>
        <input type="email" id="dl_login_email" name="email" class="form-input" placeholder="votre@email.com" required>
      </div>
      <div class="form-group">
        <label for="dl_login_password">Mot de passe</label>
        <input type="password" id="dl_login_password" name="password" class="form-input" placeholder="••••••••" required>
      </div>
      <button type="submit" class="btn-primary" style="width:100%;justify-content:center">Se connecter</button>
      <a href="<?= base_url('auth/google') ?>" class="btn-secondary" style="width:100%;justify-content:center;display:flex;margin-top:.6rem;text-decoration:none;border-color:#d8d8d8;color:#222;background:#fff">
        Continuer avec Google
      </a>
      <button type="button" id="backToChoiceFromLogin" class="btn-secondary" style="width:100%;justify-content:center;margin-top:.6rem">Retour</button>
      <p style="text-align:center;margin-top:.75rem;font-size:.85rem">
        <a href="<?= base_url('mot-de-passe-oublie') ?>" style="color:var(--rouge);font-weight:600">Mot de passe oublié ?</a>
      </p>
    </form>

    <form id="downloadForm" style="display:none;margin-top:1rem">
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
        <label for="dl_situation_actuelle">Situation actuelle</label>
        <select id="dl_situation_actuelle" name="situation_actuelle" class="form-input" required>
          <option value="" selected disabled>Choisissez votre situation</option>
          <option value="Etudiant(e)">Etudiant(e)</option>
          <option value="Salarie">Salarier</option>
          <option value="Chef d'entreprise">Chef d'entreprise</option>
          <option value="Freelance">Freelance</option>
          <option value="A la recherche d'une nouvelle opportunite">A la recherche d'une nouvelle opportunite</option>
          <option value="Recruteur">Recruteur</option>
        </select>
      </div>
      <div class="form-group">
        <label for="dl_email">Email</label>
        <input type="email" id="dl_email" name="email" class="form-input" placeholder="votre@email.com" required>
      </div>
      <div id="downloadMsg"></div>
      <button type="submit" class="btn-primary" style="width:100%;justify-content:center">Créer mon accès →</button>
      <button type="button" id="backToChoiceFromRegister" class="btn-secondary" style="width:100%;justify-content:center;margin-top:.6rem">Retour</button>
      <p style="font-size:12px;color:var(--gris);margin-top:10px;text-align:center">Un lien d’activation vous sera envoyé pour accéder à la ressource.</p>
    </form>
  </div>
</div>
