<?php

namespace App\Libraries;

use App\Models\CvModel;

/**
 * Rule-based ATS compatibility score (0–100) of a structured CV against a job offer.
 * Structure 35 pts · content quality 25 pts · match with the offer 40 pts.
 */
class CvAtsScorer
{
    private const STOPWORDS = [
        // fr
        'les', 'des', 'une', 'un', 'le', 'la', 'de', 'du', 'et', 'ou', 'en', 'au', 'aux', 'pour', 'par', 'sur', 'avec', 'sans', 'dans', 'est', 'sont',
        'ce', 'ces', 'cette', 'qui', 'que', 'quoi', 'dont', 'nous', 'vous', 'votre', 'vos', 'notre', 'nos', 'leur', 'leurs', 'son', 'ses', 'sa',
        'il', 'elle', 'ils', 'elles', 'etre', 'avoir', 'plus', 'tres', 'bien', 'tout', 'tous', 'toute', 'toutes', 'afin', 'ainsi', 'comme', 'etc',
        'pas', 'ne', 'se', 'si', 'mais', 'donc', 'car', 'entre', 'vers', 'chez', 'lors', 'selon', 'aussi', 'meme', 'autres', 'autre', 'fait',
        'poste', 'profil', 'mission', 'missions', 'entreprise', 'societe', 'candidat', 'candidate', 'recherchons', 'recherche', 'rejoindre',
        'annee', 'annees', 'ans', 'minimum', 'souhaite', 'souhaitee', 'requis', 'requise', 'offre', 'emploi', 'cdi', 'cdd', 'h/f', 'f/h',
        'sein', 'equipe', 'serez', 'aurez', 'devez', 'capable', 'capacite', 'bonne', 'bonnes', 'bon', 'bons', 'excellent', 'excellente',
        'nouveau', 'nouveaux', 'nouvelle', 'nouvelles', 'maitrise', 'maitriser', 'outil', 'outils', 'essentiel', 'essentiels', 'essentielle',
        'courant', 'collaborateur', 'collaborateurs', 'collaboratrice', 'idealement', 'serait', 'atout', 'plus', 'niveau', 'connaissance', 'connaissances',
        // en
        'the', 'and', 'for', 'with', 'you', 'your', 'our', 'are', 'will', 'from', 'this', 'that', 'have', 'has', 'can', 'all', 'any', 'who',
        'job', 'role', 'team', 'company', 'work', 'working', 'years', 'year', 'experience', 'strong', 'good', 'ability', 'able', 'must',
        'join', 'looking', 'including', 'within', 'about', 'what', 'into', 'their', 'they', 'we', 'us', 'be', 'is', 'of', 'to', 'in', 'on',
        'an', 'as', 'at', 'or', 'by', 'it', 'etc', 'plus', 'well', 'new', 'more', 'other', 'such', 'also', 'based', 'required', 'preferred',
        // ar
        'في', 'من', 'على', 'الى', 'الي', 'عن', 'مع', 'او', 'ان', 'هذا', 'هذه', 'التي', 'الذي', 'كل', 'ذلك', 'بين', 'لدى', 'لدي', 'حيث', 'عند',
        'كما', 'ضمن', 'خلال', 'وظيفه', 'مطلوب', 'سنوات', 'خبره', 'فريق', 'شركه',
    ];

    private const ACTION_VERBS = [
        'fr' => ['gere', 'pilote', 'dirige', 'cree', 'developpe', 'concu', 'optimise', 'augmente', 'reduit', 'recrute', 'forme',
            'organise', 'coordonne', 'lance', 'negocie', 'analyse', 'ameliore', 'realise', 'supervise', 'encadre', 'deploye', 'automatise',
            'redige', 'conduit', 'accompagne', 'elabore', 'implemente', 'assure', 'pilotage', 'gestion', 'creation', 'developpement',
            'mise', 'animation', 'conception', 'realisation', 'optimisation', 'coordination', 'suivi', 'elaboration', 'negociation', 'recrutement'],
        'en' => ['managed', 'led', 'created', 'developed', 'designed', 'built', 'launched', 'increased', 'reduced', 'improved', 'recruited',
            'trained', 'organized', 'coordinated', 'negotiated', 'analyzed', 'implemented', 'delivered', 'achieved', 'supervised',
            'automated', 'drove', 'owned', 'wrote', 'conducted', 'streamlined', 'optimized', 'established', 'generated', 'handled'],
        'ar' => ['اداره', 'قياده', 'تطوير', 'انشاء', 'تصميم', 'تنظيم', 'تنسيق', 'تحليل', 'تحسين', 'زياده', 'تخفيض', 'توظيف', 'تدريب',
            'اشراف', 'تنفيذ', 'اعداد', 'متابعه', 'ادرت', 'قدت', 'طورت', 'انشات', 'صممت', 'نظمت', 'حققت', 'اشرفت', 'نفذت'],
    ];

