<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function apropos(): string
    {
        return $this->render('pages/a-propos', [
            'page_title'       => 'À propos — Yesmine Gharbi',
            'page_description' => 'Parcours, philosophie et mission de Yesmine Gharbi, spécialiste recrutement et créatrice de contenu.',
        ]);
    }

    public function entreprises(): string
    {
        return $this->render('pages/entreprises', [
            'page_title'       => 'Entreprises — Yesmine Gharbi',
            'page_description' => 'Marque employeur, formations RH sur-mesure et promotion auprès d\'une audience qualifiée.',
        ]);
    }

    public function contact(): string
    {
        return $this->render('pages/contact', [
            'page_title'       => 'Contact — Yesmine Gharbi',
            'page_description' => 'Contactez Yesmine Gharbi pour toute collaboration ou question.',
        ]);
    }

    public function confirmation(): string
    {
        return $this->render('pages/confirmation', [
            'page_title' => 'Confirmation — Yesmine Gharbi',
        ]);
    }
}
