<?php
$isArabic = ($siteLocale ?? 'fr') === 'ar';
$isEnglish = ($siteLocale ?? 'fr') === 'en';
$text = $isArabic ? [
  'journal' => 'المقالات', 'title' => 'الأخبار والمقالات',
  'intro' => 'أفكار عملية لتطوير مسارك المهني وتحسين التوظيف وجذب المواهب.',
  'empty_title' => 'قريباً ستُنشر المقالات الأولى', 'empty_text' => 'ستجدون هنا نصائح عملية وأخباراً ومقاطع فيديو.',
  'article' => 'مقال', 'video' => 'فيديو', 'videos' => 'فيديوهات', 'read' => 'اقرأ المقال ←',
] : [
  'journal' => 'Le journal', 'title' => 'Actualités & articles',
  'intro' => 'Des idées concrètes pour faire évoluer votre carrière, recruter et attirer les talents.',
  'empty_title' => 'Les premiers articles arrivent bientôt', 'empty_text' => 'Retrouvez ici des conseils de terrain, des actualités et des vidéos.',
  'article' => 'Article', 'video' => 'vidéo', 'videos' => 'vidéos', 'read' => 'Lire l’article',
];
if ($isEnglish) {
  $text = array_replace($text, [
    'journal' => 'The journal', 'title' => 'News & articles',
    'intro' => 'Practical ideas to grow your career, improve hiring, and attract talent.',
    'empty_title' => 'The first articles are coming soon', 'empty_text' => 'Find practical advice, news, and videos here.',
    'article' => 'Article', 'video' => 'video', 'videos' => 'videos', 'read' => 'Read article',
  ]);
}
?>
<section class="page-header" style="background:var(--noir);color:#fff">
  <div class="page-header-inner">
    <span class="section-tag" style="color:var(--sauge)"><?= esc($text['journal']) ?></span>
    <h1 style="color:#fff"><?= esc($text['title']) ?></h1>
    <p style="color:rgba(255,255,255,.72)"><?= esc($text['intro']) ?></p>
  </div>
</section>

<section>
  <div style="max-width:1120px;margin:0 auto">
    <?php if (empty($articles)): ?>
      <div style="text-align:center;padding:4rem 1rem">
        <i class="fa-regular fa-newspaper" aria-hidden="true" style="font-size:34px;color:var(--sauge);margin-bottom:1rem"></i>
        <h2 style="font-family:'Playfair Display',serif"><?= esc($text['empty_title']) ?></h2>
        <p style="color:var(--gris)"><?= esc($text['empty_text']) ?></p>
      </div>
    <?php else: ?>
      <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,300px),1fr));gap:20px">
        <?php foreach ($articles as $article): ?>
          <?php $videos = \App\Models\NewsArticleModel::videoUrlsFromStored($article['video_urls'] ?? ''); ?>
          <article style="background:#fff;border:1px solid var(--beige-dark);border-radius:12px;overflow:hidden;display:flex;flex-direction:column;min-height:240px">
            <a href="<?= site_url('actualites/' . \App\Models\NewsArticleModel::routeSlug($article['slug'])) ?>" tabindex="-1" aria-hidden="true" style="display:block;aspect-ratio:16/9;background:var(--beige);overflow:hidden">
              <img src="<?= base_url(esc($article['thumbnail'] ?: 'assets/img/yesmine-hero.png')) ?>" alt="" loading="lazy" style="display:block;width:100%;height:100%;object-fit:cover">
            </a>
            <div style="padding:20px 24px 24px;display:flex;flex:1;flex-direction:column">
            <div style="display:flex;align-items:center;gap:8px;color:var(--gris);font-size:12px;margin-bottom:14px">
              <span style="color:var(--rouge);font-weight:700;text-transform:uppercase"><?= esc($text['article']) ?></span>
              <span aria-hidden="true">·</span>
              <time datetime="<?= esc(date('c', strtotime($article['published_at']))) ?>"><?= esc(date('d/m/Y', strtotime($article['published_at']))) ?></time>
              <?php if ($videos): ?><span style="margin-left:auto;color:var(--sauge)"><i class="fa-brands fa-facebook" aria-hidden="true"></i> <?= count($videos) ?> <?= esc(count($videos) > 1 ? $text['videos'] : $text['video']) ?></span><?php endif; ?>
            </div>
            <h2 style="font-family:'Playfair Display',serif;font-size:23px;line-height:1.25;margin:0 0 12px"><?= esc($article['titre']) ?></h2>
            <p style="color:var(--gris);font-size:14px;line-height:1.7;margin:0 0 24px;flex:1"><?= esc($article['extrait'] ?: mb_substr(trim(strip_tags($article['contenu'])), 0, 180) . '…') ?></p>
            <a href="<?= site_url('actualites/' . \App\Models\NewsArticleModel::routeSlug($article['slug'])) ?>" style="color:var(--rouge);font-weight:700;font-size:14px;text-decoration:none"><?= esc($text['read']) ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
