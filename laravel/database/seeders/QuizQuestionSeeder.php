<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuizQuestion;

class QuizQuestionSeeder extends Seeder
{
    public function run(): void
    {
        QuizQuestion::truncate();

        $soal = array_merge(
            $this->bisindoPemula(),
            $this->bisindoMenengah(),
            $this->bisindoMahir(),
            $this->sibiPemula(),
            $this->sibiMenengah(),
            $this->sibiMahir(),
        );

        foreach ($soal as $s) {
            QuizQuestion::create($s);
        }

        $this->command->info('✅ ' . count($soal) . ' soal berhasil dimasukkan.');
        $this->command->table(
            ['Bahasa', 'Level', 'Jumlah Soal'],
            [
                ['BISINDO', 'Pemula',   count($this->bisindoPemula())],
                ['BISINDO', 'Menengah', count($this->bisindoMenengah())],
                ['BISINDO', 'Mahir',    count($this->bisindoMahir())],
                ['SIBI',    'Pemula',   count($this->sibiPemula())],
                ['SIBI',    'Menengah', count($this->sibiMenengah())],
                ['SIBI',    'Mahir',    count($this->sibiMahir())],
            ]
        );
    }

    // ══════════════════════════════════════════════════
    //  BISINDO — PEMULA  (A B C D L O J T)
    // ══════════════════════════════════════════════════
    private function bisindoPemula(): array
    {
        return [
            [
                'language'       => 'bisindo',
                'level'          => 'pemula',
                'image_path'     => 'bisindo/pemula/a.png',
                'correct_answer' => 'A',
                'options'        => ['A', 'S', 'E', 'O'],
                'explanation'    => 'Huruf A dalam BISINDO: kedua tangan berhadapan, masing-masing telunjuk berdiri lurus ke atas membentuk puncak segitiga, sementara ibu jari dan jari lainnya melengkung ke bawah dan saling bertemu di tengah membentuk kerangka huruf A.',
            ],
            [
                'language'       => 'bisindo',
                'level'          => 'pemula',
                'image_path'     => 'bisindo/pemula/b.png',
                'correct_answer' => 'B',
                'options'        => ['B', 'D', 'F', 'P'],
                'explanation'    => 'Huruf B dalam BISINDO: dua tangan saling berhadapan miring, ujung-ujung jari kedua tangan saling menyentuh membentuk pola bingkai diagonal — tangan kiri di atas miring ke kanan, tangan kanan di bawah miring ke kiri.',
            ],
            [
                'language'       => 'bisindo',
                'level'          => 'pemula',
                'image_path'     => 'bisindo/pemula/c.png',
                'correct_answer' => 'C',
                'options'        => ['C', 'G', 'O', 'D'],
                'explanation'    => 'Huruf C dalam BISINDO: satu tangan dengan telunjuk terangkat ke atas-samping dan ibu jari terentang ke bawah-samping membentuk bukaan huruf C. Jari tengah, manis, dan kelingking terlipat ke dalam telapak.',
            ],
            [
                'language'       => 'bisindo',
                'level'          => 'pemula',
                'image_path'     => 'bisindo/pemula/d.png',
                'correct_answer' => 'D',
                'options'        => ['D', 'B', 'P', 'Q'],
                'explanation'    => 'Huruf D dalam BISINDO: dua tangan membentuk sudut siku-siku — telunjuk tangan kiri mengarah diagonal ke kanan-atas dan telunjuk tangan kanan berdiri tegak ke atas, keduanya bertemu di ujung membentuk sudut 90 derajat seperti huruf D.',
            ],
            [
                'language'       => 'bisindo',
                'level'          => 'pemula',
                'image_path'     => 'bisindo/pemula/l.png',
                'correct_answer' => 'L',
                'options'        => ['L', 'K', 'G', 'V'],
                'explanation'    => 'Huruf L dalam BISINDO: satu tangan membentuk sudut siku-siku seperti huruf L — telunjuk berdiri lurus ke atas dan ibu jari terentang penuh ke samping horizontal. Jari tengah, manis, dan kelingking terlipat rapat ke dalam telapak.',
            ],
            [
                'language'       => 'bisindo',
                'level'          => 'pemula',
                'image_path'     => 'bisindo/pemula/o.png',
                'correct_answer' => 'O',
                'options'        => ['O', 'C', 'A', 'D'],
                'explanation'    => 'Huruf O dalam BISINDO: satu tangan membentuk lingkaran penuh — semua ujung jari (telunjuk, tengah, manis, kelingking) bertemu dengan ujung ibu jari membentuk lingkaran bulat seperti huruf O.',
            ],
            [
                'language'       => 'bisindo',
                'level'          => 'pemula',
                'image_path'     => 'bisindo/pemula/j.png',
                'correct_answer' => 'J',
                'options'        => ['J', 'I', 'Z', 'Y'],
                'explanation'    => 'Huruf J dalam BISINDO: tangan membentuk kepalan ringan dengan ibu jari diluruskan ke samping sehingga menonjol secara horizontal, sementara jari lainnya ditekuk ke dalam telapak tangan. Posisi ibu jari yang memanjang menjadi ciri utama huruf J.',
            ],
            [
                'language'       => 'bisindo',
                'level'          => 'pemula',
                'image_path'     => 'bisindo/pemula/t.png',
                'correct_answer' => 'T',
                'options'        => ['T', 'A', 'D', 'N'],
                'explanation'    => 'Huruf T dalam BISINDO: dua tangan — tangan kiri dengan telunjuk tegak lurus ke atas, tangan kanan dengan telunjuk mengarah horizontal ke kiri menyentuh bagian atas telunjuk tangan kiri. Keduanya membentuk huruf T seperti tanda tambah yang tidak simetris.',
            ],
        ];
    }

