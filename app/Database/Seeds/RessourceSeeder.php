<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RessourceSeeder extends Seeder
{
    public function run(): void
    {
        $ressources = [
            // Gratuites
            [
                'slug'               => 'checklist-entretien',
                'titre'              => 'Checklist entretien',
                'description_courte' => '50 points clés à vérifier avant, pendant et après votre entretien.',
                'type'               => 'checklist',
                'profil'             => 'tous',
                'prix'               => '0.000',
                'fichier_path'       => 'uploads/ressources/checklist-entretien.pdf',
                'is_premium'         => 0,
                'tag_badge'          => 'gratuit',
                'sort_order'         => 1,
            ],
            [
                'slug'               => 'template-lettre-motivation',
                'titre'              => 'Template lettre de motivation',
                'description_courte' => 'Modèle de lettre de motivation éditable, adapté au marché tunisien.',
                'type'               => 'template',
                'profil'             => 'junior',
                'prix'               => '0.000',
                'fichier_path'       => 'uploads/ressources/template-lm.docx',
                'is_premium'         => 0,
                'tag_badge'          => 'gratuit',
                'sort_order'         => 2,
            ],
            [
                'slug'               => '10-erreurs-cv-a-eviter',
                'titre'              => '10 erreurs CV à éviter',
                'description_courte' => 'Les 10 erreurs qui font rejeter votre CV dès les premières secondes.',
                'type'               => 'ebook',
                'profil'             => 'tous',
                'prix'               => '0.000',
                'fichier_path'       => 'uploads/ressources/10-erreurs-cv.pdf',
                'is_premium'         => 0,
                'tag_badge'          => 'gratuit',
                'sort_order'         => 3,
            ],
            // Premium
            [
                'slug'               => 'kit-candidat-complet',
                'titre'              => 'Kit candidat complet',
                'description_courte' => 'CV + Lettre de motivation + Checklist entretien. Tout pour réussir votre candidature.',
                'type'               => 'kit',
                'profil'             => 'junior',
                'prix'               => '49.000',
                'fichier_path'       => 'uploads/ressources/kit-candidat-complet.zip',
                'is_premium'         => 1,
                'tag_badge'          => 'populaire',
                'sort_order'         => 4,
            ],
            [
                'slug'               => 'guide-salaires-tunisie-2026',
                'titre'              => 'Guide salaires Tunisie 2026',
                'description_courte' => 'Grille complète par secteur et niveau pour négocier votre salaire.',
                'type'               => 'guide',
                'profil'             => 'tous',
                'prix'               => '29.000',
                'fichier_path'       => 'uploads/ressources/guide-salaires-2026.pdf',
                'is_premium'         => 1,
                'tag_badge'          => 'nouveau',
                'sort_order'         => 5,
            ],
            [
                'slug'               => 'kit-recruteur-professionnel',
                'titre'              => 'Kit recruteur professionnel',
                'description_courte' => 'Scripts d\'entretien, grilles d\'évaluation et templates de fiches de poste.',
                'type'               => 'kit',
                'profil'             => 'recruteur',
                'prix'               => '79.000',
                'fichier_path'       => 'uploads/ressources/kit-recruteur-pro.zip',
                'is_premium'         => 1,
                'tag_badge'          => 'premium',
                'sort_order'         => 6,
            ],
            [
                'slug'               => 'template-cv-ats',
                'titre'              => 'Template CV ATS',
                'description_courte' => 'Template Word + PDF optimisé pour les systèmes ATS. Compatible tous secteurs.',
                'type'               => 'template',
                'profil'             => 'tous',
                'prix'               => '19.000',
                'fichier_path'       => 'uploads/ressources/template-cv-ats.zip',
                'is_premium'         => 1,
                'tag_badge'          => 'premium',
                'sort_order'         => 7,
            ],
        ];

        $this->db->table('ressources')->insertBatch($ressources);
    }
}
