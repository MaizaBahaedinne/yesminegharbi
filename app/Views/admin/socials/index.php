<?php $s = $settings; ?>

<?php if (session()->getFlashdata('success')): ?>
<div style="background:#e6f4ea;border:1px solid #a8d5b0;color:#1a7a34;padding:12px 18px;border-radius:8px;margin-bottom:20px;font-size:14px">
    ✅ <?= esc(session()->getFlashdata('success')) ?>
</div>
<?php endif; ?>

<form action="<?= base_url('admin/socials/update') ?>" method="post" style="max-width:760px">
    <?= csrf_field() ?>

    <div class="card" style="margin-bottom:24px">
        <div class="card-header">🤝 Connexions réseaux sociaux</div>
        <div style="padding:24px;display:flex;flex-direction:column;gap:20px">

            <div style="color:#374151;font-size:14px;line-height:1.6;padding-bottom:8px;border-bottom:1px solid #e5e7eb">
                Saisissez ici les clés et tokens des plateformes que vous souhaitez connecter. Ils seront utilisés par le site pour récupérer des statistiques et lancer des actions.
            </div>

            <div style="display:grid;grid-template-columns:1fr;gap:16px">
                <div style="border:1px solid #e5e7eb;border-radius:8px;padding:16px">
                    <h3 style="margin-bottom:12px;font-size:16px">Facebook / Instagram</h3>
                    <label style="font-size:12px;color:#6b7280;display:block;margin-bottom:4px">App ID</label>
                    <input type="text" name="facebook_app_id" value="<?= esc($s['facebook_app_id'] ?? '') ?>" style="width:100%;padding:10px;border:1px solid #d1d5db;border-radius:6px;font-size:14px">

                    <label style="font-size:12px;color:#6b7280;display:block;margin-bottom:4px;margin-top:12px">App Secret</label>
                    <input type="text" name="facebook_app_secret" value="<?= esc($s['facebook_app_secret'] ?? '') ?>" style="width:100%;padding:10px;border:1px solid #d1d5db;border-radius:6px;font-size:14px">

                    <label style="font-size:12px;color:#6b7280;display:block;margin-bottom:4px;margin-top:12px">Access Token</label>
                    <input type="text" name="facebook_access_token" value="<?= esc($s['facebook_access_token'] ?? '') ?>" style="width:100%;padding:10px;border:1px solid #d1d5db;border-radius:6px;font-size:14px">

                    <label style="font-size:12px;color:#6b7280;display:block;margin-bottom:4px;margin-top:12px">Page ID</label>
                    <input type="text" name="facebook_page_id" value="<?= esc($s['facebook_page_id'] ?? '') ?>" style="width:100%;padding:10px;border:1px solid #d1d5db;border-radius:6px;font-size:14px">
                </div>

                <div style="border:1px solid #e5e7eb;border-radius:8px;padding:16px">
                    <h3 style="margin-bottom:12px;font-size:16px">LinkedIn</h3>
                    <label style="font-size:12px;color:#6b7280;display:block;margin-bottom:4px">Client ID</label>
                    <input type="text" name="linkedin_client_id" value="<?= esc($s['linkedin_client_id'] ?? '') ?>" style="width:100%;padding:10px;border:1px solid #d1d5db;border-radius:6px;font-size:14px">

                    <label style="font-size:12px;color:#6b7280;display:block;margin-bottom:4px;margin-top:12px">Client Secret</label>
                    <input type="text" name="linkedin_client_secret" value="<?= esc($s['linkedin_client_secret'] ?? '') ?>" style="width:100%;padding:10px;border:1px solid #d1d5db;border-radius:6px;font-size:14px">

                    <label style="font-size:12px;color:#6b7280;display:block;margin-bottom:4px;margin-top:12px">Access Token</label>
                    <input type="text" name="linkedin_access_token" value="<?= esc($s['linkedin_access_token'] ?? '') ?>" style="width:100%;padding:10px;border:1px solid #d1d5db;border-radius:6px;font-size:14px">
                </div>

                <div style="border:1px solid #e5e7eb;border-radius:8px;padding:16px">
                    <h3 style="margin-bottom:12px;font-size:16px">TikTok</h3>
                    <label style="font-size:12px;color:#6b7280;display:block;margin-bottom:4px">Client Key</label>
                    <input type="text" name="tiktok_client_key" value="<?= esc($s['tiktok_client_key'] ?? '') ?>" style="width:100%;padding:10px;border:1px solid #d1d5db;border-radius:6px;font-size:14px">

                    <label style="font-size:12px;color:#6b7280;display:block;margin-bottom:4px;margin-top:12px">Client Secret</label>
                    <input type="text" name="tiktok_client_secret" value="<?= esc($s['tiktok_client_secret'] ?? '') ?>" style="width:100%;padding:10px;border:1px solid #d1d5db;border-radius:6px;font-size:14px">

                    <label style="font-size:12px;color:#6b7280;display:block;margin-bottom:4px;margin-top:12px">Access Token</label>
                    <input type="text" name="tiktok_access_token" value="<?= esc($s['tiktok_access_token'] ?? '') ?>" style="width:100%;padding:10px;border:1px solid #d1d5db;border-radius:6px;font-size:14px">
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary" style="background:#EA2E00;color:#fff;border:none;padding:12px 28px;border-radius:8px;font-size:15px;font-weight:600;cursor:pointer">
        💾 Enregistrer les connexions
    </button>
</form>
