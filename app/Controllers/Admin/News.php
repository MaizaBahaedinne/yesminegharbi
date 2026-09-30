<?php

namespace App\Controllers\Admin;

use App\Models\NewsArticleModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class News extends BaseAdminController
{
    private NewsArticleModel $model;

    public function __construct()
    {
        $this->model = new NewsArticleModel();
    }

    public function index()
    {
        return $this->render('admin/news/index', [
            'title'    => 'Actualités',
            'articles' => $this->model->orderBy('updated_at', 'DESC')->findAll(),
        ]);
    }

    public function create()
    {
        return $this->render('admin/news/form', ['title' => 'Nouvel article', 'article' => null]);
    }

    public function store()
    {
        $data = $this->formData();
        if (is_string($data)) {
            return redirect()->back()->withInput()->with('error', $data);
        }
        $data['slug'] = $this->uniqueSlug($data['titre']);
        $data['published_at'] = $data['statut'] === 'publie' ? date('Y-m-d H:i:s') : null;
        $this->model->insert($data);

        return redirect()->to(base_url('admin/news'))->with('success', 'Article créé.');
    }

    public function edit(int $id)
    {
        $article = $this->model->find($id);
        if (! $article) {
            throw PageNotFoundException::forPageNotFound();
        }
        $article['video_urls'] = implode("\n", NewsArticleModel::videoUrlsFromStored($article['video_urls'] ?? ''));

        return $this->render('admin/news/form', ['title' => 'Modifier l’article', 'article' => $article]);
    }

    public function update(int $id)
    {
        $article = $this->model->find($id);
        if (! $article) {
            throw PageNotFoundException::forPageNotFound();
        }
        $data = $this->formData();
        if (is_string($data)) {
            return redirect()->back()->withInput()->with('error', $data);
        }
        $data['slug'] = $this->uniqueSlug($data['titre'], $id);
        $data['published_at'] = $data['statut'] === 'publie'
            ? ($article['published_at'] ?: date('Y-m-d H:i:s'))
            : null;
        $this->model->update($id, $data);

        return redirect()->to(base_url('admin/news'))->with('success', 'Article mis à jour.');
    }

    public function delete(int $id)
    {
        $this->model->delete($id);

        return redirect()->to(base_url('admin/news'))->with('success', 'Article supprimé.');
    }

    private function formData(): array|string
    {
        $titre = trim(strip_tags((string) $this->request->getPost('titre')));
        $contenu = trim(strip_tags((string) $this->request->getPost('contenu')));
        $videoInput = trim((string) $this->request->getPost('video_urls'));
        $videoUrls = NewsArticleModel::facebookVideoUrls($videoInput);

        if ($titre === '') {
            return 'Le titre est obligatoire.';
        }
        if ($contenu === '') {
            return 'Le contenu de l’article est obligatoire.';
        }
        if ($videoInput !== '' && $videoUrls === []) {
            return 'Ajoutez uniquement des liens vidéo publics Facebook valides, un par ligne.';
        }

        $statut = (string) $this->request->getPost('statut');
        if (! in_array($statut, ['brouillon', 'publie'], true)) {
            $statut = 'brouillon';
        }

        return [
            'titre'      => mb_substr($titre, 0, 220),
            'extrait'    => mb_substr(trim(strip_tags((string) $this->request->getPost('extrait'))), 0, 1000),
            'contenu'    => mb_substr($contenu, 0, 100000),
            'video_urls' => $videoUrls ? json_encode($videoUrls, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : null,
            'statut'     => $statut,
        ];
    }

    private function uniqueSlug(string $titre, ?int $exceptId = null): string
    {
        $base = url_title($titre, '-', true) ?: 'article';
        $slug = mb_substr($base, 0, 170);
        $suffix = 2;

        while (true) {
            $existing = $this->model->where('slug', $slug)->first();
            if (! $existing || (int) $existing['id'] === $exceptId) {
                return $slug;
            }
            $slug = mb_substr($base, 0, 180) . '-' . $suffix++;
        }
    }
}
