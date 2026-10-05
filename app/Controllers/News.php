<?php

namespace App\Controllers;

use App\Models\NewsArticleModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class News extends BaseController
{
    private NewsArticleModel $model;

    public function __construct()
    {
        $this->model = new NewsArticleModel();
    }

    public function index(): string
    {
        $articles = $this->model->published();
        $locale = $this->viewData['siteLocale'] ?? 'fr';

        return $this->render('pages/news/index', [
            'page_title'       => $locale === 'ar' ? 'الأخبار والمقالات — ياسمين الغربي' : ($locale === 'en' ? 'News & articles — Yesmine Gharbi' : 'Actualités & articles — Yesmine Gharbi'),
            'page_description' => $locale === 'ar' ? 'نصائح عملية حول المسار المهني والتوظيف والعلامة كجهة عمل.' : ($locale === 'en' ? 'Practical advice on careers, recruitment, and employer branding.' : 'Conseils concrets sur la carrière, le recrutement et la marque employeur.'),
            'articles'         => $articles,
        ]);
    }

    public function detail(string $slug): string
    {
        $article = $this->model->bySlug($slug);
        if (! $article) {
            throw PageNotFoundException::forPageNotFound();
        }

        $canonicalSlug = NewsArticleModel::routeSlug((string) $article['slug']);
        if ($slug !== $canonicalSlug) {
            return redirect()->to(site_url('actualites/' . $canonicalSlug), 301);
        }

        return $this->render('pages/news/detail', [
            'page_title'       => $article['titre'] . ' — Actualités · Yesmine Gharbi',
            'page_description' => $article['extrait'] ?: mb_substr(trim(strip_tags($article['contenu'])), 0, 160),
            'og_image'         => base_url($article['thumbnail'] ?: 'assets/img/yesmine-hero.png'),
            'article'          => $article,
            'videoUrls'        => NewsArticleModel::videoUrlsFromStored($article['video_urls'] ?? ''),
        ]);
    }
}
