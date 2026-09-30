<?php
$thumbnailUrl = base_url($article['thumbnail'] ?: 'assets/img/yesmine-hero.png');
$content = html_entity_decode((string) $article['contenu'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
$content = preg_replace_callback(
  '~(?<![\p{L}\d>])([4-6]\.\s*[^<\r\n]{5,120}?\(/\d+\))~u',
  static fn (array $match): string => '<h2>' . htmlspecialchars($match[1], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</h2>',
  $content
);
$content = preg_replace('/\s*•\s*/u', '<br>• ', $content);
$content = \App\Models\NewsArticleModel::sanitizeContent($content);
$content = preg_replace_callback(
  '~(Problème majeur si score\s*&lt;\s*\d+\s*:?)~iu',
  static fn (array $match): string => '<br><strong>' . $match[1] . '</strong>',
  $content
);
?>
<article>
  <header class="page-header news-hero" style="background-image:linear-gradient(90deg,rgba(15,15,15,.88),rgba(15,15,15,.38)),url('<?= esc($thumbnailUrl) ?>');color:#fff">
    <div class="page-header-inner" style="max-width:900px">
      <a href="<?= site_url('actualites') ?>" style="color:var(--sauge);font-size:14px;text-decoration:none"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Actualités</a>
      <div style="color:rgba(255,255,255,.65);font-size:13px;margin-top:24px">
        <time datetime="<?= esc(date('c', strtotime($article['published_at']))) ?>"><?= esc(date('d/m/Y', strtotime($article['published_at']))) ?></time>
        <?php if ($videoUrls): ?><span> · <i class="fa-brands fa-facebook" aria-hidden="true"></i> <?= count($videoUrls) ?> vidéo<?= count($videoUrls) > 1 ? 's' : '' ?></span><?php endif; ?>
      </div>
      <h1 style="color:#fff;margin-top:12px"><?= esc($article['titre']) ?></h1>
      <?php if (!empty($article['extrait'])): ?><p style="color:rgba(255,255,255,.75);font-size:17px;line-height:1.65;margin-top:16px"><?= esc($article['extrait']) ?></p><?php endif; ?>
    </div>
  </header>

  <section>
    <div style="max-width:800px;margin:0 auto">
      <div class="news-article-content" style="font-size:17px;line-height:1.9;color:#343434"><?= $content ?></div>

      <?php foreach ($videoUrls as $index => $videoUrl): ?>
        <?php $embedUrl = 'https://www.facebook.com/plugins/video.php?href=' . rawurlencode($videoUrl) . '&show_text=false&width=640'; ?>
        <figure style="margin:2rem 0 0">
          <div style="position:relative;width:100%;aspect-ratio:16/9;background:#111;border-radius:12px;overflow:hidden">
            <iframe src="<?= esc($embedUrl) ?>" title="Vidéo Facebook <?= $index + 1 ?> — <?= esc($article['titre']) ?>" style="position:absolute;inset:0;width:100%;height:100%;border:0" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" allowfullscreen loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
          </div>
          <figcaption style="font-size:12px;color:var(--gris);margin-top:8px">Vidéo Facebook · <?= $index + 1 ?></figcaption>
        </figure>
      <?php endforeach; ?>

      <div style="border-top:1px solid var(--beige-dark);margin-top:3rem;padding-top:1.5rem">
        <a href="<?= site_url('actualites') ?>" class="btn-secondary" style="display:inline-flex;text-decoration:none"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Tous les articles</a>
      </div>
    </div>
  </section>
</article>

<style>
  .news-hero{position:relative;isolation:isolate;min-height:440px;display:flex;align-items:flex-end;background-color:var(--noir);background-position:center 38%;background-size:cover;border:0}
  .news-hero::before{content:"";position:absolute;inset:0;background:linear-gradient(0deg,rgba(15,15,15,.58),transparent 72%);z-index:-1}
  .news-hero .page-header-inner{width:100%;margin:0 auto}
  .news-article-content h2{font-family:'Playfair Display',serif;font-size:23px;line-height:1.35;color:var(--noir);margin:2.25rem 0 .75rem;padding-bottom:.45rem;border-bottom:1px solid var(--beige-dark)}
  .news-article-content p{margin:0 0 1.25rem}
  .news-article-content blockquote{margin:1rem 0;padding:.75rem 1rem;border-left:3px solid var(--rouge);background:var(--beige);color:var(--gris)}
  @media(max-width:600px){.news-hero{min-height:360px;background-position:center}.news-article-content h2{font-size:20px}}
</style>
