<?php

namespace App\Controllers\Admin;

use App\Models\FormationModel;
use App\Models\RessourceModel;
use App\Models\NewsletterModel;

class Dashboard extends BaseAdminController
{
    public function index()
    {
        $formationModel  = new FormationModel();
        $ressourceModel  = new RessourceModel();
        $newsletterModel = new NewsletterModel();

        $db = \Config\Database::connect();

        $data = [
            'title'          => 'Tableau de bord',
            'nb_formations'  => $formationModel->countAll(),
            'nb_ressources'  => $ressourceModel->countAll(),
            'nb_abonnes'     => $newsletterModel->countAll(),
            'nb_messages'    => $db->table('contact_messages')->countAll(),
            'last_messages'  => $db->table('contact_messages')->orderBy('created_at', 'DESC')->limit(5)->get()->getResultArray(),
            'last_abonnes'   => $db->table('newsletter_subscribers')->orderBy('created_at', 'DESC')->limit(5)->get()->getResultArray(),
        ];

        return $this->render('admin/dashboard', $data);
    }
}