    // ══════════════════════════════════════════════════
    //  BISINDO — MENENGAH  (E F G H I K P Q)
    // ══════════════════════════════════════════════════
    private function bisindoMenengah(): array
    {
        return [
            [
                'language'       => 'bisindo',
                'level'          => 'menengah',
                'image_path'     => 'bisindo/menengah/e.png',
                'correct_answer' => 'E',
                'options'        => ['E', 'A', 'N', 'S'],
                'explanation'    => 'Huruf E dalam BISINDO: satu tangan dengan tiga jari (telunjuk, tengah, dan manis) berdiri lurus ke atas dan terbuka, sementara ibu jari dan kelingking terlipat ke dalam telapak tangan.',
            ],
            [
                'language'       => 'bisindo',
                'level'          => 'menengah',
                'image_path'     => 'bisindo/menengah/f.png',
                'correct_answer' => 'F',
                'options'        => ['F', 'E', 'G', 'W'],
                'explanation'    => 'Huruf F dalam BISINDO: dua tangan — tangan kiri dengan telunjuk dan jari tengah mengarah ke kanan secara horizontal (membentuk dua garis), tangan kanan dengan telunjuk mengarah ke atas menyentuh dari bawah, membentuk pola huruf F.',
            ],
            [
                'language'       => 'bisindo',
                'level'          => 'menengah',
                'image_path'     => 'bisindo/menengah/g.png',
                'correct_answer' => 'G',
                'options'        => ['G', 'L', 'H', 'D'],
                'explanation'    => 'Huruf G dalam BISINDO: dua tangan mengepal penuh dengan semua jari tertutup rapat, diposisikan bertumpuk secara vertikal — kepalan tangan kanan di atas kepalan tangan kiri.',
            ],
            [
                'language'       => 'bisindo',
                'level'          => 'menengah',
                'image_path'     => 'bisindo/menengah/h.png',
                'correct_answer' => 'H',
                'options'        => ['H', 'G', 'U', 'K'],
                'explanation'    => 'Huruf H dalam BISINDO: dua tangan dengan masing-masing satu telunjuk tegak ke atas — tangan kiri telunjuknya miring ke kanan dan tangan kanan telunjuknya berdiri lurus, keduanya membentuk dua tiang seperti huruf H.',
            ],
            [
                'language'       => 'bisindo',
                'level'          => 'menengah',
                'image_path'     => 'bisindo/menengah/i.png',
                'correct_answer' => 'I',
                'options'        => ['I', 'J', 'Y', 'D'],
                'explanation'    => 'Huruf I dalam BISINDO: satu tangan dengan hanya telunjuk berdiri lurus tegak ke atas. Semua jari lainnya — tengah, manis, kelingking, dan ibu jari — terlipat rapat membentuk genggaman.',
            ],
            [
                'language'       => 'bisindo',
                'level'          => 'menengah',
                'image_path'     => 'bisindo/menengah/k.png',
                'correct_answer' => 'K',
                'options'        => ['K', 'P', 'V', 'U'],
                'explanation'    => 'Huruf K dalam BISINDO: dua tangan — tangan kanan dengan telunjuk berdiri lurus ke atas, tangan kiri dengan telunjuk yang melengkung/ditekuk menyentuh sisi telunjuk tangan kanan dari samping, membentuk cabang seperti huruf K.',
            ],
            [
                'language'       => 'bisindo',
                'level'          => 'menengah',
                'image_path'     => 'bisindo/menengah/p.png',
                'correct_answer' => 'P',
                'options'        => ['P', 'K', 'D', 'B'],
                'explanation'    => 'Huruf P dalam BISINDO: tangan kiri membentuk telunjuk yang tegak lurus ke atas, sementara tangan kanan membentuk sudut dengan telunjuk yang ditekuk dan ditempelkan pada ujung telunjuk tangan kiri. Kombinasi kedua tangan ini membentuk representasi huruf P.',
            ],
            [
                'language'       => 'bisindo',
                'level'          => 'menengah',
                'image_path'     => 'bisindo/menengah/q.png',
                'correct_answer' => 'Q',
                'options'        => ['Q', 'G', 'P', 'O'],
                'explanation'    => 'Huruf Q dalam BISINDO: tangan kiri membentuk lingkaran menggunakan ibu jari dan telunjuk, sedangkan tangan kanan membentuk telunjuk yang mengarah ke atas dan menyentuh bagian bawah lingkaran tersebut. Susunan kedua tangan menghasilkan bentuk yang menyerupai huruf Q.',
            ],

        ];
    }

