<?php

namespace App\Controllers;

use App\Models\SettingsModel;
use App\Models\PartnerModel;

class Pages extends BaseController
{
    private function settings(): array
    {
        return (new SettingsModel())->getAll();
    }

    public function apropos(): string
    {
        $locale = $this->viewData['siteLocale'] ?? 'fr';
        return $this->render('pages/a-propos', [
            'page_title'       => $locale === 'ar' ? 'من أنا — ياسمين الغربي' : ($locale === 'en' ? 'About — Yesmine Gharbi' : 'À propos — Yesmine Gharbi'),
            'page_description' => $locale === 'ar' ? 'تعرفوا على مسيرة ياسمين الغربي وفلسفتها ورسالتها في مجال التوظيف وصناعة المحتوى.' : ($locale === 'en' ? 'Learn about Yesmine Gharbi’s background, approach, and work in recruitment and content creation.' : 'Parcours, philosophie et mission de Yesmine Gharbi, spécialiste recrutement et créatrice de contenu.'),
            'settings'         => $this->settings(),
        ]);
    }

    public function entreprises(): string
    {
        $locale = $this->viewData['siteLocale'] ?? 'fr';
        return $this->render('pages/entreprises', [
            'page_title'       => $locale === 'ar' ? 'للشركات — ياسمين الغربي' : ($locale === 'en' ? 'For companies — Yesmine Gharbi' : 'Entreprises — Yesmine Gharbi'),
            'page_description' => $locale === 'ar' ? 'طوّروا علامتكم كجهة عمل، ودرّبوا فرق الموارد البشرية، وروّجوا لشركتكم لدى جمهور متخصص.' : ($locale === 'en' ? 'Employer branding, tailored HR training, and promotion to a qualified audience.' : 'Marque employeur, formations RH sur-mesure et promotion auprès d\'une audience qualifiée.'),
            'settings'         => $this->settings(),
            'partners'         => (new PartnerModel())->activePartners(),
        ]);
    }

    public function contact(): string
    {
        return $this->render('pages/contact', [
            'page_title'       => 'Contact — Yesmine Gharbi',
            'page_description' => 'Contactez Yesmine Gharbi pour toute collaboration ou question.',
            'settings'         => $this->settings(),
        ]);
    }

    public function confirmation(): string
    {
        return $this->render('pages/confirmation', [
            'page_title' => 'Confirmation — Yesmine Gharbi',
        ]);
    }
}
