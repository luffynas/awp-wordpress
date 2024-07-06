<?php

class APW_Seeder {
    public static function seed_styles() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'apw_styles';

        $styles = [
            [
                'type' => 'Gaya Bahasa',
                'name' => 'Formal',
                'description' => 'Nada serius, bahasa akademis atau profesional, penggunaan struktur kalimat yang kompleks, dan istilah teknis.',
                'example' => 'Pentingnya optimasi mesin pencari (SEO) dalam meningkatkan visibilitas situs web Anda tidak dapat diabaikan. SEO yang efektif memerlukan pemahaman mendalam tentang berbagai teknik dan strategi.',
                'characteristics' => 'Nada serius, bahasa akademis atau profesional, penggunaan struktur kalimat yang kompleks, dan istilah teknis.'
            ],
            [
                'type' => 'Gaya Bahasa',
                'name' => 'Informal',
                'description' => 'Bahasa sehari-hari, penggunaan slang atau frasa casual, nada berbicara yang lebih pribadi dan langsung.',
                'example' => 'SEO itu sebenarnya gak sesulit yang orang bayangkan kok. Coba deh, pake teknik-teknik sederhana ini supaya situsmu makin keren di Google.',
                'characteristics' => 'Bahasa sehari-hari, penggunaan slang atau frasa casual, nada berbicara yang lebih pribadi dan langsung.'
            ],
            [
                'type' => 'Gaya Bahasa',
                'name' => 'Persuasif',
                'description' => '',
                'example' => 'Jangan lewatkan kesempatan untuk meningkatkan visibilitas situs Anda! Dengan menerapkan teknik SEO terbaru, Anda bisa memimpin di pasar digital dan mengalahkan kompetitor.',
                'characteristics' => 'Mengajak pembaca untuk bertindak, menggunakan argumen yang kuat, dan bahasa yang memotivasi atau menggugah.'
            ],
            [
                'type' => 'Gaya Bahasa',
                'name' => 'Akomodatif',
                'description' => '',
                'example' => 'Kami paham bahwa SEO bisa terasa membingungkan pada awalnya. Mari kita bahas langkah-langkah sederhana yang dapat membantu Anda memulai perjalanan SEO Anda dengan mudah.',
                'characteristics' => 'Empati, menyesuaikan dengan kebutuhan atau kekhawatiran pembaca, dan menggunakan bahasa yang membantu dan mendukung.'
            ],
            [
                'type' => 'Gaya Bahasa',
                'name' => 'Teknis',
                'description' => '',
                'example' => 'SEO teknis mencakup optimasi elemen seperti struktur URL, pengaturan sitemap XML, dan penggunaan schema markup untuk meningkatkan pemahaman mesin pencari terhadap konten Anda.',
                'characteristics' => 'Fokus pada detail teknis, penggunaan jargon spesifik industri, dan memberikan penjelasan mendalam tentang proses atau sistem.'
            ],
            [
                'type' => 'Gaya Bahasa',
                'name' => 'Akademis',
                'description' => '',
                'example' => 'Penelitian ini menganalisis pengaruh algoritma mesin pencari terhadap peringkat situs web, dengan penekanan pada teori-teori SEO yang telah terbukti melalui studi empiris.',
                'characteristics' => 'Menggunakan bahasa yang akademis dan terstruktur, memberikan referensi atau sumber ilmiah, dan menekankan analisis dan penjelasan yang mendalam.'
            ],
            [
                'type' => 'Gaya Bahasa',
                'name' => 'Inspiratif',
                'description' => '',
                'example' => 'Bayangkan situs web Anda menduduki puncak hasil pencarian Google dan menarik ribuan pengunjung setiap bulan. Dengan dedikasi dan strategi SEO yang tepat, Anda dapat mewujudkan impian ini!',
                'characteristics' => 'Memotivasi, menggunakan bahasa yang mendorong semangat dan optimisme, dan sering kali berfokus pada visi atau tujuan.'
            ],
            [
                'type' => 'Gaya Bahasa',
                'name' => 'Humoris',
                'description' => '',
                'example' => 'SEO itu kayak diet untuk situs web kamu. Kalau kamu mau situsmu tampil bugar di Google, kamu harus pastiin semuanya \'sehat\' dan nggak ada yang \'berat\'!',
                'characteristics' => 'Menggunakan humor atau permainan kata, nada yang ringan dan menghibur, dan bahasa yang membuat pembaca tersenyum'
            ],
            [
                'type' => 'Gaya Bahasa',
                'name' => 'Bergaya Cerita',
                'description' => '',
                'example' => 'Di sebuah kota digital yang sibuk, ada sebuah situs web yang hampir tidak terlihat. Namun, dengan beberapa teknik SEO ajaib, situs ini berhasil muncul di puncak hasil pencarian dan menarik perhatian semua orang.',
                'characteristics' => 'Menggunakan elemen cerita, narasi yang memikat, dan sering kali memanfaatkan karakter dan plot untuk menyampaikan pesan.'
            ],
            [
                'type' => 'Gaya Bahasa',
                'name' => 'Analitis',
                'description' => '',
                'example' => 'Dalam analisis ini, kami membandingkan performa SEO antara dua strategi berbeda berdasarkan metrik utama seperti CTR, waktu di situs, dan tingkat konversi.',
                'characteristics' => 'Fokus pada data dan analisis, penggunaan statistik dan hasil penelitian, serta penjelasan yang berbasis fakta.'
            ],
            [
                'type' => 'Gaya Penulisan',
                'name' => 'Informal dan Santai',
                'description' => '',
                'example' => 'Pendekatan yang santai dan ramah, sering menggunakan bahasa sehari-hari dan slang',
                'characteristics' => 'Hey, teman-teman! Yuk, kita bahas cara mudah bikin situs kalian jadi terkenal di dunia maya!'
            ],
            [
                'type' => 'Gaya Penulisan',
                'name' => 'Profesional dan Formal',
                'description' => '',
                'example' => 'Gaya yang serius dan terstruktur, cocok untuk audiens bisnis atau akademis.',
                'characteristics' => 'Penting untuk menerapkan teknik SEO yang efektif untuk meningkatkan visibilitas situs Anda dan mencapai keunggulan kompetitif di pasar.'
            ],
            [
                'type' => 'Gaya Penulisan',
                'name' => 'Humoris',
                'description' => '',
                'example' => 'Gaya yang penuh dengan humor dan lelucon, bertujuan untuk menghibur sambil menyampaikan informasi.',
                'characteristics' => 'Jangan biarkan situs web Anda menjadi seperti kucing hitam di sudut gelap—terapkan teknik SEO terbaru dan jadi superstar digital!'
            ],
            [
                'type' => 'Gaya Penulisan',
                'name' => 'Inspiratif dan Memotivasi',
                'description' => '',
                'example' => 'Gaya yang memotivasi dan membangkitkan semangat, sering menggunakan bahasa yang positif dan memberi dorongan.',
                'characteristics' => 'Ambil langkah pertama menuju kesuksesan digital Anda! Dengan strategi SEO yang tepat, Anda akan membuka pintu menuju peluang baru yang menanti.'
            ],
            [
                'type' => 'Gaya Penulisan',
                'name' => 'Pedagogis dan Didaktis',
                'description' => '',
                'example' => 'Gaya yang informatif dan pendidikan, sering kali digunakan untuk menjelaskan konsep dan langkah-langkah secara rinci.',
                'characteristics' => 'Untuk memahami SEO, pertama-tama Anda perlu mengetahui bagaimana mesin pencari bekerja. Mulailah dengan mempelajari cara kerja algoritma dan bagaimana optimasi konten dapat mempengaruhi peringkat.'
            ],
            [
                'type' => 'Gaya Penulisan',
                'name' => 'Teknis dan Detail',
                'description' => '',
                'example' => 'Gaya yang sangat detail dan teknis, sering digunakan dalam dokumentasi teknis atau panduan profesional.',
                'characteristics' => 'Untuk mengoptimalkan kecepatan situs web Anda, pertimbangkan untuk menggunakan teknik kompresi gambar seperti WebP, dan pastikan untuk mengimplementasikan caching yang efisien pada server.'
            ],
            [
                'type' => 'Gaya Penulisan',
                'name' => 'Empatik dan Ramah',
                'description' => '',
                'example' => 'Gaya yang menunjukkan kepedulian dan pemahaman terhadap pembaca, sering digunakan untuk menciptakan hubungan yang lebih dekat.',
                'characteristics' => 'Kami mengerti bahwa SEO bisa terasa menakutkan, tapi jangan khawatir—kami di sini untuk membantu Anda setiap langkahnya. Bersama, kita akan membuat situs Anda bersinar!'
            ],
            [
                'type' => 'Gaya Penulisan',
                'name' => 'Persuasif dan Penjual',
                'description' => '',
                'example' => 'Gaya yang dirancang untuk meyakinkan pembaca untuk mengambil tindakan atau membeli produk/jasa.',
                'characteristics' => 'Jangan lewatkan kesempatan untuk meningkatkan situs Anda dengan teknik SEO terbaru. Daftarkan diri Anda sekarang dan lihat bagaimana peringkat Anda melambung!'
            ],
            [
                'type' => 'Gaya Penulisan',
                'name' => 'Cerita dan Naratif',
                'description' => '',
                'example' => 'Gaya yang menceritakan kisah atau narasi, sering digunakan untuk menarik perhatian dan membuat konten lebih menarik.',
                'characteristics' => 'Bayangkan sebuah dunia di mana situs web Anda adalah bintang utama di panggung digital. Dengan teknik SEO yang tepat, Anda bisa membuat cerita ini menjadi kenyataan dan melampaui semua pesaing.'
            ],
            [
                'type' => 'Gaya Penulisan',
                'name' => 'Kreatif dan Imajinatif',
                'description' => '',
                'example' => 'Gaya yang berfokus pada kreativitas dan penggunaan imajinasi untuk membuat konten lebih menarik dan inovatif.',
                'characteristics' => 'Pikirkan situs web Anda sebagai kapal pesiar yang siap berlayar ke lautan digital. Dengan teknik SEO sebagai peta dan kompas, Anda akan menjelajahi wilayah baru dan menemukan pulau-pulau trafik yang melimpah.'
            ],
            [
                'type' => 'Bahasa',
                'name' => 'Indonesia',
                'description' => '',
                'example' => 'Gaya yang berfokus pada Bahasa Indonesia',
                'characteristics' => 'Menggunakan Bahasa Indonesia yang baik dan benar'
            ],
            [
                'type' => 'Bahasa',
                'name' => 'English United Kingdom',
                'description' => '',
                'example' => 'Gaya yang berfokus pada Bahasa English UK',
                'characteristics' => 'Menggunakan Bahasa English UK yang baik dan benar'
            ],
            [
                'type' => 'Bahasa',
                'name' => 'English United States',
                'description' => '',
                'example' => 'Gaya yang berfokus pada Bahasa English US',
                'characteristics' => 'Menggunakan Bahasa English US yang baik dan benar'
            ]
        ];
    
        // Tambahkan data lainnya dengan cara yang sama

        foreach ($styles as $style) {
            // Cek apakah data sudah ada
            $exists = $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM $table_name WHERE type = %s AND name = %s",
                $style['type'], $style['name']
            ));

            if ($exists == 0) {
                // Jika data belum ada, tambahkan ke tabel
                APW_Template::insert_style(
                    $style['type'], 
                    $style['name'], 
                    $style['description'], 
                    $style['example'], 
                    $style['characteristics']
                );
            }
        }
    }
}
?>
