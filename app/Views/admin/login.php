<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Administration — Yesmine Gharbi</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'DM Sans',system-ui,sans-serif;background:#f5f5f5;display:flex;align-items:center;justify-content:center;min-height:100vh}
.login-box{background:#fff;border-radius:20px;padding:3rem;width:100%;max-width:420px;box-shadow:0 8px 40px rgba(0,0,0,.1)}
.logo{font-size:1.1rem;font-weight:700;margin-bottom:2rem;text-align:center;color:#1F1F1F}
.logo span{color:#EA2E00}
h1{font-size:1.5rem;margin-bottom:.5rem;text-align:center}
p{color:#666;text-align:center;margin-bottom:2rem;font-size:.9rem}
.form-group{margin-bottom:1.25rem}
label{display:block;font-size:.85rem;font-weight:600;margin-bottom:.4rem;color:#444}
input{width:100%;padding:.75rem 1rem;border:1px solid #ddd;border-radius:10px;font-size:.95rem;font-family:inherit}
input:focus{outline:none;border-color:#EA2E00}
button{width:100%;padding:.875rem;background:#EA2E00;color:#fff;border:none;border-radius:10px;font-size:1rem;font-weight:700;cursor:pointer;margin-top:.5rem}
button:hover{background:#c52600}
.alert{padding:.875rem 1rem;background:#fff1ec;color:#EA2E00;border-radius:10px;margin-bottom:1.5rem;font-size:.9rem;border-left:4px solid #EA2E00}
</style>
</head>
<body>
<div class="login-box">
    <div class="logo">Yesmine Gharbi <span>·</span> Admin</div>
    <h1>Connexion</h1>
    <p>Espace administration</p>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <form action="<?= base_url('admin/login') ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required
                   value="<?= esc(old('email')) ?>" placeholder="admin@yesminegharbi.com">
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required placeholder="••••••••">
        </div>
        <button type="submit">Accéder au tableau de bord</button>
    </form>
</div>
</body>
</html>
