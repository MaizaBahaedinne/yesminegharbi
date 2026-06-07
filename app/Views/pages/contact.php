<div class="page-header">
  <div class="page-header-inner">
    <span class="section-tag">Contact</span>
    <h1>Prenons contact</h1>
    <p>Une question, une collaboration ou un projet ? Écrivez-moi, je réponds sous 48h.</p>
  </div>
</div>

<section>
  <div style="display:grid;grid-template-columns:1fr 1.5fr;gap:64px;max-width:960px;margin:0 auto;align-items:start">

    <!-- Info -->
    <div>
      <h3 style="font-family:'Playfair Display',serif;font-size:22px;margin-bottom:24px">Informations</h3>

      <div style="display:flex;flex-direction:column;gap:20px;margin-bottom:40px">
        <div style="display:flex;gap:14px;align-items:flex-start">
          <div style="width:44px;height:44px;background:var(--rouge-light);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0">📧</div>
          <div>
            <div style="font-weight:600;margin-bottom:2px">Email</div>
            <a href="mailto:hello@yesminegharbi.com" style="color:var(--gris);font-size:14px">hello@yesminegharbi.com</a>
          </div>
        </div>
        <div style="display:flex;gap:14px;align-items:flex-start">
          <div style="width:44px;height:44px;background:var(--rouge-light);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0">⏱</div>
          <div>
            <div style="font-weight:600;margin-bottom:2px">Délai de réponse</div>
            <span style="color:var(--gris);font-size:14px">Sous 48h ouvrées</span>
          </div>
        </div>
      </div>

      <h4 style="font-weight:600;margin-bottom:14px">Mes réseaux</h4>
      <div class="social-links">
        <a href="https://tiktok.com/@yesminegharbi"     class="social-link" target="_blank" rel="noopener">📱 TikTok</a>
        <a href="https://instagram.com/yesminegharbi"   class="social-link" target="_blank" rel="noopener">📸 Instagram</a>
        <a href="https://linkedin.com/in/yesminegharbi" class="social-link" target="_blank" rel="noopener">💼 LinkedIn</a>
        <a href="https://facebook.com/yesminegharbi"    class="social-link" target="_blank" rel="noopener">👥 Facebook</a>
      </div>
    </div>

    <!-- Formulaire -->
    <div>
      <form id="contactForm" novalidate>
        <?= csrf_field() ?>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px">
          <div class="form-group">
            <label for="c_nom">Nom complet *</label>
            <input type="text" id="c_nom" name="nom" class="form-input" placeholder="Votre nom" required>
          </div>
          <div class="form-group">
            <label for="c_email">Email *</label>
            <input type="email" id="c_email" name="email" class="form-input" placeholder="votre@email.com" required>
          </div>
        </div>

        <div class="form-group" style="margin-bottom:20px">
          <label for="c_sujet">Sujet *</label>
          <select id="c_sujet" name="sujet" class="form-input">
            <?php
            $sujetSelectionne = service('request')->getGet('sujet') ?? '';
            $sujets = [
                ''                          => '— Choisissez un sujet —',
                'formation'                 => 'Question sur une formation',
                'ressource'                 => 'Question sur une ressource',
                'collaboration-entreprise'  => 'Collaboration / Entreprise',
                'partenariat'               => 'Partenariat',
                'autre'                     => 'Autre',
            ];
            foreach ($sujets as $val => $label): ?>
            <option value="<?= esc($val) ?>" <?= $sujetSelectionne === $val ? 'selected' : '' ?>><?= esc($label) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group" style="margin-bottom:24px">
          <label for="c_message">Message *</label>
          <textarea id="c_message" name="message" class="form-input" style="min-height:140px;resize:vertical" placeholder="Décrivez votre projet ou votre question..." required></textarea>
        </div>

        <div id="contactMsg" style="margin-bottom:14px;font-size:14px;font-weight:600"></div>
        <button type="submit" class="btn-primary" style="width:100%;justify-content:center">Envoyer le message →</button>
        <p style="font-size:12px;color:var(--gris);margin-top:10px;text-align:center">Je réponds personnellement à chaque message sous 48h.</p>
      </form>
    </div>

  </div>
</section>
