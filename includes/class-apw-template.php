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

    // Contoh penggunaan
    /* $markdown = <<<EOD
    # Judul Utama
    Ini adalah paragraf pertama yang menjelaskan sesuatu.

    ## Subjudul
    - Item pertama dalam daftar
    - Item kedua dalam daftar

    1. Item pertama dalam daftar bernomor
    2. Item kedua dalam daftar bernomor

    Paragraf terakhir yang menjelaskan hal lain.
    EOD;

    $parsedMarkdown = parseMarkdown($markdown);
    print_r($parsedMarkdown); */
    public static function parseMarkdown($markdown) {
        $lines = explode("\n", $markdown);
        $parsed = [];
        $currentSection = null;
    
        foreach ($lines as $line) {
            $line = trim($line);
    
            // Heading 1
            if (preg_match('/^# (.+)$/', $line, $matches)) {
                if ($currentSection) {
                    $parsed[] = $currentSection;
                }
                $currentSection = [
                    'Heading' => $matches[1],
                    'Items' => []
                ];
                continue;
            }
    
            // Heading 2
            if (preg_match('/^## (.+)$/', $line, $matches)) {
                $currentItem = [
                    'Heading' => $matches[1],
                    'Items' => []
                ];
                $currentSection['Items'][] = $currentItem;
                continue;
            }
    
            // List items
            if (preg_match('/^[\-|\d+\.\s]+(.+)$/', $line, $matches)) {
                $currentSection['Items'][] = $matches[1];
                continue;
            }
        }
    
        if ($currentSection) {
            $parsed[] = $currentSection;
        }
    
        return $parsed;
    }

    public static function parseMarkdownV2($markdown) {
        $lines = explode(PHP_EOL, $markdown);
        $result = [];
        $currentSection = null;
        $currentSubSection = null;
    
        foreach ($lines as $line) {
            $line = trim($line);
    
            // Check for main heading
            if (preg_match('/^# (.+)$/', $line, $matches)) {
                $currentSection = [
                    'Heading' => $matches[1],
                    'Items' => []
                ];
                $result[] = &$currentSection;
                $currentSubSection = null;
            }
    
            // Check for subheading level 2
            elseif (preg_match('/^## (.+)$/', $line, $matches)) {
                $currentSubSection = [
                    'Heading' => $matches[1],
                    'Items' => []
                ];
                $currentSection['Items'][] = &$currentSubSection;
            }
    
            // Check for subheading level 3
            elseif (preg_match('/^### (.+)$/', $line, $matches)) {
                $currentSubSection = [
                    'Heading' => $matches[1],
                    'Items' => []
                ];
                $currentSection['Items'][] = &$currentSubSection;
            }
    
            // Check for list items
            elseif (preg_match('/^- (.+)$/', $line, $matches)) {
                if ($currentSubSection !== null) {
                    $currentSubSection['Items'][] = $matches[1];
                } else {
                    $currentSection['Items'][] = $matches[1];
                }
            }
        }
    
        return $result;
    }

    public static function parseMarkdownV3($markdown) {
        $lines = explode(PHP_EOL, $markdown);
        $result = [];
        $currentSection = null;
        $currentItem = null;
        $currentSubItem = null;
    
        foreach ($lines as $line) {
            $line = rtrim($line);
            $indentationLevel = (strlen($line) - strlen(ltrim($line))) / 2;
    
            // Check for heading level 2
            if (preg_match('/^## (.+)$/', $line, $matches)) {
                $currentSection = [
                    'Heading' => $matches[1],
                    'Items' => []
                ];
                $result[] = &$currentSection;
                $currentItem = null;
            }
    
            // Check for list items
            elseif (preg_match('/^- (.+)$/', trim($line), $matches)) {
                $item = $matches[1];
    
                if ($indentationLevel == 0) {
                    $currentItem = [
                        'Item' => $item,
                        'SubItems' => []
                    ];
                    $currentSection['Items'][] = &$currentItem;
                    $currentSubItem = null;
                } elseif ($indentationLevel == 1 && $currentItem !== null) {
                    $currentSubItem = [
                        'Item' => $item,
                        'SubItems' => []
                    ];
                    $currentItem['SubItems'][] = &$currentSubItem;
                }
            }
        }
    
        return $result;
    }

    public static function parseMarkdownToArray($markdown) {
        $lines = explode("\n", $markdown);
        $result = [];
        $currentHeading = null;
        $currentSubHeading = null;
        $currentSubSubHeading = null;
    
        foreach ($lines as $line) {
            $line = trim($line);
    
            if (empty($line)) {
                continue;
            }
    
            // Check for main heading
            if (preg_match('/^# (.*)$/', $line, $matches)) {
                // Save previous heading if exists
                if ($currentHeading !== null) {
                    if ($currentSubHeading !== null) {
                        if ($currentSubSubHeading !== null) {
                            $currentSubSubHeading['Items'] = $currentSubSubHeading['Items'] ?? [];
                            $currentSubHeading['SubSubHeadings'][] = $currentSubSubHeading;
                            $currentSubSubHeading = null;
                        }
                        $currentSubHeading['Items'] = $currentSubHeading['Items'] ?? [];
                        $currentHeading['SubHeadings'][] = $currentSubHeading;
                        $currentSubHeading = null;
                    }
                    $currentHeading['Items'] = $currentHeading['Items'] ?? [];
                    $result[] = $currentHeading;
                }
                
                $currentHeading = [
                    'Heading' => $matches[1],
                    'SubHeadings' => []
                ];
            }
            // Check for subheading
            elseif (preg_match('/^## (.*)$/', $line, $matches)) {
                // Save previous subheading if exists
                if ($currentSubHeading !== null) {
                    if ($currentSubSubHeading !== null) {
                        $currentSubSubHeading['Items'] = $currentSubSubHeading['Items'] ?? [];
                        $currentSubHeading['SubSubHeadings'][] = $currentSubSubHeading;
                        $currentSubSubHeading = null;
                    }
                    $currentSubHeading['Items'] = $currentSubHeading['Items'] ?? [];
                    $currentHeading['SubHeadings'][] = $currentSubHeading;
                }
                
                $currentSubHeading = [
                    'SubHeading' => $matches[1],
                    'SubSubHeadings' => [],
                    'Items' => []
                ];
            }
            // Check for sub-subheading
            elseif (preg_match('/^### (.*)$/', $line, $matches)) {
                // Save previous sub-subheading if exists
                if ($currentSubSubHeading !== null) {
                    $currentSubSubHeading['Items'] = $currentSubSubHeading['Items'] ?? [];
                    $currentSubHeading['SubSubHeadings'][] = $currentSubSubHeading;
                }
                
                $currentSubSubHeading = [
                    'SubSubHeading' => $matches[1],
                    'Items' => []
                ];
            }
            // Check for items
            elseif (preg_match('/^- (.*)$/', $line, $matches)) {
                if ($currentSubSubHeading !== null) {
                    $currentSubSubHeading['Items'][] = $matches[1];
                } elseif ($currentSubHeading !== null) {
                    $currentSubHeading['Items'][] = $matches[1];
                } else {
                    $currentHeading['Items'][] = $matches[1];
                }
            }
        }
        
        // Save the last heading and sub-items
        if ($currentHeading !== null) {
            if ($currentSubHeading !== null) {
                if ($currentSubSubHeading !== null) {
                    $currentSubSubHeading['Items'] = $currentSubSubHeading['Items'] ?? [];
                    $currentSubHeading['SubSubHeadings'][] = $currentSubSubHeading;
                }
                $currentSubHeading['Items'] = $currentSubHeading['Items'] ?? [];
                $currentHeading['SubHeadings'][] = $currentSubHeading;
            } else {
                $currentHeading['Items'] = $currentHeading['Items'] ?? [];
            }
            $result[] = $currentHeading;
        }
    
        return $result;
    }
}
?>
