<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ContentUpdateResourcesAndSettings extends Migration
{
    public function up(): void
    {
        $db = \Config\Database::connect();

        if ($db->tableExists('ressources')) {
            // 'ebook' is kept so existing rows stay valid.
            $db->query("ALTER TABLE ressources MODIFY `type` ENUM('guide','template','checklist','ebook','kit','atelier','methode') NOT NULL DEFAULT 'guide'");

            $fields = [];
            if (! $db->fieldExists('thematique', 'ressources')) {
                $fields['thematique'] = ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true, 'after' => 'profil'];
            }
            if (! $db->fieldExists('thematiques_secondaires', 'ressources')) {
                $fields['thematiques_secondaires'] = ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'thematique'];
            }
            if ($fields !== []) {
                $this->forge->addColumn('ressources', $fields);
            }

            $now    = date('Y-m-d H:i:s');
            $offers = [
                [
                    'slug'                    => 'career-knowledge-base',
                    'titre'                   => 'Career Knowledge Base',
                    'description_courte'      => 'Un guide pour mieux comprendre sa carrière, développer ses compétences et prendre de meilleures décisions professionnelles, avec une nouvelle façon d’utiliser l’IA pour avancer plus intelligemment.',
                    'type'                    => 'guide',
                    'thematique'              => 'carriere',
                    'thematiques_secondaires' => 'ia-carriere,apprentissage-formation',
                ],
                [
                    'slug'                    => 'the-smarter-job-search',
                    'titre'                   => 'The Smarter Job Search',
                    'description_courte'      => 'Un atelier pour apprendre à trouver les bonnes opportunités en Tunisie ou à l’étranger, optimiser sa recherche et gagner un temps précieux grâce à l’IA.',
                    'type'                    => 'atelier',
                    'thematique'              => 'recherche-emploi',
                    'thematiques_secondaires' => 'ia-carriere',
                ],
            ];
            foreach ($offers as $offer) {
                if ($db->table('ressources')->where('slug', $offer['slug'])->countAllResults() > 0) {
                    continue;
                }
                $db->table('ressources')->insert($offer + [
                    'profil'     => 'tous',
                    'is_premium' => 1,
                    'tag_badge'  => 'premium',
                    'prix'       => 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        if ($db->tableExists('settings')) {
            $settings = [
                'tiktok_url'          => 'https://www.tiktok.com/@yesmine_gharbi',
                'tiktok_followers'    => '55K',
                'instagram_url'       => 'https://www.instagram.com/yesmine_gharbi/?hl=fr',
                'instagram_followers' => '83K',
                'linkedin_url'        => 'https://www.linkedin.com/in/yesmine-gharbi/',
                'linkedin_followers'  => '28K',
                'facebook_url'        => 'https://www.facebook.com/yesmineegharbi/',
                'facebook_followers'  => '49K',
                'email'               => 'yesminegharbipro@gmail.com',
            ];
            foreach ($settings as $key => $value) {
                $db->query(
                    'INSERT INTO settings (`key`, `value`, `updated_at`) VALUES (?, ?, NOW())
                     ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = NOW()',
                    [$key, $value]
                );
            }
        }
    }

    public function down(): void
    {
        $db = \Config\Database::connect();

        if (! $db->tableExists('ressources')) {
            return;
        }

        foreach (['thematiques_secondaires', 'thematique'] as $field) {
            if ($db->fieldExists($field, 'ressources')) {
                $this->forge->dropColumn('ressources', $field);
            }
        }
    }
}
