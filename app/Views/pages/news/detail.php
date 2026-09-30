<?php
$paragraphs = preg_split('/\R{2,}/u', trim((string) $article['contenu'])) ?: [];
?>
<article>
  <header class="page-header" style="background:var(--noir);color:#fff">
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
      <div style="font-size:17px;line-height:1.9;color:#343434">
        <?php foreach ($paragraphs as $paragraph): ?>
          <?php if (trim($paragraph) !== ''): ?><p style="margin:0 0 1.25rem"><?= nl2br(esc(trim($paragraph))) ?></p><?php endif; ?>
        <?php endforeach; ?>
      </div>

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