    // ══════════════════════════════════════════════════
    //  BISINDO — MAHIR  (M N R S U V W X Y Z)
    // ══════════════════════════════════════════════════
    private function bisindoMahir(): array
    {
        return [
            [
                'language'       => 'bisindo',
                'level'          => 'mahir',
                'image_path'     => 'bisindo/mahir/m.png',
                'correct_answer' => 'M',
                'options'        => ['M', 'N', 'E', 'W'],
                'explanation'    => 'Huruf M dalam BISINDO: dua tangan berhadapan — tangan kanan membuka lebar dengan semua jari terbuka menghadap ke depan, tangan kiri menempel di telapak tangan kanan dari bawah dengan jari-jari kiri ikut melebar. Kedua telapak saling bersentuhan.',
            ],
            [
                'language'       => 'bisindo',
                'level'          => 'mahir',
                'image_path'     => 'bisindo/mahir/n.png',
                'correct_answer' => 'N',
                'options'        => ['N', 'M', 'H', 'U'],
                'explanation'    => 'Huruf N dalam BISINDO: dua tangan berhadapan — tangan kanan membuka lebar dengan semua jari terentang ke atas, tangan kiri dengan telunjuk saja yang menunjuk menyentuh telapak tangan kanan dari bawah. Beda dari M: hanya satu jari (telunjuk) yang menyentuh, bukan seluruh telapak.',
            ],
            [
                'language'       => 'bisindo',
                'level'          => 'mahir',
                'image_path'     => 'bisindo/mahir/r.png',
                'correct_answer' => 'R',
                'options'        => ['R', 'U', 'V', 'K'],
                'explanation'    => 'Huruf R dalam BISINDO: satu tangan dengan telunjuk lurus ke atas dan jari tengah terentang ke samping-bawah sehingga kedua jari membentuk sudut seperti cabang R. Manis, kelingking, dan ibu jari terlipat ke dalam.',
            ],
            [
                'language'       => 'bisindo',
                'level'          => 'mahir',
                'image_path'     => 'bisindo/mahir/s.png',
                'correct_answer' => 'S',
                'options'        => ['S', 'A', 'E', 'M'],
                'explanation'    => 'Huruf S dalam BISINDO: dua tangan berinteraksi — kedua tangan dengan jari-jari melengkung/menekuk saling bersentuhan di ujung jari, membentuk pola huruf S. Tangan kiri di bawah-kiri dan tangan kanan di atas-kanan.',
            ],
            [
                'language'       => 'bisindo',
                'level'          => 'mahir',
                'image_path'     => 'bisindo/mahir/u.png',
                'correct_answer' => 'U',
                'options'        => ['U', 'V', 'H', 'N'],
                'explanation'    => 'Huruf U dalam BISINDO: satu tangan dengan telunjuk dan kelingking berdiri lurus ke atas membentuk dua tiang huruf U, sementara ibu jari, jari tengah, dan manis terlipat ke dalam. Bentuknya seperti tanduk atau simbol rock.',
            ],
            [
                'language'       => 'bisindo',
                'level'          => 'mahir',
                'image_path'     => 'bisindo/mahir/v.png',
                'correct_answer' => 'V',
                'options'        => ['V', 'U', 'R', 'K'],
                'explanation'    => 'Huruf V dalam BISINDO: satu tangan dengan telunjuk dan jari tengah berdiri lurus ke atas dan terbuka membentuk huruf V atau tanda damai. Ibu jari, manis, dan kelingking terlipat rapat ke dalam genggaman.',
            ],
            [
                'language'       => 'bisindo',
                'level'          => 'mahir',
                'image_path'     => 'bisindo/mahir/w.png',
                'correct_answer' => 'W',
                'options'        => ['W', 'V', 'M', 'F'],
                'explanation'    => 'Huruf W dalam BISINDO: dua tangan — masing-masing hanya telunjuk yang berdiri tegak ke atas, sementara ibu jari kedua tangan saling bertemu di tengah membentuk lembah. Secara keseluruhan kedua tangan bersama membentuk pola huruf W.',
            ],
            [
                'language'       => 'bisindo',
                'level'          => 'mahir',
                'image_path'     => 'bisindo/mahir/x.png',
                'correct_answer' => 'X',
                'options'        => ['X', 'D', 'G', 'I'],
                'explanation'    => 'Huruf X dalam BISINDO: dua tangan masing-masing dengan telunjuk lurus ke atas, lalu kedua telunjuk disilangkan satu sama lain membentuk tanda silang atau huruf X. Jari-jari lainnya mengepal.',
            ],
            [
                'language'       => 'bisindo',
                'level'          => 'mahir',
                'image_path'     => 'bisindo/mahir/y.png',
                'correct_answer' => 'Y',
                'options'        => ['Y', 'I', 'L', 'V'],
                'explanation'    => 'Huruf Y dalam BISINDO: dua tangan — tangan kiri dengan telunjuk berdiri tegak ke atas, tangan kanan dengan telunjuk mengarah serong menyentuh sisi bawah telunjuk tangan kiri, sehingga keduanya bersama membentuk cabang huruf Y.',
            ],
            [
                'language'       => 'bisindo',
                'level'          => 'mahir',
                'image_path'     => 'bisindo/mahir/z.png',
                'correct_answer' => 'Z',
                'options'        => ['Z', 'J', 'X', 'S'],
                'explanation'    => 'Huruf Z dalam BISINDO: satu tangan dengan semua jari dirapatkan dan telapak menghadap ke bawah-depan, membentuk posisi tangan datar horizontal seperti siap menulis huruf Z di udara.',
            ],
        ];
    }

