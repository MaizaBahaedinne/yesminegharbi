<?php

namespace App\Controllers;

use App\Models\RessourceModel;

class Ressources extends BaseController
{
    private RessourceModel $model;

    public function __construct()
    {
        $this->model = new RessourceModel();
    }

    public function gratuites(): string
    {
        $data = [
            'page_title'       => 'Ressources Gratuites — Yesmine Gharbi',
            'page_description' => 'Téléchargez gratuitement des guides, templates CV et checklists pour booster votre carrière.',
            'ressources'       => $this->model->getFree(),
        ];

        return $this->render('pages/ressources-gratuites', $data);
    }

    public function premium(): string
    {
        $type  = $this->request->getGet('type');
        $profil = $this->request->getGet('profil');

        $data = [
            'page_title'       => 'Ressources Premium — Yesmine Gharbi',
            'page_description' => 'Guides approfondis, templates et kits complets pour candidats et recruteurs.',
            'ressources'       => $this->model->getPremium(null, $type, $profil),
            'active_type'      => $type   ?? 'tous',
            'active_profil'    => $profil ?? 'tous',
        ];

        return $this->render('pages/ressources-premium', $data);
    }

    public function detail(string $slug): string
    {
        $ressource = $this->model->getBySlug($slug);

        if (! $ressource) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'page_title'       => $ressource['titre'] . ' — Ressources · Yesmine Gharbi',
            'page_description' => $ressource['description_courte'],
            'ressource'        => $ressource,
        ];

        return $this->render('pages/ressource-detail', $data);
    }
}
