<?php
/**
 * Shared Footer Component
 * yesminegharbi.com
 */
?>
</main><!-- end .page-content -->

<!-- ===== NEWSLETTER MODAL ===== -->
<div class="modal-overlay" id="newsletterModal" role="dialog" aria-modal="true" aria-labelledby="newsletterModalTitle">
  <div class="modal">
    <button class="modal__close" id="closeNewsletterModal" aria-label="Fermer">
      <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
      </svg>
    </button>
    <div class="modal__icon">
      <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
      </svg>
    </div>
    <h3 class="modal__title" id="newsletterModalTitle">Restez informé·e</h3>
    <p class="modal__subtitle">Recevez mes derniers conseils recrutement directement dans votre boîte mail.</p>
    <form id="newsletterForm" action="/api/newsletter.php" method="POST">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
      <div class="form-group">
        <label class="form-label" for="nl_prenom">Prénom</label>
        <input type="text" id="nl_prenom" name="prenom" class="form-input" placeholder="Votre prénom" required>
      </div>
      <div class="form-group">
        <label class="form-label" for="nl_email">Email</label>
        <input type="email" id="nl_email" name="email" class="form-input" placeholder="votre@email.com" required>
      </div>
      <button type="submit" class="btn btn--primary btn--full">S'abonner gratuitement</button>
    </form>
  </div>
</div>

<!-- ===== FOOTER ===== -->
<footer class="footer" role="contentinfo">
  <div class="container">
    <div class="footer__grid">

      <!-- Brand -->
      <div class="footer__brand">
        <div class="footer__logo">Yesmine<span style="color:var(--color-accent)">.</span></div>
        <p class="footer__tagline">
          Des conseils qui viennent du terrain, pas des manuels —
          accessibles en un seul endroit.
        </p>
        <div class="footer__socials" role="list">
          <a href="https://www.tiktok.com/@yesminegharbi" class="footer__social-icon" target="_blank" rel="noopener noreferrer" aria-label="TikTok" role="listitem">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.27 6.27 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.73a4.85 4.85 0 01-1.01-.04z"/></svg>
          </a>
          <a href="https://www.instagram.com/yesminegharbi" class="footer__social-icon" target="_blank" rel="noopener noreferrer" aria-label="Instagram" role="listitem">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
          </a>
          <a href="https://www.linkedin.com/in/yesminegharbi" class="footer__social-icon" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn" role="listitem">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
          </a>
          <a href="https://www.facebook.com/yesminegharbi" class="footer__social-icon" target="_blank" rel="noopener noreferrer" aria-label="Facebook" role="listitem">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
          </a>
        </div>
      </div>

      <!-- Formations -->
      <div>
        <h3 class="footer__heading">Formations</h3>
        <ul class="footer__links">
          <li><a href="/formations.php" class="footer__link">Toutes les formations</a></li>
          <li><a href="/formations.php?niveau=junior" class="footer__link">Pour les juniors</a></li>
          <li><a href="/formations.php?niveau=experimente" class="footer__link">Pour les expérimentés</a></li>
          <li><a href="/formations.php?theme=cv" class="footer__link">Optimiser son CV</a></li>
          <li><a href="/formations.php?theme=entretien" class="footer__link">Préparer l'entretien</a></li>
        </ul>
      </div>

      <!-- Ressources -->
      <div>
        <h3 class="footer__heading">Ressources</h3>
        <ul class="footer__links">
          <li><a href="/ressources-gratuites.php" class="footer__link">Ressources gratuites</a></li>
          <li><a href="/ressources-premium.php" class="footer__link">Ressources premium</a></li>
          <li><a href="/entreprises.php" class="footer__link">Offres entreprises</a></li>
        </ul>
      </div>

      <!-- Liens -->
      <div>
        <h3 class="footer__heading">À propos</h3>
        <ul class="footer__links">
          <li><a href="/a-propos.php"  class="footer__link">Mon parcours</a></li>
          <li><a href="/contact.php"   class="footer__link">Me contacter</a></li>
          <li><a href="/mentions-legales.php" class="footer__link">Mentions légales</a></li>
          <li><a href="/cgv.php"       class="footer__link">CGV</a></li>
          <li><a href="/confidentialite.php" class="footer__link">Confidentialité</a></li>
        </ul>
      </div>

    </div>

    <!-- Footer Bottom -->
    <div class="footer__bottom">
      <p class="footer__copy">© <?= date('Y') ?> Yesmine Gharbi — Tous droits réservés</p>
      <button class="btn btn--sm btn--secondary" id="openNewsletterModal" aria-label="S'abonner à la newsletter">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
        Newsletter
      </button>
    </div>

  </div>
</footer>

<!-- ===== SCRIPTS ===== -->
<script src="/assets/js/main.js" defer></script>

</body>
</html>
