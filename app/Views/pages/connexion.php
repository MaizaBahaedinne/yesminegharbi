<?php
// app/Views/pages/connexion.php
$activeTab = ($activeTab ?? 'login') === 'register' ? 'register' : 'login';
?>
<section class="section" style="background:var(--beige);min-height:70vh;display:flex;align-items:center;justify-content:center">
    <div class="container" style="max-width:460px">
        <div style="background:#fff;border-radius:24px;padding:3rem;box-shadow:0 8px 32px rgba(0,0,0,.08)">
            <h1 style="font-family:'Playfair Display',serif;margin-bottom:.5rem;font-size:1.75rem">Connexion / Inscription</h1>
            <p style="color:var(--gris);margin-bottom:1.2rem;font-size:.95rem">Accédez à votre espace et vos ressources</p>

            <div id="authTabs" style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem;background:#f6f1e8;border:1px solid #e5d7c7;border-radius:12px;padding:.35rem;margin-bottom:1.5rem">
                <button type="button" data-tab="login" class="auth-tab-btn" style="padding:.7rem .85rem;border-radius:10px;font-weight:700;font-size:.9rem;background:<?= $activeTab === 'login' ? 'var(--rouge)' : 'transparent' ?>;color:<?= $activeTab === 'login' ? '#fff' : 'var(--gris)' ?>">Connexion</button>
                <button type="button" data-tab="register" class="auth-tab-btn" style="padding:.7rem .85rem;border-radius:10px;font-weight:700;font-size:.9rem;background:<?= $activeTab === 'register' ? 'var(--rouge)' : 'transparent' ?>;color:<?= $activeTab === 'register' ? '#fff' : 'var(--gris)' ?>">Créer un compte</button>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success" style="margin-bottom:1rem"><?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error" style="margin-bottom:1rem"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>

            <div id="authTabLogin" style="display:<?= $activeTab === 'login' ? 'block' : 'none' ?>">
                <form action="<?= base_url('connexion') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required placeholder="votre@email.com" value="<?= esc(old('email')) ?>">
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" id="password" name="password" class="form-control" required placeholder="••••••••">
                    </div>
                    <button type="submit" class="btn-primary" style="width:100%;padding:.875rem;margin-top:.5rem">Se connecter</button>
                </form>

                <div style="display:flex;align-items:center;gap:.75rem;margin:1rem 0">
                    <span style="height:1px;background:#e7dfd2;flex:1"></span>
                    <span style="font-size:.8rem;color:var(--gris)">ou</span>
                    <span style="height:1px;background:#e7dfd2;flex:1"></span>
                </div>

                <a href="<?= base_url('auth/google') ?>" class="btn-secondary" style="width:100%;display:flex;justify-content:center;align-items:center;gap:.5rem;padding:.875rem;text-decoration:none;border-color:#d8d8d8;color:#222;background:#fff">
                    <span style="font-weight:700">G</span>
                    Continuer avec Google
                </a>

                <p style="text-align:center;margin-top:1rem;color:var(--gris);font-size:.9rem">
                    <a href="<?= base_url('mot-de-passe-oublie') ?>" style="color:var(--rouge);font-weight:600">Mot de passe oublié ?</a>
                </p>
            </div>

            <div id="authTabRegister" style="display:<?= $activeTab === 'register' ? 'block' : 'none' ?>">
                <form action="<?= base_url('inscription') ?>" method="post">
                    <?= csrf_field() ?>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                        <div class="form-group">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" id="prenom" name="prenom" class="form-control" required placeholder="Votre prénom" value="<?= esc(old('prenom')) ?>">
                        </div>
                        <div class="form-group">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" id="nom" name="nom" class="form-control" required placeholder="Votre nom" value="<?= esc(old('nom')) ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date_naissance" class="form-label">Date de naissance</label>
                        <input type="date" id="date_naissance" name="date_naissance" class="form-control" required value="<?= esc(old('date_naissance')) ?>">
                    </div>
                    <div class="form-group">
                        <label for="situation_actuelle" class="form-label">Situation actuelle</label>
                        <?php $oldSituation = (string) old('situation_actuelle'); ?>
                        <select id="situation_actuelle" name="situation_actuelle" class="form-control" required>
                            <option value="">Choisissez votre situation</option>
                            <option value="Etudiant(e)" <?= $oldSituation === 'Etudiant(e)' ? 'selected' : '' ?>>Etudiant(e)</option>
                            <option value="Salarie" <?= $oldSituation === 'Salarie' ? 'selected' : '' ?>>Salarier</option>
                            <option value="Chef d'entreprise" <?= $oldSituation === "Chef d'entreprise" ? 'selected' : '' ?>>Chef d'entreprise</option>
                            <option value="Freelance" <?= $oldSituation === 'Freelance' ? 'selected' : '' ?>>Freelance</option>
                            <option value="A la recherche d'une nouvelle opportunite" <?= $oldSituation === "A la recherche d'une nouvelle opportunite" ? 'selected' : '' ?>>A la recherche d'une nouvelle opportunite</option>
                            <option value="Recruteur" <?= $oldSituation === 'Recruteur' ? 'selected' : '' ?>>Recruteur</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="register_email" class="form-label">Email</label>
                        <input type="email" id="register_email" name="email" class="form-control" required placeholder="votre@email.com" value="<?= esc(old('email')) ?>">
                    </div>
                    <button type="submit" class="btn-primary" style="width:100%;padding:.875rem;margin-top:.5rem">Continuer</button>
                    <p style="font-size:12px;color:var(--gris);margin-top:10px;text-align:center">Un code de vérification à 6 chiffres vous sera envoyé par email.</p>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const loginPanel = document.getElementById('authTabLogin');
    const registerPanel = document.getElementById('authTabRegister');
    const buttons = document.querySelectorAll('#authTabs .auth-tab-btn');

    function activateTab(tab) {
        const isLogin = tab === 'login';
        if (loginPanel) loginPanel.style.display = isLogin ? 'block' : 'none';
        if (registerPanel) registerPanel.style.display = isLogin ? 'none' : 'block';

        buttons.forEach((btn) => {
            const active = btn.dataset.tab === tab;
            btn.style.background = active ? 'var(--rouge)' : 'transparent';
            btn.style.color = active ? '#fff' : 'var(--gris)';
        });
    }

    buttons.forEach((btn) => {
        btn.addEventListener('click', () => activateTab(btn.dataset.tab));
    });
});
</script>
