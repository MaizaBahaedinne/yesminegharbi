<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddThumbnailToNewsArticles extends Migration
{
    public function up(): void
    {
        if (! $this->db->tableExists('news_articles')) {
            return;
        }

        if (! $this->db->fieldExists('thumbnail', 'news_articles')) {
            $this->forge->addColumn('news_articles', [
                'thumbnail' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'extrait'],
            ]);
        }

        $this->db->table('news_articles')
            ->where('thumbnail', null)
            ->orWhere('thumbnail', '')
            ->update(['thumbnail' => 'assets/img/yesmine-hero.png']);
    }

    public function down(): void
    {
        if ($this->db->tableExists('news_articles') && $this->db->fieldExists('thumbnail', 'news_articles')) {
            $this->forge->dropColumn('news_articles', 'thumbnail');
        }
    }
}