    // ══════════════════════════════════════════════════
    //  SIBI — PEMULA  (A B C D L O J T)
    // ══════════════════════════════════════════════════
    private function sibiPemula(): array
    {
        return [
            [
                'language'       => 'sibi',
                'level'          => 'pemula',
                'image_path'     => 'sibi/pemula/a.png',
                'correct_answer' => 'A',
                'options'        => ['A', 'E', 'S', 'N'],
                'explanation'    => 'Huruf A dalam SIBI: kedua tangan berhadapan, masing-masing telunjuk berdiri lurus ke atas membentuk puncak segitiga, sementara ibu jari dan jari lainnya melengkung ke bawah saling bertemu di tengah membentuk kerangka huruf A.',
            ],
            [
                'language'       => 'sibi',
                'level'          => 'pemula',
                'image_path'     => 'sibi/pemula/b.png',
                'correct_answer' => 'B',
                'options'        => ['B', 'P', 'D', 'F'],
                'explanation'    => 'Huruf B dalam SIBI: dua tangan saling berhadapan miring, ujung-ujung jari kedua tangan saling menyentuh membentuk pola bingkai diagonal — tangan kiri di atas miring ke kanan, tangan kanan di bawah miring ke kiri.',
            ],
            [
                'language'       => 'sibi',
                'level'          => 'pemula',
                'image_path'     => 'sibi/pemula/c.png',
                'correct_answer' => 'C',
                'options'        => ['C', 'O', 'G', 'E'],
                'explanation'    => 'Huruf C dalam SIBI: satu tangan dengan telunjuk terangkat ke atas-samping dan ibu jari terentang ke bawah-samping membentuk bukaan huruf C. Jari tengah, manis, dan kelingking terlipat ke dalam telapak.',
            ],
            [
                'language'       => 'sibi',
                'level'          => 'pemula',
                'image_path'     => 'sibi/pemula/d.png',
                'correct_answer' => 'D',
                'options'        => ['D', 'B', 'G', 'P'],
                'explanation'    => 'Huruf D dalam SIBI: dua tangan membentuk sudut siku-siku — telunjuk tangan kiri mengarah diagonal ke kanan-atas dan telunjuk tangan kanan berdiri tegak ke atas, keduanya bertemu di ujung membentuk sudut 90 derajat seperti huruf D.',
            ],
            [
                'language'       => 'sibi',
                'level'          => 'pemula',
                'image_path'     => 'sibi/pemula/l.png',
                'correct_answer' => 'L',
                'options'        => ['L', 'G', 'Y', 'K'],
                'explanation'    => 'Huruf L dalam SIBI: satu tangan membentuk sudut siku-siku seperti huruf L — telunjuk berdiri lurus ke atas dan ibu jari terentang penuh ke samping horizontal. Jari tengah, manis, dan kelingking terlipat rapat ke dalam telapak.',
            ],
            [
                'language'       => 'sibi',
                'level'          => 'pemula',
                'image_path'     => 'sibi/pemula/o.png',
                'correct_answer' => 'O',
                'options'        => ['O', 'C', 'D', 'A'],
                'explanation'    => 'Huruf O dalam SIBI: satu tangan membentuk lingkaran penuh — semua ujung jari (telunjuk, tengah, manis, kelingking) bertemu dengan ujung ibu jari membentuk lingkaran bulat seperti huruf O.',
            ],
            [
                'language'       => 'sibi',
                'level'          => 'pemula',
                'image_path'     => 'sibi/pemula/j.png',
                'correct_answer' => 'J',
                'options'        => ['J', 'I', 'Z', 'G'],
                'explanation'    =>  'Huruf J dalam SIBI: tangan membentuk kepalan ringan dengan telunjuk tegak lurus mengarah ke atas, sementara jari tengah, manis, dan kelingking ditekuk ke dalam serta ibu jari menahan di samping. Posisi telunjuk yang berdiri lurus menjadi ciri utama pembentukan huruf J.',
            ],
            [
                'language'       => 'sibi',
                'level'          => 'pemula',
                'image_path'     => 'sibi/pemula/t.png',
                'correct_answer' => 'T',
                'options'        => ['T', 'A', 'N', 'S'],
                'explanation'    => 'Huruf T dalam SIBI: tangan membentuk kepalan dengan telunjuk tegak lurus mengarah ke atas, sedangkan jari tengah, manis, dan kelingking ditekuk rapat ke dalam. Ibu jari berada di samping atau menempel pada bagian telunjuk yang tertekuk, sehingga membentuk konfigurasi khas huruf T.',
            ],
        ];
    }

