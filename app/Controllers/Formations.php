<?php

namespace App\Controllers;

use App\Models\FormationModel;

class Formations extends BaseController
{
    private FormationModel $model;

    public function __construct()
    {
        $this->model = new FormationModel();
    }

    public function index(): string
    {
        $niveau = $this->request->getGet('niveau');
        $theme  = $this->request->getGet('theme');
        $locale = $this->viewData['siteLocale'] ?? 'fr';

        $data = [
            'page_title'       => $locale === 'ar' ? 'التدريبات — ياسمين الغربي' : ($locale === 'en' ? 'Training — Yesmine Gharbi' : 'Formations — Yesmine Gharbi'),
            'page_description' => $locale === 'ar' ? 'تدريبات عملية في التوظيف والسيرة الذاتية والمقابلات وبناء العلامة الشخصية.' : ($locale === 'en' ? 'Practical training in recruitment, CVs, interviews, and personal branding.' : 'Catalogue des formations en recrutement, CV, entretien et personal branding.'),
            'formations'       => $this->model->getFiltered($niveau, $theme),
            'active_niveau'    => $niveau ?? 'tous',
            'active_theme'     => $theme  ?? 'tous',
        ];

        return $this->render('pages/formations', $data);
    }

    public function detail(string $slug): string
    {
        $formation = $this->model->getBySlug($slug);

        if (! $formation) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'page_title'       => $formation['titre'] . ' — Formations · Yesmine Gharbi',
            'page_description' => $formation['description_courte'],
            'formation'        => $formation,
            'modules'          => $this->model->getModules($formation['id']),
        ];

        return $this->render('pages/formation-detail', $data);
    }
}
