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
        $isArabic = ($this->viewData['siteLocale'] ?? 'fr') === 'ar';
        return $this->render('pages/a-propos', [
            'page_title'       => $isArabic ? 'من أنا — ياسمين الغربي' : 'À propos — Yesmine Gharbi',
            'page_description' => $isArabic ? 'تعرفوا على مسيرة ياسمين الغربي وفلسفتها ورسالتها في مجال التوظيف وصناعة المحتوى.' : 'Parcours, philosophie et mission de Yesmine Gharbi, spécialiste recrutement et créatrice de contenu.',
            'settings'         => $this->settings(),
        ]);
    }

    public function entreprises(): string
    {
        $isArabic = ($this->viewData['siteLocale'] ?? 'fr') === 'ar';
        return $this->render('pages/entreprises', [
            'page_title'       => $isArabic ? 'للشركات — ياسمين الغربي' : 'Entreprises — Yesmine Gharbi',
            'page_description' => $isArabic ? 'طوّروا علامتكم كجهة عمل، ودرّبوا فرق الموارد البشرية، وروّجوا لشركتكم لدى جمهور متخصص.' : 'Marque employeur, formations RH sur-mesure et promotion auprès d\'une audience qualifiée.',
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