    public function score(array $cv, string $lang, string $offerText, string $jobTitle): array
    {
        $sections = [$this->structure($cv), $this->quality($cv, $lang)];
        $match = $this->match($cv, $offerText, $jobTitle);
        $sections[] = $match['section'];

        $total = (int) round(array_sum(array_column($sections, 'points')));

        return [
            'score'    => max(0, min(100, $total)),
            'sections' => $sections,
            'matched'  => $match['matched'],
            'missing'  => $match['missing'],
        ];
    }

    private function structure(array $cv): array
    {
        $p = $cv['personal'];
        $pts = 0;
        $tips = [];

        $checks = [
            [$p['full_name'] !== '', 3, 'Indiquez votre nom complet en haut du CV.'],
            [filter_var($p['email'], FILTER_VALIDATE_EMAIL) !== false, 3, 'Ajoutez une adresse e-mail valide et professionnelle.'],
            [preg_match('/\d{6,}/', preg_replace('/\D/', '', $p['phone'])) === 1, 3, 'Ajoutez un numéro de téléphone (avec indicatif, ex. +216).'],
            [$p['city'] !== '', 2, 'Indiquez votre ville : beaucoup de recruteurs filtrent par localisation.'],
            [$p['linkedin'] !== '', 2, 'Ajoutez le lien vers votre profil LinkedIn.'],
            [$p['headline'] !== '', 3, 'Ajoutez un titre de poste sous votre nom (ex. « Chargée de recrutement »).'],
        ];
        foreach ($checks as [$ok, $w, $tip]) {
            $ok ? $pts += $w : $tips[] = $tip;
        }

        $len = mb_strlen($cv['summary']);
        if ($len >= 200 && $len <= 700) {
            $pts += 5;
        } elseif ($len > 0) {
            $pts += 2;
            $tips[] = $len < 200 ? 'Développez votre profil (3 à 5 lignes, 200 à 700 caractères).' : 'Raccourcissez votre profil (700 caractères maximum).';
        } else {
            $tips[] = 'Ajoutez un court profil professionnel (3 à 5 lignes) en haut du CV.';
        }

        $validExp = array_filter($cv['experiences'], static fn ($e) => $e['title'] !== '' && $e['company'] !== '' && $e['start'] !== '');
        if ($validExp) {
            $pts += 7;
        } else {
            $tips[] = 'Ajoutez au moins une expérience avec intitulé du poste, entreprise et date de début.';
        }

        $cv['education'] ? $pts += 4 : $tips[] = 'Ajoutez votre formation (diplôme, établissement, dates).';
        count($cv['skills']) >= 5 ? $pts += 3 : $tips[] = 'Listez au moins 5 compétences clés.';

        return ['key' => 'structure', 'label' => 'Structure & informations essentielles', 'points' => $pts, 'max' => 35, 'tips' => $tips];
    }

    private function quality(array $cv, string $lang): array
    {
        $pts = 0;
        $tips = [];
        $bullets = [];
        $withTwo = 0;

        foreach ($cv['experiences'] as $e) {
            $bullets = array_merge($bullets, $e['bullets']);
            if (count($e['bullets']) >= 2) {
                $withTwo++;
            }
        }

        $expCount = count($cv['experiences']);
        if ($expCount > 0) {
            $pts += 8 * ($withTwo / $expCount);
            if ($withTwo < $expCount) {
                $tips[] = 'Décrivez chaque expérience avec au moins 2 réalisations (une par ligne).';
            }
        }

        if ($bullets) {
            $verbs = self::ACTION_VERBS[$lang] ?? self::ACTION_VERBS['fr'];
            $withVerb = 0;
            $withNumber = 0;
            foreach ($bullets as $b) {
                $first = $this->tokens($b)[0] ?? '';
                foreach ($verbs as $v) {
                    if ($first !== '' && str_starts_with($first, $v)) {
                        $withVerb++;
                        break;
                    }
                }
                if (preg_match('/\d/u', $b)) {
                    $withNumber++;
                }
            }
            $n = count($bullets);
            $pts += 7 * ($withVerb / $n);
            $pts += 6 * min(1, ($withNumber / $n) / 0.4);
            if ($withVerb / $n < 0.6) {
                $tips[] = 'Commencez vos réalisations par un verbe d’action (ex. « Piloté », « Recruté », « Optimisé »).';
            }
            if ($withNumber / $n < 0.4) {
                $tips[] = 'Chiffrez vos résultats (ex. « +30 % de candidatures », « 25 recrutements en 6 mois »).';
            }
        } else {
            $tips[] = 'Ajoutez des réalisations concrètes sous vos expériences.';
        }

        $words = count($this->tokens(CvModel::toText($cv)));
        if ($words >= 250 && $words <= 900) {
            $pts += 4;
        } else {
            $pts += $words > 0 ? 2 : 0;
            $tips[] = $words < 250 ? 'Votre CV est trop court : visez 250 à 900 mots.' : 'Votre CV est long : visez 1 à 2 pages (900 mots maximum).';
        }

        return ['key' => 'quality', 'label' => 'Qualité du contenu', 'points' => round($pts, 1), 'max' => 25, 'tips' => $tips];
    }

