<?php

namespace App\Controllers;

use App\Models\FormationModel;
use App\Models\NewsArticleModel;
use App\Models\RessourceModel;

class Search extends BaseController
{
    public function index(): string
    {
        $query = trim(strip_tags((string) $this->request->getGet('q')));
        $query = mb_substr($query, 0, 100);
        $results = ['formations' => [], 'ressources' => [], 'articles' => []];

        if (mb_strlen($query) >= 2) {
            $formations = new FormationModel();
            $results['formations'] = $formations
                ->groupStart()
                    ->like('titre', $query)
                    ->orLike('description_courte', $query)
                    ->orLike('description_longue', $query)
                    ->orLike('objectifs', $query)
                ->groupEnd()
                ->where('statut !=', 'archive')
                ->orderBy('sort_order', 'ASC')
                ->findAll(8);

            $ressources = new RessourceModel();
            $results['ressources'] = $ressources
                ->groupStart()
                    ->like('titre', $query)
                    ->orLike('description_courte', $query)
                    ->orLike('description_longue', $query)
                    ->orLike('thematique', $query)
                ->groupEnd()
                ->orderBy('sort_order', 'ASC')
                ->findAll(8);

            $articles = new NewsArticleModel();
            $results['articles'] = $articles
                ->where('statut', 'publie')
                ->where('published_at <=', date('Y-m-d H:i:s'))
                ->groupStart()
                    ->like('titre', $query)
                    ->orLike('extrait', $query)
                    ->orLike('contenu', $query)
                ->groupEnd()
                ->orderBy('published_at', 'DESC')
                ->findAll(8);
        }

        return $this->render('pages/search', [
            'page_title'       => ($query !== '' ? 'Recherche : ' . $query . ' — ' : '') . 'Yesmine Gharbi',
            'page_description' => 'Recherchez des formations, ressources et articles sur le site Yesmine Gharbi.',
            'query'             => $query,
            'results'           => $results,
            'hasSearched'       => $query !== '',
        ]);
    }
}