    // ══════════════════════════════════════════════════
    //  SIBI — MENENGAH  (E F G H I K P Q)
    // ══════════════════════════════════════════════════
    private function sibiMenengah(): array
    {
        return [
            [
                'language'       => 'sibi',
                'level'          => 'menengah',
                'image_path'     => 'sibi/menengah/e.png',
                'correct_answer' => 'E',
                'options'        => ['E', 'A', 'B', 'S'],
                'explanation'    => 'Huruf E dalam SIBI: satu tangan dengan tiga jari (telunjuk, tengah, dan manis) berdiri lurus ke atas dan terbuka menghadap ke depan, sementara ibu jari dan kelingking terlipat ke dalam telapak tangan.',
            ],
            [
                'language'       => 'sibi',
                'level'          => 'menengah',
                'image_path'     => 'sibi/menengah/f.png',
                'correct_answer' => 'F',
                'options'        => ['F', 'W', 'E', 'G'],
                'explanation'    => 'Huruf F dalam SIBI: dua tangan — tangan kiri dengan telunjuk dan jari tengah mengarah ke kanan secara horizontal, tangan kanan dengan telunjuk mengarah ke atas menyentuh dari bawah, membentuk pola perpotongan seperti huruf F.',
            ],
            [
                'language'       => 'sibi',
                'level'          => 'menengah',
                'image_path'     => 'sibi/menengah/g.png',
                'correct_answer' => 'G',
                'options'        => ['G', 'L', 'D', 'H'],
                'explanation'    => 'Huruf G dalam SIBI: dua tangan mengepal penuh dengan semua jari tertutup rapat, diposisikan saling bertumpuk secara vertikal — kepalan tangan kanan berada tepat di atas kepalan tangan kiri.',
            ],
            [
                'language'       => 'sibi',
                'level'          => 'menengah',
                'image_path'     => 'sibi/menengah/h.png',
                'correct_answer' => 'H',
                'options'        => ['H', 'G', 'K', 'U'],
                'explanation'    => 'Huruf H dalam SIBI: dua tangan dengan masing-masing satu telunjuk tegak ke atas — tangan kiri telunjuknya miring ke kanan dan tangan kanan telunjuknya berdiri lurus, keduanya membentuk dua tiang seperti huruf H.',
            ],
            [
                'language'       => 'sibi',
                'level'          => 'menengah',
                'image_path'     => 'sibi/menengah/i.png',
                'correct_answer' => 'I',
                'options'        => ['I', 'J', 'Y', 'L'],
                'explanation'    => 'Huruf I dalam SIBI: satu tangan dengan hanya telunjuk berdiri lurus tegak ke atas. Semua jari lainnya — tengah, manis, kelingking, dan ibu jari — terlipat rapat membentuk genggaman.',
            ],
            [
                'language'       => 'sibi',
                'level'          => 'menengah',
                'image_path'     => 'sibi/menengah/k.png',
                'correct_answer' => 'K',
                'options'        => ['K', 'V', 'U', 'P'],
                'explanation'    => 'Huruf K dalam SIBI: dua tangan — tangan kanan dengan telunjuk berdiri lurus ke atas, tangan kiri dengan telunjuk yang melengkung/ditekuk menyentuh sisi telunjuk tangan kanan dari samping, membentuk cabang seperti huruf K.',
            ],
            [
                'language'       => 'sibi',
                'level'          => 'menengah',
                'image_path'     => 'sibi/menengah/p.png',
                'correct_answer' => 'P',
                'options'        => ['P', 'K', 'F', 'D'],
                'explanation'    => 'Huruf P dalam SIBI: telunjuk dan jari tengah diluruskan ke bawah membentuk sudut terbuka menyerupai huruf V terbalik, sementara jari manis dan kelingking ditekuk ke dalam. Ibu jari menahan jari yang tertekuk sehingga menghasilkan bentuk khas huruf P.',
            ],
            [
                'language'       => 'sibi',
                'level'          => 'menengah',
                'image_path'     => 'sibi/menengah/q.png',
                'correct_answer' => 'Q',
                'options'        => ['Q', 'G', 'P', 'C'],
                'explanation'    => 'Huruf Q dalam SIBI: telunjuk dan ibu jari diluruskan mengarah ke bawah dengan jarak yang terpisah, sedangkan jari tengah, jari manis, dan kelingking ditekuk ke dalam telapak tangan. Bentuk ini menciptakan konfigurasi tangan yang menjadi ciri khas huruf Q.',
            ],
        ];
    }

