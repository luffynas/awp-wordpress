<?php

class APW_Template {
    public static function replace_title_placeholder($template_content, $title) {
        return str_replace('{{topic}}', $title, $template_content);
    }

    // Fungsi untuk memecah teks menjadi array
    // Parsing data dan mencetak hasil
    // $parsed_data = parseTextToArray($data_text);
    // Menampilkan hasil dalam format yang lebih mudah dibaca
    /*echo "<pre>";
    print_r($parsed_data);
    echo "</pre>";*/
    public static function parseTextToArray($text) {
        $sections = [];
        $lines = explode("\n", $text);
        $currentSection = null;
        
        foreach ($lines as $line) {
            $line = trim($line);
            
            if (preg_match('/^### (.+)$/', $line, $matches)) {
                // Menangkap judul section utama
                $currentSection = $matches[1];
                $sections[$currentSection] = [];
            } elseif (preg_match('/^\d+\. \*\*(.+)\*\*$/', $line, $matches)) {
                // Menangkap judul sub-section dengan nomor
                $currentSubSection = $matches[1];
                $sections[$currentSection][$currentSubSection] = [];
            } elseif (preg_match('/^   - (.+)$/', $line, $matches)) {
                // Menangkap item list
                if ($currentSection && $currentSubSection) {
                    $sections[$currentSection][$currentSubSection][] = $matches[1];
                }
            } elseif (preg_match('/^**Judul:** (.+)$/', $line, $matches)) {
                // Menangkap judul artikel
                $sections['Menentukan Judul Artikel'] = $matches[1];
            } elseif (preg_match('/^\d+\. (.+)$/', $line, $matches)) {
                // Menangkap daftar pertanyaan dan tema utama
                if (!isset($sections['Daftar Pertanyaan dan Tema Utama'])) {
                    $sections['Daftar Pertanyaan dan Tema Utama'] = [];
                }
                $sections['Daftar Pertanyaan dan Tema Utama'][] = $matches[1];
            } elseif (preg_match('/^- (.+)$/', $line, $matches)) {
                // Menangkap elemen lain seperti target audience dan tujuan artikel
                if (!isset($sections[$currentSection])) {
                    $sections[$currentSection] = [];
                }
                $sections[$currentSection][] = $matches[1];
            }
        }

        return $sections;
    }

    // Fungsi untuk menghasilkan Markdown
    // Hasilkan Markdown
    // $markdownContent = generateMarkdown($data);
    // Tampilkan Markdown
    // echo "<pre>" . htmlspecialchars($markdownContent) . "</pre>";
    // Data untuk Markdown
    /* $data = [
        'title' => 'Panduan Lengkap Belajar SEO',
        'sections' => [
            [
                'title' => 'Pendahuluan',
                'items' => [
                    'Apa itu SEO?',
                    'Pentingnya SEO'
                ]
            ],
            [
                'title' => 'Jenis-Jenis SEO',
                'items' => [
                    'On-Page SEO',
                    'Off-Page SEO',
                    'SEO Teknis'
                ]
            ],
            [
                'title' => 'Cara Memilih Kata Kunci',
                'items' => [
                    'Penelitian kata kunci',
                    'Alat bantu'
                ]
            ]
            // Tambahkan bagian lainnya sesuai kebutuhan
        ]
    ]; */
    public static function generateMarkdown($data) {
        $markdown = "# " . $data['title'] . "\n\n";

        foreach ($data['sections'] as $section) {
            $markdown .= "## " . $section['title'] . "\n";
            foreach ($section['items'] as $item) {
                $markdown .= "- " . $item . "\n";
            }
            $markdown .= "\n";
        }

        return $markdown;
    }

    public static function insert_style($type, $name, $description, $example, $characteristics) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'apw_styles';

        $wpdb->insert(
            $table_name,
            array(
                'type' => $type,
                'name' => $name,
                'description' => $description,
                'example' => $example,
                'characteristics' => $characteristics,
            ),
            array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%s'
            )
        );
    }
}
?>
