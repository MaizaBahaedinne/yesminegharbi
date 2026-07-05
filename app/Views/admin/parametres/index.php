<?php $s = $settings; ?>

<?php if (session()->getFlashdata('success')): ?>
<div style="background:#e6f4ea;border:1px solid #a8d5b0;color:#1a7a34;padding:12px 18px;border-radius:8px;margin-bottom:20px;font-size:14px">
    ✅ <?= esc(session()->getFlashdata('success')) ?>
</div>
<?php endif; ?>

<form action="<?= base_url('admin/parametres/update') ?>" method="post" style="max-width:720px">
    <?= csrf_field() ?>

    <!-- Réseaux sociaux -->
    <div class="card" style="margin-bottom:24px">
        <div class="card-header">📱 Réseaux sociaux</div>
        <div style="padding:24px;display:flex;flex-direction:column;gap:20px">
            <div style="font-size:14px;color:#374151;line-height:1.6;padding:0 0 8px;border-bottom:1px solid #e5e7eb">
                Les nombres d'abonnés sont saisis manuellement dans ces champs. Il n'y a pas de récupération automatique des statistiques.
            </div>

            <?php
            $networks = [
                'tiktok'    => ['label' => 'TikTok',    'icon' => '📱', 'placeholder' => 'https://tiktok.com/@...'],
                'instagram' => ['label' => 'Instagram',  'icon' => '📸', 'placeholder' => 'https://instagram.com/...'],
                'linkedin'  => ['label' => 'LinkedIn',   'icon' => '💼', 'placeholder' => 'https://linkedin.com/in/...'],
                'facebook'  => ['label' => 'Facebook',   'icon' => '👥', 'placeholder' => 'https://facebook.com/...'],
            ];
            foreach ($networks as $key => $net):
            ?>
            <div style="border:1px solid #e5e7eb;border-radius:8px;padding:16px">
                <div style="font-weight:600;font-size:14px;margin-bottom:12px;display:flex;align-items:center;gap:8px">
                    <?= $net['icon'] ?> <?= $net['label'] ?>
                </div>
                <div style="display:grid;grid-template-columns:1fr 160px;gap:12px">
                    <div>
                        <label style="font-size:12px;color:#6b7280;display:block;margin-bottom:4px">URL du profil</label>
                        <input type="url" name="<?= $key ?>_url"
                               value="<?= esc($s[$key.'_url'] ?? '') ?>"
                               placeholder="<?= $net['placeholder'] ?>"
                               style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:6px;font-size:14px">
                    </div>
                    <div>
                        <label style="font-size:12px;color:#6b7280;display:block;margin-bottom:4px">Abonnés (ex: 30K)</label>
                        <input type="text" name="<?= $key ?>_followers"
                               value="<?= esc($s[$key.'_followers'] ?? '') ?>"
                               placeholder="ex: 30K"
                               style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:6px;font-size:14px">
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>

    <!-- Contact -->
    <div class="card" style="margin-bottom:24px">
        <div class="card-header">✉️ Contact</div>
        <div style="padding:24px">
            <label style="font-size:12px;color:#6b7280;display:block;margin-bottom:4px">Adresse e-mail de contact</label>
            <input type="email" name="email"
                   value="<?= esc($s['email'] ?? '') ?>"
                   placeholder="hello@yesminegharbi.com"
                   style="width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:6px;font-size:14px">
        </div>
    </div>

    <button type="submit" class="btn btn-primary" style="background:#EA2E00;color:#fff;border:none;padding:12px 28px;border-radius:8px;font-size:15px;font-weight:600;cursor:pointer">
        💾 Enregistrer les paramètres
    </button>
</form>