    // ══════════════════════════════════════════════════
    //  SIBI — MAHIR  (M N R S U V W X Y Z)
    // ══════════════════════════════════════════════════
    private function sibiMahir(): array
    {
        return [
            [
                'language'       => 'sibi',
                'level'          => 'mahir',
                'image_path'     => 'sibi/mahir/m.png',
                'correct_answer' => 'M',
                'options'        => ['M', 'N', 'S', 'E'],
                'explanation'    => 'Huruf M dalam SIBI: dua tangan berhadapan — tangan kanan membuka lebar dengan semua jari terbuka menghadap ke depan, tangan kiri menempel di telapak tangan kanan dari bawah dengan jari-jari kiri ikut melebar. Kedua telapak saling bersentuhan.',
            ],
            [
                'language'       => 'sibi',
                'level'          => 'mahir',
                'image_path'     => 'sibi/mahir/n.png',
                'correct_answer' => 'N',
                'options'        => ['N', 'M', 'U', 'H'],
                'explanation'    => 'Huruf N dalam SIBI: dua tangan berhadapan — tangan kanan membuka lebar dengan semua jari terentang ke atas, tangan kiri dengan telunjuk saja yang menunjuk menyentuh telapak tangan kanan dari bawah. Beda dari M: hanya satu jari (telunjuk) yang menyentuh, bukan seluruh telapak.',
            ],
            [
                'language'       => 'sibi',
                'level'          => 'mahir',
                'image_path'     => 'sibi/mahir/r.png',
                'correct_answer' => 'R',
                'options'        => ['R', 'V', 'U', 'N'],
                'explanation'    => 'Huruf R dalam SIBI: satu tangan dengan telunjuk lurus ke atas dan jari tengah terentang ke samping-bawah, sehingga kedua jari membentuk sudut seperti cabang huruf R. Manis, kelingking, dan ibu jari terlipat ke dalam.',
            ],
            [
                'language'       => 'sibi',
                'level'          => 'mahir',
                'image_path'     => 'sibi/mahir/s.png',
                'correct_answer' => 'S',
                'options'        => ['S', 'A', 'M', 'E'],
                'explanation'    => 'Huruf S dalam SIBI: dua tangan dengan jari-jari melengkung saling bersentuhan di ujung jari, membentuk pola huruf S — tangan kiri di bawah-kiri dengan jari menekuk ke atas, tangan kanan di atas-kanan dengan jari menekuk ke bawah, keduanya bertemu di tengah.',
            ],
            [
                'language'       => 'sibi',
                'level'          => 'mahir',
                'image_path'     => 'sibi/mahir/u.png',
                'correct_answer' => 'U',
                'options'        => ['U', 'V', 'R', 'H'],
                'explanation'    => 'Huruf U dalam SIBI: satu tangan dengan telunjuk dan kelingking berdiri lurus ke atas membentuk dua tiang huruf U, sementara ibu jari, jari tengah, dan manis terlipat ke dalam. Bentuknya seperti tanduk atau simbol rock.',
            ],
            [
                'language'       => 'sibi',
                'level'          => 'mahir',
                'image_path'     => 'sibi/mahir/v.png',
                'correct_answer' => 'V',
                'options'        => ['V', 'U', 'K', 'R'],
                'explanation'    => 'Huruf V dalam SIBI: satu tangan dengan telunjuk dan jari tengah berdiri lurus ke atas dan terbuka membentuk huruf V atau tanda damai. Ibu jari, manis, dan kelingking terlipat rapat ke dalam genggaman.',
            ],
            [
                'language'       => 'sibi',
                'level'          => 'mahir',
                'image_path'     => 'sibi/mahir/w.png',
                'correct_answer' => 'W',
                'options'        => ['W', 'V', 'F', 'M'],
                'explanation'    => 'Huruf W dalam SIBI: dua tangan — masing-masing hanya telunjuk yang berdiri tegak ke atas, sementara ibu jari kedua tangan saling bertemu di tengah membentuk lembah. Secara keseluruhan kedua tangan bersama membentuk pola huruf W.',
            ],
            [
                'language'       => 'sibi',
                'level'          => 'mahir',
                'image_path'     => 'sibi/mahir/x.png',
                'correct_answer' => 'X',
                'options'        => ['X', 'G', 'D', 'I'],
                'explanation'    => 'Huruf X dalam SIBI: dua tangan masing-masing dengan telunjuk lurus ke atas, lalu kedua telunjuk disilangkan satu sama lain membentuk tanda silang atau huruf X. Jari-jari lainnya mengepal.',
            ],
            [
                'language'       => 'sibi',
                'level'          => 'mahir',
                'image_path'     => 'sibi/mahir/y.png',
                'correct_answer' => 'Y',
                'options'        => ['Y', 'I', 'L', 'K'],
                'explanation'    => 'Huruf Y dalam SIBI: satu tangan dengan ibu jari terentang lebar ke samping kiri dan kelingking berdiri tegak ke atas kanan, membentuk gestur shaka/hang loose. Jari telunjuk, tengah, dan manis terlipat ke dalam telapak.',
            ],
            [
                'language'       => 'sibi',
                'level'          => 'mahir',
                'image_path'     => 'sibi/mahir/z.png',
                'correct_answer' => 'Z',
                'options'        => ['Z', 'X', 'J', 'I'],
                'explanation'    => 'Huruf Z dalam SIBI: satu tangan dengan semua jari dirapatkan dan telapak menghadap ke bawah-depan, membentuk posisi tangan datar horizontal seperti siap menulis huruf Z di udara.',
            ],
        ];
    }
}