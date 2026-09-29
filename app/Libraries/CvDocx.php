<?php

namespace App\Libraries;

use App\Models\CvModel;

/**
 * Builds an ATS-friendly .docx (single column, real text, no tables/images).
 * Written by hand with a minimal ZIP writer so no PHP extension or package is required.
 */
class CvDocx
{
    private bool $rtl = false;

    public function build(array $cv, string $lang): string
    {
        $this->rtl = $lang === 'ar';
        $L = CvModel::LABELS[$lang] ?? CvModel::LABELS['fr'];
        $p = $cv['personal'];
        $body = '';

        $body .= $this->para($p['full_name'], ['bold' => true, 'size' => 36]);
        if ($p['headline'] !== '') {
            $body .= $this->para($p['headline'], ['size' => 24]);
        }
        $contact = implode(' | ', array_filter([$p['email'], $p['phone'], $p['city'], $p['linkedin'], $p['website']]));
        if ($contact !== '') {
            $body .= $this->para($contact, ['size' => 20]);
        }

        if ($cv['summary'] !== '') {
            $body .= $this->heading($L['summary']) . $this->para($cv['summary']);
        }

        if ($cv['experiences']) {
            $body .= $this->heading($L['experience']);
            foreach ($cv['experiences'] as $e) {
                $body .= $this->para(trim($e['title'] . ' — ' . $e['company'], ' —'), ['bold' => true, 'before' => 120]);
                $meta = implode(' | ', array_filter([CvModel::period($e, $lang), $e['city']]));
                if ($meta !== '') {
                    $body .= $this->para($meta, ['size' => 20, 'italic' => true]);
                }
                foreach ($e['bullets'] as $b) {
                    $body .= $this->para('• ' . $b, ['indent' => 360]);
                }
            }
        }

        if ($cv['education']) {
            $body .= $this->heading($L['education']);
            foreach ($cv['education'] as $e) {
                $body .= $this->para(trim($e['degree'] . ' — ' . $e['school'], ' —'), ['bold' => true, 'before' => 120]);
                $meta = implode(' | ', array_filter([CvModel::period($e, $lang), $e['city']]));
                if ($meta !== '') {
                    $body .= $this->para($meta, ['size' => 20, 'italic' => true]);
                }
                if ($e['details'] !== '') {
                    $body .= $this->para($e['details']);
                }
            }
        }

        if ($cv['skills']) {
            $body .= $this->heading($L['skills']) . $this->para(implode(', ', $cv['skills']));
        }

        if ($cv['languages']) {
            $body .= $this->heading($L['languages']);
            foreach ($cv['languages'] as $l) {
                $body .= $this->para(trim($l['name'] . ($l['level'] !== '' ? ' : ' . $l['level'] : '')));
            }
        }

        if ($cv['certifications']) {
            $body .= $this->heading($L['certifications']);
            foreach ($cv['certifications'] as $c) {
                $body .= $this->para(implode(' — ', array_filter([$c['name'], $c['org'], $c['year']])));
            }
        }

        $document = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<w:document xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"><w:body>'
            . $body
            . '<w:sectPr><w:pgSz w:w="11906" w:h="16838"/><w:pgMar w:top="1000" w:right="1000" w:bottom="1000" w:left="1000" w:header="0" w:footer="0" w:gutter="0"/></w:sectPr>'
            . '</w:body></w:document>';

        $styles = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<w:styles xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"><w:docDefaults>'
            . '<w:rPrDefault><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial" w:eastAsia="Arial"/><w:sz w:val="21"/><w:szCs w:val="21"/></w:rPr></w:rPrDefault>'
            . '<w:pPrDefault><w:pPr><w:spacing w:after="60" w:line="264" w:lineRule="auto"/></w:pPr></w:pPrDefault>'
            . '</w:docDefaults></w:styles>';

        return $this->zip([
            '[Content_Types].xml' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
                . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
                . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
                . '<Default Extension="xml" ContentType="application/xml"/>'
                . '<Override PartName="/word/document.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml"/>'
                . '<Override PartName="/word/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.styles+xml"/>'
                . '</Types>',
            '_rels/.rels' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
                . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
                . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="word/document.xml"/>'
                . '</Relationships>',
            'word/_rels/document.xml.rels' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
                . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
                . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
                . '</Relationships>',
            'word/document.xml' => $document,
            'word/styles.xml'   => $styles,
        ]);
    }

    private function heading(string $text): string
    {
        $border = '<w:pBdr><w:bottom w:val="single" w:sz="6" w:space="1" w:color="444444"/></w:pBdr>';

        return $this->para($this->rtl ? $text : mb_strtoupper($text), ['bold' => true, 'size' => 24, 'before' => 240, 'pPr' => $border]);
    }

    private function para(string $text, array $o = []): string
    {
        $pPr = ($o['pPr'] ?? '')
            . '<w:spacing w:before="' . (int) ($o['before'] ?? 0) . '" w:after="60"/>'
            . (isset($o['indent']) ? '<w:ind w:' . ($this->rtl ? 'right' : 'left') . '="' . (int) $o['indent'] . '"/>' : '')
            . ($this->rtl ? '<w:bidi/><w:jc w:val="right"/>' : '');

        $rPr = (! empty($o['bold']) ? '<w:b/><w:bCs/>' : '')
            . (! empty($o['italic']) ? '<w:i/><w:iCs/>' : '')
            . (isset($o['size']) ? '<w:sz w:val="' . (int) $o['size'] . '"/><w:szCs w:val="' . (int) $o['size'] . '"/>' : '')
            . ($this->rtl ? '<w:rtl/>' : '');

        $safe = htmlspecialchars($text, ENT_XML1 | ENT_QUOTES, 'UTF-8');

        return '<w:p><w:pPr>' . $pPr . '</w:pPr><w:r><w:rPr>' . $rPr . '</w:rPr><w:t xml:space="preserve">' . $safe . '</w:t></w:r></w:p>';
    }

    /** Minimal ZIP archive (deflate when zlib is available, otherwise stored). */
    private function zip(array $files): string
    {
        $data = '';
        $central = '';
        $offset = 0;
        $time = ((date('H') << 11) | (date('i') << 5) | (int) (date('s') / 2));
        $date = (((date('Y') - 1980) << 9) | (date('n') << 5) | date('j'));

        foreach ($files as $name => $content) {
            $crc = crc32($content);
            $deflated = function_exists('gzdeflate') ? gzdeflate($content) : false;
            $method = $deflated !== false ? 8 : 0;
            $stored = $deflated !== false ? $deflated : $content;

            $header = pack('VvvvvvVVVvv', 0x04034b50, 20, 0x0800, $method, $time, $date, $crc, strlen($stored), strlen($content), strlen($name), 0);
            $data .= $header . $name . $stored;

            $central .= pack('VvvvvvvVVVvvvvvVV', 0x02014b50, 20, 20, 0x0800, $method, $time, $date, $crc, strlen($stored), strlen($content), strlen($name), 0, 0, 0, 0, 0, $offset) . $name;
            $offset += strlen($header) + strlen($name) + strlen($stored);
        }

        return $data . $central . pack('VvvvvVVv', 0x06054b50, 0, 0, count($files), count($files), strlen($central), $offset, 0);
    }
}
