<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModulSeeder extends Seeder
{
    public function run(): void
    {
        // Kosongkan tabel terlebih dahulu
        DB::table('moduls')->truncate();

        $data = array_merge(
            $this->sibiData(),
            $this->bisindoData()
        );

        foreach ($data as $item) {
            DB::table('moduls')->insert($item);
        }

        $this->command->info('✅ ' . count($data) . ' data modul berhasil dimasukkan.');
        $this->command->table(
            ['Modul', 'Huruf', 'Jumlah'],
            [
                ['SIBI', 'A-Z', count($this->sibiData())],
                ['BISINDO', 'A-Z', count($this->bisindoData())],
            ]
        );
    }

    private function sibiData(): array
    {
        $hurufList = range('A', 'Z');
        $data = [];

        $penjelasan = [
            'A' => 'Kepalkan tangan, ibu jari di samping telunjuk. Tangan menghadap ke depan.',
            'B' => 'Telapak tangan terbuka, jari rapat, ibu jari di atas telapak.',
            'C' => 'Bentuk tangan melengkung seperti huruf C.',
            'D' => 'Telunjuk lurus ke atas, jari lain mengepal, ibu jari di atas.',
            'E' => 'Telapak tangan menghadap ke bawah, jari rapat dan lurus.',
            'F' => 'Ibu jari dan telunjuk membentuk lingkaran, jari lain lurus.',
            'G' => 'Telunjuk lurus ke samping, ibu jari di atas telunjuk.',
            'H' => 'Telunjuk dan jari tengah lurus ke samping, jari lain mengepal.',
            'I' => 'Kelingking lurus ke atas, jari lain mengepal, ibu jari di atas.',
            'J' => 'Kelingking lurus ke atas lalu melengkung seperti huruf J.',
            'K' => 'Telunjuk dan jari tengah membentuk V, ibu jari di antara.',
            'L' => 'Telunjuk lurus ke atas, ibu jari lurus ke samping membentuk L.',
            'M' => 'Kepalkan tangan, ibu jari di antara telunjuk dan tengah.',
            'N' => 'Kepalkan tangan, ibu jari di antara tengah dan manis.',
            'O' => 'Bentuk lingkaran dengan ibu jari dan telunjuk.',
            'P' => 'Telunjuk lurus ke bawah, ibu jari lurus ke samping.',
            'Q' => 'Telunjuk dan ibu jari membentuk lingkaran kecil, jari lain mengepal.',
            'R' => 'Telunjuk dan jari tengah menyilang, ibu jari di atas.',
            'S' => 'Kepalkan tangan, ibu jari di atas jari telunjuk.',
            'T' => 'Kepalkan tangan, ibu jari di antara telunjuk dan tengah.',
            'U' => 'Telunjuk dan jari tengah lurus ke atas rapat.',
            'V' => 'Telunjuk dan jari tengah membentuk V.',
            'W' => 'Telunjuk, tengah, dan manis lurus ke atas membentuk W.',
            'X' => 'Tekuk telunjuk seperti kait, jari lain mengepal.',
            'Y' => 'Ibu jari dan kelingking lurus, jari lain mengepal.',
            'Z' => 'Telunjuk lurus ke samping dengan gerakan zigzag.',
        ];

        foreach ($hurufList as $huruf) {
            $data[] = [
                'modul' => 'SIBI',
                'huruf' => $huruf,
                'thumbnail' => 'alphabet/sibi/' . strtolower($huruf) . '.png',
                'penjelasan' => $penjelasan[$huruf] ?? 'Isyarat huruf ' . $huruf . ' dalam SIBI.',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        return $data;
    }

    private function bisindoData(): array
    {
        $hurufList = range('A', 'Z');
        $data = [];

        $penjelasan = [
            'A' => 'Kepalkan tangan, ibu jari di depan jari telunjuk.',
            'B' => 'Telapak tangan terbuka menghadap ke depan, jari rapat.',
            'C' => 'Bentuk tangan melengkung seperti memegang bola.',
            'D' => 'Telunjuk lurus ke atas, ibu jari menempel di tengah.',
            'E' => 'Telapak tangan menghadap ke bawah, jari ditekuk ke dalam.',
            'F' => 'Ibu jari dan telunjuk membentuk lingkaran, tiga jari lain lurus.',
            'G' => 'Telunjuk lurus ke samping, ibu jari di atasnya.',
            'H' => 'Telunjuk dan jari tengah lurus ke samping, jari lain mengepal.',
            'I' => 'Kelingking lurus ke atas, jari lain mengepal.',
            'J' => 'Kelingking lurus lalu membentuk lengkungan ke bawah.',
            'K' => 'Telunjuk dan jari tengah membentuk V, ibu jari di antara.',
            'L' => 'Telunjuk dan ibu jari membentuk sudut 90 derajat.',
            'M' => 'Kepalkan tangan, ibu jari di atas jari manis.',
            'N' => 'Kepalkan tangan, ibu jari di atas jari tengah.',
            'O' => 'Ujung ibu jari dan telunjuk membentuk lingkaran.',
            'P' => 'Telunjuk lurus ke bawah dengan ibu jari di samping.',
            'Q' => 'Telunjuk dan ibu jari membentuk lingkaran di depan mulut.',
            'R' => 'Telunjuk dan jari tengah menyilang.',
            'S' => 'Kepalkan tangan dengan ibu jari di atas.',
            'T' => 'Kepalkan tangan, ibu jari di antara telunjuk dan tengah.',
            'U' => 'Telunjuk dan jari tengah lurus ke atas rapat.',
            'V' => 'Telunjuk dan jari tengah membentuk V lebar.',
            'W' => 'Tiga jari lurus ke atas (telunjuk, tengah, manis).',
            'X' => 'Telunjuk melengkung seperti pengait.',
            'Y' => 'Ibu jari dan kelingking lurus ke samping.',
            'Z' => 'Telunjuk lurus ke samping dengan gerakan zigzag.',
        ];

        foreach ($hurufList as $huruf) {
            $data[] = [
                'modul' => 'BISINDO',
                'huruf' => $huruf,
                'thumbnail' => 'alphabet/bisindo/' . strtolower($huruf) . '.png',
                'penjelasan' => $penjelasan[$huruf] ?? 'Isyarat huruf ' . $huruf . ' dalam BISINDO.',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        return $data;
    }
}
