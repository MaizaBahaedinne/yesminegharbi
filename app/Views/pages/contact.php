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
        <?php
        $socialSvg = [
            'tiktok'    => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.18 8.18 0 0 0 4.78 1.52V6.76a4.85 4.85 0 0 1-1.01-.07z"/></svg>',
            'instagram' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>',
            'linkedin'  => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
            'facebook'  => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
        ];
        $nets = [
            ['key'=>'tiktok',    'label'=>'TikTok'],
            ['key'=>'instagram', 'label'=>'Instagram'],
            ['key'=>'linkedin',  'label'=>'LinkedIn'],
            ['key'=>'facebook',  'label'=>'Facebook'],
        ];
        foreach ($nets as $n):
            $url   = $settings[$n['key'].'_url'] ?? '#';
            $count = $settings[$n['key'].'_followers'] ?? '';
        ?>
        <a href="<?= esc($url) ?>" class="social-link" target="_blank" rel="noopener">
          <?= $socialSvg[$n['key']] ?> <?= $n['label'] ?><?= $count ? ' <strong style="font-weight:700;color:var(--noir)">'.$count.'</strong>' : '' ?>
        </a>
        <?php endforeach; ?>
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
