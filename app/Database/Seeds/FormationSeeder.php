<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FormationSeeder extends Seeder
{
    public function run(): void
    {
        $formations = [
            [
                'slug'               => 'cv-parfait-decrocher-entretien',
                'titre'              => 'CV Parfait : décrocher un entretien en 7 jours',
                'description_courte' => 'Créez un CV ATS-friendly, percutant et adapté au marché tunisien et francophone.',
                'description_longue' => 'Dans cette formation complète, vous apprendrez à créer un CV qui passe les filtres ATS, attire l\'attention des recruteurs et vous démarque des autres candidats. Basée sur l\'expérience terrain du marché tunisien.',
                'prix'               => '149.000',
                'niveau'             => 'junior',
                'theme'              => 'cv',
                'statut'             => 'disponible',
                'modules_count'      => 6,
                'heures'             => '4h 30min',
                'is_populaire'       => 0,
                'sort_order'         => 1,
            ],
            [
                'slug'               => 'maitriser-entretien-recrutement',
                'titre'              => 'Maîtriser l\'entretien de recrutement',
                'description_courte' => 'Préparez chaque type d\'entretien : RH, technique, mise en situation, et négociation de salaire.',
                'description_longue' => 'Une formation complète pour ne plus jamais être pris au dépourvu en entretien. Techniques STAR, gestion du stress, négociation salariale — tout y est.',
                'prix'               => '199.000',
                'niveau'             => 'tous',
                'theme'              => 'entretien',
                'statut'             => 'disponible',
                'modules_count'      => 8,
                'heures'             => '6h',
                'is_populaire'       => 1,
                'sort_order'         => 2,
            ],
            [
                'slug'               => 'linkedin-pro-visibilite-opportunites',
                'titre'              => 'LinkedIn Pro : visibilité et opportunités',
                'description_courte' => 'Transformez votre profil LinkedIn en machine à opportunités professionnelles.',
                'description_longue' => 'Optimisation complète de votre profil, stratégie de contenu et techniques de networking sur LinkedIn pour attirer les recruteurs.',
                'prix'               => '149.000',
                'niveau'             => 'tous',
                'theme'              => 'branding',
                'statut'             => 'bientot',
                'modules_count'      => 5,
                'heures'             => '3h',
                'is_populaire'       => 0,
                'sort_order'         => 3,
            ],
        ];

        $this->db->table('formations')->insertBatch($formations);
    }
}
