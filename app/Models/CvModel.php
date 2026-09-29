<?php

namespace App\Models;

use CodeIgniter\Model;

class CvModel extends Model
{
    public const MAX_FREE_CV = 3;
    public const LANGUES = ['fr' => 'Français', 'en' => 'English', 'ar' => 'العربية'];

    public const LABELS = [
        'fr' => [
            'summary' => 'Profil', 'experience' => 'Expérience professionnelle', 'education' => 'Formation',
            'skills' => 'Compétences', 'languages' => 'Langues', 'certifications' => 'Certifications', 'present' => 'Présent',
        ],
        'en' => [
            'summary' => 'Professional Summary', 'experience' => 'Work Experience', 'education' => 'Education',
            'skills' => 'Skills', 'languages' => 'Languages', 'certifications' => 'Certifications', 'present' => 'Present',
        ],
        'ar' => [
            'summary' => 'الملخص المهني', 'experience' => 'الخبرة المهنية', 'education' => 'التعليم',
            'skills' => 'المهارات', 'languages' => 'اللغات', 'certifications' => 'الشهادات', 'present' => 'حتى الآن',
        ],
    ];

    protected $table         = 'cvs';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['user_id', 'titre', 'langue', 'data'];
    protected $useTimestamps = true;

    public function forUser(int $userId): array
    {
        return $this->where('user_id', $userId)->orderBy('updated_at', 'DESC')->findAll();
    }

    public function findOwned(int $id, int $userId): ?array
    {
        $cv = $this->where('id', $id)->where('user_id', $userId)->first();
        if ($cv) {
            $cv['data'] = self::withDefaults(json_decode((string) $cv['data'], true) ?: []);
        }

        return $cv;
    }

    public static function withDefaults(array $d): array
    {
        return [
            'personal' => array_merge(
                ['full_name' => '', 'headline' => '', 'email' => '', 'phone' => '', 'city' => '', 'linkedin' => '', 'website' => ''],
                (array) ($d['personal'] ?? [])
            ),
            'summary'        => (string) ($d['summary'] ?? ''),
            'experiences'    => (array) ($d['experiences'] ?? []),
            'education'      => (array) ($d['education'] ?? []),
            'skills'         => (array) ($d['skills'] ?? []),
            'languages'      => (array) ($d['languages'] ?? []),
            'certifications' => (array) ($d['certifications'] ?? []),
        ];
    }

    /** Cleans raw form input into the stored CV structure. */
    public static function fromInput(array $in): array
    {
        $s = static fn ($v, int $max = 190): string => mb_substr(trim(strip_tags((string) $v)), 0, $max);
        $date = static fn ($v): string => preg_match('/^\d{4}-\d{2}$/', (string) $v) ? (string) $v : '';
        $rows = static fn ($v, int $max): array => array_slice(array_values(array_filter((array) $v, 'is_array')), 0, $max);

        $p = (array) ($in['personal'] ?? []);
        $personal = [];
        foreach (['full_name', 'headline', 'email', 'phone', 'city', 'linkedin', 'website'] as $k) {
            $personal[$k] = $s($p[$k] ?? '');
        }

        $experiences = [];
        foreach ($rows($in['experiences'] ?? [], 15) as $e) {
            $row = [
                'title'   => $s($e['title'] ?? ''),
                'company' => $s($e['company'] ?? ''),
                'city'    => $s($e['city'] ?? ''),
                'start'   => $date($e['start'] ?? ''),
                'end'     => $date($e['end'] ?? ''),
                'current' => ! empty($e['current']),
                'bullets' => self::lines($e['bullets'] ?? '', 12, 400),
            ];
            if ($row['title'] !== '' || $row['company'] !== '') {
                $experiences[] = $row;
            }
        }

        $education = [];
        foreach ($rows($in['education'] ?? [], 10) as $e) {
            $row = [
                'degree'  => $s($e['degree'] ?? ''),
                'school'  => $s($e['school'] ?? ''),
                'city'    => $s($e['city'] ?? ''),
                'start'   => $date($e['start'] ?? ''),
                'end'     => $date($e['end'] ?? ''),
                'details' => $s($e['details'] ?? '', 400),
            ];
            if ($row['degree'] !== '' || $row['school'] !== '') {
                $education[] = $row;
            }
        }

        $languages = [];
        foreach ($rows($in['languages'] ?? [], 10) as $l) {
            if (($name = $s($l['name'] ?? '', 60)) !== '') {
                $languages[] = ['name' => $name, 'level' => $s($l['level'] ?? '', 60)];
            }
        }

        $certifications = [];
        foreach ($rows($in['certifications'] ?? [], 15) as $c) {
            if (($name = $s($c['name'] ?? '')) !== '') {
                $certifications[] = ['name' => $name, 'org' => $s($c['org'] ?? ''), 'year' => $s($c['year'] ?? '', 4)];
            }
        }

        $skills = preg_split('/[,;\n\r]+/u', (string) ($in['skills'] ?? '')) ?: [];
        $skills = array_slice(array_values(array_unique(array_filter(array_map(static fn ($x) => $s($x, 60), $skills)))), 0, 40);

        return [
            'personal'       => $personal,
            'summary'        => $s($in['summary'] ?? '', 1500),
            'experiences'    => $experiences,
            'education'      => $education,
            'skills'         => $skills,
            'languages'      => $languages,
            'certifications' => $certifications,
        ];
    }

    public static function lines($text, int $max, int $len): array
    {
        $out = [];
        foreach (preg_split('/\R/u', (string) $text) ?: [] as $line) {
            $line = trim(preg_replace('/^[\-\x{2022}\*\x{25AA}\x{25CF}]+\s*/u', '', trim(strip_tags($line))));
            if ($line !== '') {
                $out[] = mb_substr($line, 0, $len);
            }
        }

        return array_slice($out, 0, $max);
    }

    public static function formatDate(string $ym): string
    {
        return preg_match('/^(\d{4})-(\d{2})$/', $ym, $m) ? $m[2] . '/' . $m[1] : '';
    }

    public static function period(array $row, string $lang): string
    {
        $start = self::formatDate((string) ($row['start'] ?? ''));
        $end   = ! empty($row['current']) ? self::LABELS[$lang]['present'] : self::formatDate((string) ($row['end'] ?? ''));

        return trim($start . ($start !== '' && $end !== '' ? ' – ' : '') . $end);
    }

    /** Plain text of the CV, used for keyword matching. */
    public static function toText(array $d): string
    {
        $parts = array_values($d['personal']);
        $parts[] = $d['summary'];
        foreach ($d['experiences'] as $e) {
            array_push($parts, $e['title'], $e['company'], $e['city'], implode("\n", $e['bullets']));
        }
        foreach ($d['education'] as $e) {
            array_push($parts, $e['degree'], $e['school'], $e['details']);
        }
        $parts[] = implode(', ', $d['skills']);
        foreach ($d['languages'] as $l) {
            array_push($parts, $l['name'], $l['level']);
        }
        foreach ($d['certifications'] as $c) {
            array_push($parts, $c['name'], $c['org']);
        }

        return implode("\n", array_filter(array_map('strval', $parts)));
    }
}
