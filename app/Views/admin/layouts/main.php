<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($title ?? 'Admin') ?> — Yesmine Gharbi</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWix+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkR4j8w4LLynf1W4n+6o0w5f5hXg5xR9E0Ng==" crossorigin="anonymous" referrerpolicy="no-referrer">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'DM Sans',system-ui,sans-serif;background:#f5f5f5;color:#1F1F1F;display:flex;min-height:100vh}
a{text-decoration:none;color:inherit}

/* Sidebar */
.sidebar{width:240px;background:#1F1F1F;color:#fff;flex-shrink:0;display:flex;flex-direction:column;position:fixed;top:0;left:0;height:100vh;overflow-y:auto;z-index:100}
.sidebar-logo{padding:1.5rem 1.25rem;font-weight:700;font-size:1rem;border-bottom:1px solid rgba(255,255,255,.1)}
.sidebar-logo span{color:#EA2E00}
.sidebar-nav{padding:1rem 0;flex:1}
.sidebar-section{padding:0.75rem 1.25rem;margin-top:1rem;font-size:.75rem;font-weight:700;color:rgba(255,255,255,.55);text-transform:uppercase;letter-spacing:.08em}
.sidebar-nav a{display:flex;align-items:center;gap:.75rem;padding:.75rem 1.25rem;color:rgba(255,255,255,.7);font-size:.9rem;transition:all .15s}
.sidebar-nav a:hover,.sidebar-nav a.active{background:rgba(255,255,255,.08);color:#fff}
.sidebar-nav a.active{border-left:3px solid #EA2E00}
.sidebar-footer{padding:1rem 1.25rem;border-top:1px solid rgba(255,255,255,.1);font-size:.8rem;color:rgba(255,255,255,.4)}
.nav-icon{width:18px;text-align:center}

/* Main */
.main{margin-left:240px;flex:1;display:flex;flex-direction:column;min-height:100vh}
.topbar{background:#fff;border-bottom:1px solid #e5e5e5;padding:0 2rem;height:60px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:10}
.topbar h1{font-size:1.1rem;font-weight:600}
.topbar-right{display:flex;align-items:center;gap:1rem;font-size:.85rem;color:#666}
.topbar-right a{color:#EA2E00;font-weight:600}
.content{padding:2rem;flex:1}

/* Cards */
.stat-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1.25rem;margin-bottom:2rem}
.stat-card{background:#fff;border-radius:14px;padding:1.5rem;box-shadow:0 2px 8px rgba(0,0,0,.06)}
.stat-card .num{font-size:2rem;font-weight:700;color:#1F1F1F}
.stat-card .label{color:#666;font-size:.85rem;margin-top:.25rem}
.stat-card .icon{font-size:1.5rem;margin-bottom:.5rem}

/* Table */
.card{background:#fff;border-radius:14px;box-shadow:0 2px 8px rgba(0,0,0,.06);overflow:hidden}
.card-header{padding:1.25rem 1.5rem;border-bottom:1px solid #f0f0f0;display:flex;align-items:center;justify-content:space-between;font-weight:600}
table{width:100%;border-collapse:collapse;font-size:.9rem}
th{padding:.875rem 1.25rem;text-align:left;background:#fafafa;font-weight:600;font-size:.8rem;text-transform:uppercase;letter-spacing:.05em;color:#666;border-bottom:1px solid #f0f0f0}
td{padding:.875rem 1.25rem;border-bottom:1px solid #f7f7f7;vertical-align:middle}
tr:last-child td{border-bottom:none}
tr:hover td{background:#fafafa}

/* Badges */
.badge{display:inline-block;padding:.2rem .65rem;border-radius:100px;font-size:.75rem;font-weight:600}
.badge-green{background:#e6f4ea;color:#1a7a34}
.badge-red{background:#fff1ec;color:#EA2E00}
.badge-blue{background:#e8f0fe;color:#1a5ccc}
.badge-grey{background:#f0f0f0;color:#666}

/* Buttons */
.btn{display:inline-flex;align-items:center;gap:.4rem;padding:.5rem 1rem;border-radius:8px;font-size:.85rem;font-weight:600;cursor:pointer;border:none;transition:all .15s}
.btn-primary{background:#EA2E00;color:#fff}
.btn-primary:hover{background:#c52600}
.btn-secondary{background:#f0f0f0;color:#333}
.btn-secondary:hover{background:#e5e5e5}
.btn-danger{background:#fff1ec;color:#EA2E00}
.btn-danger:hover{background:#ffddd4}
.btn-sm{padding:.3rem .75rem;font-size:.8rem}

/* Forms */
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:1.25rem}
.form-group{display:flex;flex-direction:column;gap:.4rem}
.form-group.full{grid-column:1/-1}
label{font-size:.85rem;font-weight:600;color:#444}
input[type=text],input[type=email],input[type=number],input[type=password],select,textarea{padding:.65rem .875rem;border:1px solid #ddd;border-radius:8px;font-size:.9rem;width:100%;font-family:inherit;transition:border-color .15s}
input:focus,select:focus,textarea:focus{outline:none;border-color:#EA2E00}
textarea{resize:vertical;min-height:100px}

.admin-form-page .admin-form-content{padding:1.5rem}
.admin-form-page .form-preview-grid{display:grid;grid-template-columns:1.2fr .8fr;gap:1.5rem}
.admin-form-page .form-panel{background:#fff;padding:1.5rem;border-radius:14px;box-shadow:0 2px 12px rgba(0,0,0,.05)}
.admin-form-page .preview-panel{position:sticky;top:1.5rem;align-self:start}
.admin-form-page .preview-card{background:#fff;border-radius:14px;box-shadow:0 2px 12px rgba(0,0,0,.05);overflow:hidden}
.admin-form-page .preview-image{background:#f5f5f5;min-height:220px;display:flex;align-items:center;justify-content:center;color:#888}
.admin-form-page .preview-image img{width:100%;height:100%;object-fit:cover}
.admin-form-page .preview-body{padding:1.5rem}
.admin-form-page .preview-meta{display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:1rem}
.admin-form-page .preview-title{font-size:1.3rem;font-weight:700;margin-bottom:.75rem}
.admin-form-page .preview-text{color:#555;line-height:1.7;margin-bottom:1rem}
.admin-form-page .preview-stats{display:grid;grid-template-columns:1fr 1fr;gap:.75rem}
.admin-form-page .preview-stat{background:#f9f9f9;border:1px solid #f0f0f0;border-radius:12px;padding:1rem;font-size:.9rem}
.admin-form-page .preview-stat strong{display:block;font-size:.75rem;color:#666;margin-bottom:.35rem}
.cover-preview-wrapper{margin-bottom:.75rem}
.cover-preview{background:#fafafa;border:1px dashed #ddd;border-radius:12px;height:180px;display:flex;align-items:center;justify-content:center;color:#999;overflow:hidden}
.cover-preview img{width:100%;height:100%;object-fit:cover}

@media(max-width:1100px){
    .admin-form-page .form-preview-grid{grid-template-columns:1fr}
    .admin-form-page .preview-panel{position:relative;top:auto}
}

@media(max-width:720px){
    .topbar{padding:0 1rem}
    .content{padding:1rem}
    .sidebar{width:220px}
    .main{margin-left:220px}
}

/* Alert */
.alert{padding:1rem 1.25rem;border-radius:10px;margin-bottom:1.5rem;font-size:.9rem}
.alert-success{background:#e6f4ea;color:#1a7a34;border-left:4px solid #1a7a34}
.alert-error{background:#fff1ec;color:#EA2E00;border-left:4px solid #EA2E00}

/* ── Admin helpers ── */
.d-flex{display:flex}
.align-items-center{align-items:center}
.justify-between{justify-content:space-between}
.mb-4{margin-bottom:1.5rem}
.text-green{color:#1a7a34}
.text-orange{color:#d97706}

/* Admin breadcrumb */
.admin-breadcrumb{display:flex;align-items:center;gap:8px;font-size:13px;color:#888}
.admin-breadcrumb a{color:#EA2E00}
.admin-breadcrumb span{color:#ccc}

/* Admin card */
.admin-card{background:#fff;border-radius:14px;box-shadow:0 2px 8px rgba(0,0,0,.06);overflow:hidden;margin-bottom:1.5rem}
.admin-card-header{padding:1.25rem 1.5rem;border-bottom:1px solid #f0f0f0;display:flex;align-items:center;justify-content:space-between}
.admin-card-title{font-size:1rem;font-weight:700;margin:0}

/* Admin buttons */
.admin-btn{display:inline-flex;align-items:center;gap:.35rem;padding:.45rem .9rem;border-radius:8px;font-size:.82rem;font-weight:600;cursor:pointer;border:1px solid transparent;transition:all .15s;white-space:nowrap}
.admin-btn-primary{background:#EA2E00;color:#fff;border-color:#EA2E00}
.admin-btn-primary:hover{background:#c52600}
.admin-btn-outline{background:#fff;color:#333;border-color:#ddd}
.admin-btn-outline:hover{background:#f5f5f5}
.admin-btn-danger{background:#fff1ec;color:#EA2E00;border-color:#ffd4c8}
.admin-btn-danger:hover{background:#ffddd4}
.admin-btn-xs{padding:.25rem .6rem;font-size:.78rem}

/* Admin inputs/labels */
.admin-label{display:block;font-size:.8rem;font-weight:600;color:#555;margin-bottom:4px}
.admin-input{width:100%;padding:.55rem .8rem;border:1px solid #ddd;border-radius:8px;font-size:.875rem;font-family:inherit;transition:border-color .15s}
.admin-input:focus{outline:none;border-color:#EA2E00}
.admin-empty{padding:2rem;text-align:center;color:#aaa;font-size:.9rem;font-style:italic}

/* Detail stats bar */
.detail-stats-bar{display:flex;gap:1px;background:#e5e5e5;border-radius:12px;overflow:hidden}
.detail-stat{background:#fff;flex:1;padding:.875rem 1rem;text-align:center}
.ds-value{display:block;font-size:1.25rem;font-weight:700;color:#1F1F1F}
.ds-label{display:block;font-size:.7rem;color:#888;text-transform:uppercase;letter-spacing:.05em;margin-top:2px}

/* Module blocks */
.modules-list{display:flex;flex-direction:column;gap:12px;padding:1.25rem 1.5rem}
.module-block{border:1px solid #e5e5e5;border-radius:12px;overflow:hidden}
.module-block-header{display:flex;align-items:center;justify-content:space-between;padding:14px 16px;background:#fafafa;border-bottom:1px solid #f0f0f0}
.module-block-left{display:flex;align-items:center;gap:12px}
.module-block-actions{display:flex;align-items:center;gap:6px}
.module-idx{background:#EA2E00;color:#fff;border-radius:50%;width:28px;height:28px;display:inline-flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:700;flex-shrink:0}
.module-meta{font-size:.75rem;color:#888;margin-left:4px}

/* Leçons admin */
.lecons-list-admin{background:#fff}
.lecon-row{display:flex;align-items:center;justify-content:space-between;padding:10px 16px;border-bottom:1px solid #f5f5f5}
.lecon-row:last-of-type{border-bottom:none}
.lecon-row-main{display:flex;align-items:center;gap:10px;flex:1;min-width:0}
.lecon-row-actions{display:flex;gap:6px;flex-shrink:0}
.lecon-type-icon{font-size:1rem;flex-shrink:0}
.lecon-num{font-size:.75rem;color:#aaa;font-weight:600;min-width:30px}
.lecon-titre{font-size:.875rem;flex:1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.badge-free-lecon{background:#e6f4ea;color:#1a7a34;font-size:.7rem;font-weight:600;padding:2px 8px;border-radius:100px;flex-shrink:0}
.lecon-duree-badge{font-size:.75rem;color:#888;flex-shrink:0;margin-left:auto;padding-left:8px}
.lecon-form-grid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:10px}

/* Options quiz/certificat */
.option-toggle{cursor:pointer}
.option-toggle input{display:none}
.option-toggle-card{display:flex;align-items:center;gap:14px;padding:16px 20px;border:2px solid #e5e5e5;border-radius:12px;transition:all .15s;user-select:none}
.option-toggle input:checked + .option-toggle-card{border-color:#EA2E00;background:#fff8f6}
.option-toggle-card:hover{border-color:#EA2E00;background:#fff8f6}
.option-icon{font-size:1.75rem;flex-shrink:0}
.option-toggle-card strong{display:block;font-size:.9rem;margin-bottom:4px}
.option-toggle-card p{font-size:.8rem;color:#888;margin:0}
</style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo"><i class="fa-solid fa-gear" aria-hidden="true"></i> Admin <span>·</span> YG</div>
    <nav class="sidebar-nav">
        <div class="sidebar-section">Général</div>
        <a href="<?= base_url('admin') ?>" <?= current_url() === base_url('admin') ? 'class="active"' : '' ?>>
            <span class="nav-icon"><i class="fa-solid fa-chart-column" aria-hidden="true"></i></span> Tableau de bord
        </a>

        <div class="sidebar-section">Contenu</div>
        <a href="<?= base_url('admin/formations') ?>" <?= str_contains(current_url(), 'admin/formations') ? 'class="active"' : '' ?>>
            <span class="nav-icon"><i class="fa-solid fa-graduation-cap" aria-hidden="true"></i></span> Formations
        </a>
        <a href="<?= base_url('admin/ressources') ?>" <?= str_contains(current_url(), 'admin/ressources') ? 'class="active"' : '' ?>>
            <span class="nav-icon"><i class="fa-solid fa-file-lines" aria-hidden="true"></i></span> Ressources
        </a>
        <a href="<?= base_url('admin/testimonials') ?>" <?= str_contains(current_url(), 'admin/testimonials') ? 'class="active"' : '' ?>>
            <span class="nav-icon"><i class="fa-solid fa-comments" aria-hidden="true"></i></span> Témoignages
        </a>

        <div class="sidebar-section">Communication</div>
        <a href="<?= base_url('admin/newsletter') ?>" <?= str_contains(current_url(), 'admin/newsletter') ? 'class="active"' : '' ?>>
            <span class="nav-icon"><i class="fa-solid fa-envelope" aria-hidden="true"></i></span> Newsletter
        </a>
        <a href="<?= base_url('admin/messages') ?>" <?= str_contains(current_url(), 'admin/messages') ? 'class="active"' : '' ?>>
            <span class="nav-icon"><i class="fa-solid fa-comments" aria-hidden="true"></i></span> Messages
        </a>

        <div class="sidebar-section">Paramètres</div>
        <a href="<?= base_url('admin/users') ?>" <?= str_contains(current_url(), 'admin/users') ? 'class="active"' : '' ?>>
            <span class="nav-icon"><i class="fa-solid fa-user" aria-hidden="true"></i></span> Utilisateurs
        </a>
        <a href="<?= base_url('admin/parametres') ?>" <?= str_contains(current_url(), 'admin/parametres') ? 'class="active"' : '' ?>>
            <span class="nav-icon"><i class="fa-solid fa-gear" aria-hidden="true"></i></span> Paramètres
        </a>
        <a href="<?= base_url('admin/socials') ?>" <?= str_contains(current_url(), 'admin/socials') ? 'class="active"' : '' ?>>
            <span class="nav-icon"><i class="fa-solid fa-link" aria-hidden="true"></i></span> Connexions sociales
        </a>

        <hr style="border:none;border-top:1px solid rgba(255,255,255,.1);margin:.75rem 1.25rem">
        <a href="<?= base_url('/') ?>" target="_blank">
            <span class="nav-icon"><i class="fa-solid fa-globe" aria-hidden="true"></i></span> Voir le site
        </a>
    </nav>
    <div class="sidebar-footer"><?= esc(session()->get('admin_email') ?? '') ?></div>
</aside>

<div class="main">
    <header class="topbar">
        <h1><?= esc($title ?? 'Admin') ?></h1>
        <div class="topbar-right">
            <span><?= date('d/m/Y') ?></span>
            <a href="<?= base_url('admin/logout') ?>">Déconnexion</a>
        </div>
    </header>
    <div class="content">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <?= $content ?>
    </div>
</div>

</body>
</html>