    private function match(array $cv, string $offerText, string $jobTitle): array
    {
        $cvTokens = array_flip(array_map([$this, 'stem'], $this->tokens(CvModel::toText($cv))));
        $cvNorm = ' ' . implode(' ', $this->tokens(CvModel::toText($cv))) . ' ';

        $keywords = $this->keywords($offerText);
        $matched = [];
        $missing = [];
        foreach ($keywords as $kw) {
            $found = str_contains($kw, ' ')
                ? str_contains($cvNorm, ' ' . $kw . ' ')
                : isset($cvTokens[$this->stem($kw)]);
            $found ? $matched[] = $kw : $missing[] = $kw;
        }

        $pts = $keywords ? 32 * (count($matched) / count($keywords)) : 0;
        $tips = [];
        if ($missing) {
            $tips[] = 'Intégrez les mots-clés manquants de l’offre là où ils correspondent réellement à votre parcours (profil, compétences, réalisations).';
        }

        $titleTokens = array_values(array_filter($this->tokens($jobTitle), fn ($t) => ! $this->isStopword($t)));
        if ($titleTokens) {
            $cvTitles = $this->tokens($cv['personal']['headline'] . ' ' . implode(' ', array_column($cv['experiences'], 'title')));
            $cvTitles = array_flip(array_map([$this, 'stem'], $cvTitles));
            $hits = count(array_filter($titleTokens, fn ($t) => isset($cvTitles[$this->stem($t)])));
            $pts += 8 * ($hits / count($titleTokens));
            if ($hits < count($titleTokens)) {
                $tips[] = 'Reprenez l’intitulé exact du poste visé dans le titre de votre CV.';
            }
        }

        return [
            'section' => ['key' => 'match', 'label' => 'Correspondance avec l’offre', 'points' => round($pts, 1), 'max' => 40, 'tips' => $tips],
            'matched' => $matched,
            'missing' => $missing,
        ];
    }

    /** Most frequent meaningful words (and repeated two-word phrases) of the offer. */
    private function keywords(string $text): array
    {
        $tokens = $this->tokens($text);
        $freq = [];
        foreach ($tokens as $t) {
            if ($this->isStopword($t) || (mb_strlen($t) < 3 && ! preg_match('/[+#]/', $t)) || ctype_digit($t)) {
                continue;
            }
            $freq[$t] = ($freq[$t] ?? 0) + 1;
        }
        arsort($freq);
        $single = array_slice(array_keys($freq), 0, 25);

        $bigrams = [];
        for ($i = 0, $n = count($tokens) - 1; $i < $n; $i++) {
            [$a, $b] = [$tokens[$i], $tokens[$i + 1]];
            if (mb_strlen($a) > 2 && mb_strlen($b) > 2 && ! $this->isStopword($a) && ! $this->isStopword($b)) {
                $bigrams[$a . ' ' . $b] = ($bigrams[$a . ' ' . $b] ?? 0) + 1;
            }
        }
        $bigrams = array_keys(array_filter($bigrams, static fn ($c) => $c >= 2));

        return array_values(array_unique(array_merge(array_slice($bigrams, 0, 5), $single)));
    }

    private function tokens(string $text): array
    {
        $text = mb_strtolower($text);
        if (class_exists(\Normalizer::class)) {
            $text = preg_replace('/\p{Mn}+/u', '', \Normalizer::normalize($text, \Normalizer::FORM_D));
        }
        $text = strtr($text, ['أ' => 'ا', 'إ' => 'ا', 'آ' => 'ا', 'ة' => 'ه', 'ى' => 'ي', 'ـ' => '']);
        $parts = preg_split('/[^\p{L}\p{N}+#]+/u', $text, -1, PREG_SPLIT_NO_EMPTY) ?: [];

        // Drop the Arabic definite article so "الادارة" matches "ادارة".
        return array_map(static fn ($t) => preg_match('/^ال\p{Arabic}{3,}/u', $t) ? mb_substr($t, 2) : $t, $parts);
    }

    private function stem(string $t): string
    {
        if (preg_match('/^[a-z]+$/', $t) && strlen($t) > 4) {
            $t = preg_replace('/(ements|ement|ations|ation|ings|ing|euses|euse|eurs|eur|ers|er|ees|ee|es|e|s)$/', '', $t);
        }

        return $t;
    }

    private function isStopword(string $t): bool
    {
        static $set = null;
        $set ??= array_flip(self::STOPWORDS);

        return isset($set[$t]);
    }
}
