<?php

namespace App\Controllers;

use App\Models\FormationModel;
use App\Models\RessourceModel;

class Home extends BaseController
{
    public function index(): string
    {
        $formationModel = new FormationModel();
        $ressourceModel = new RessourceModel();

        $data = [
            'page_title'       => 'Yesmine Gharbi — Experte Recrutement & Personal Branding',
            'page_description' => 'Formations, ressources et conseils recrutement par Yesmine Gharbi. Des conseils du terrain, pas des manuels.',
            'formations'       => $formationModel->getAll(3),
            'ressources_free'  => $ressourceModel->getFree(3),
            'ressources_premium' => $ressourceModel->getPremium(4),
        ];

        return $this->render('pages/home', $data);
    }
}
