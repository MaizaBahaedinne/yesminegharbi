<?php
$totalResults = count($results['formations']) + count($results['ressources']) + count($results['articles']);
?>
<section class="page-header">
  <div class="page-header-inner">
    <span class="section-tag">Explorer le site</span>
    <h1>Recherche</h1>
    <p>Trouvez une formation, une ressource ou un article.</p>
  </div>
</section>

<section>
  <div class="search-page">
    <form action="<?= site_url('recherche') ?>" method="get" class="search-page-form" role="search">
      <label class="sr-only" for="page-search">Votre recherche</label>
      <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
      <input id="page-search" type="search" name="q" value="<?= esc($query) ?>" placeholder="Ex. CV, recrutement, LinkedIn…" minlength="2" maxlength="100" required autofocus>
      <button type="submit" class="btn-primary">Rechercher</button>
    </form>

    <?php if (!$hasSearched): ?>
      <p class="search-hint">Saisissez au moins deux caractères pour lancer la recherche.</p>
    <?php elseif (mb_strlen($query) < 2): ?>
      <p class="search-hint">La recherche doit contenir au moins deux caractères.</p>
    <?php elseif ($totalResults === 0): ?>
      <div class="search-empty">
        <i class="fa-regular fa-face-meh" aria-hidden="true"></i>
        <h2>Aucun résultat pour « <?= esc($query) ?> »</h2>
        <p>Essayez un autre mot-clé, par exemple « CV », « carrière » ou « recrutement ».</p>
      </div>
    <?php else: ?>
      <p class="search-count"><?= $totalResults ?> résultat<?= $totalResults > 1 ? 's' : '' ?> pour <strong>« <?= esc($query) ?> »</strong></p>

      <?php
      $groups = [
          'formations' => ['label' => 'Formations', 'icon' => 'fa-graduation-cap', 'url' => static fn ($item) => site_url('formations/' . $item['slug']), 'description' => 'description_courte'],
          'ressources' => ['label' => 'Ressources', 'icon' => 'fa-file-lines', 'url' => static fn ($item) => site_url('ressources/' . $item['slug']), 'description' => 'description_courte'],
          'articles'   => ['label' => 'Actualités & articles', 'icon' => 'fa-newspaper', 'url' => static fn ($item) => site_url('actualites/' . \App\Models\NewsArticleModel::routeSlug($item['slug'])), 'description' => 'extrait'],
      ];
      foreach ($groups as $key => $group):
          if (empty($results[$key])) continue;
      ?>
        <section class="search-result-group" aria-labelledby="search-<?= esc($key) ?>">
          <h2 id="search-<?= esc($key) ?>"><i class="fa-solid <?= $group['icon'] ?>" aria-hidden="true"></i> <?= esc($group['label']) ?> <span><?= count($results[$key]) ?></span></h2>
          <div class="search-result-list">
            <?php foreach ($results[$key] as $item): ?>
              <a class="search-result" href="<?= esc($group['url']($item)) ?>">
                <span class="search-result-copy">
                  <strong><?= esc($item['titre']) ?></strong>
                  <?php if (!empty($item[$group['description']])): ?>
                    <span><?= esc(mb_substr(trim(strip_tags($item[$group['description']])), 0, 190)) ?><?= mb_strlen(trim(strip_tags($item[$group['description']]))) > 190 ? '…' : '' ?></span>
                  <?php endif; ?>
                </span>
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
              </a>
            <?php endforeach; ?>
          </div>
        </section>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>

<style>
  .sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}
  .search-page{max-width:900px;margin:0 auto}
  .search-page-form{display:flex;align-items:center;gap:14px;padding:8px 8px 8px 18px;border:1px solid var(--beige-dark);border-radius:8px;background:#fff;box-shadow:0 5px 18px rgba(31,31,31,.05)}
  .search-page-form>i{color:var(--rouge)}
  .search-page-form input{min-width:0;flex:1;border:0;outline:0;font-size:16px}
  .search-page-form input:focus{border:0}
  .search-page-form .btn-primary{white-space:nowrap}
  .search-hint,.search-count{margin:18px 0;color:var(--gris);font-size:14px}
  .search-result-group{margin-top:34px}
  .search-result-group h2{display:flex;align-items:center;gap:10px;padding-bottom:12px;border-bottom:1px solid var(--beige-dark);font:700 23px 'Playfair Display',serif}
  .search-result-group h2>i{color:var(--rouge);font-size:17px}
  .search-result-group h2>span{display:inline-flex;align-items:center;justify-content:center;min-width:25px;height:25px;padding:0 7px;border-radius:20px;background:var(--beige);font:600 12px 'DM Sans',sans-serif}
  .search-result-list{display:grid}
  .search-result{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:18px 4px;border-bottom:1px solid #eee9e1;color:var(--noir)}
  .search-result:hover .search-result-copy>strong{color:var(--rouge)}
  .search-result-copy{display:grid;gap:5px;min-width:0}
  .search-result-copy>strong{font-size:16px;transition:color .15s}
  .search-result-copy>span{color:var(--gris);font-size:13px;line-height:1.55}
  .search-result>i{color:var(--rouge);flex-shrink:0}
  .search-empty{padding:55px 15px;text-align:center;color:var(--gris)}
  .search-empty>i{font-size:30px;color:var(--sauge);margin-bottom:14px}
  .search-empty h2{font:700 24px 'Playfair Display',serif;color:var(--noir);margin-bottom:8px}
  .search-empty p{font-size:14px}
  @media(max-width:560px){.search-page-form{gap:9px;padding-left:12px}.search-page-form input{font-size:14px}.search-page-form .btn-primary{padding:10px 12px;font-size:13px}.search-result-group h2{font-size:20px}}
</style>
