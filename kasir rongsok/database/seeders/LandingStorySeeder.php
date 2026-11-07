<?php

namespace Database\Seeders;

use App\Models\LandingStory;
use App\Models\LandingStoryComment;
use Illuminate\Database\Seeder;

class LandingStorySeeder extends Seeder
{
    public function run(): void
    {
        // Only seed if empty
        if (LandingStory::count() > 0) {
            return;
        }

        $stories = [
            [
                'title' => 'Bongkaran Konstruksi & Scrap Besi H-Beam',
                'subtitle' => 'Depo Srengseng Sawah • Jagakarsa',
                'tag' => 'Bongkaran Pabrik',
                'image_path' => 'uploads/hero/hero_sub3_1793883076.webp',
                'caption' => 'Penerimaan besi tua potongan H-Beam dan WF eks proyek konstruksi. Penimbangan langsung dengan jembatan timbang akurat.',
                'likes_count' => 142,
                'order' => 1,
                'comments' => [
                    [
                        'user_name' => 'Michael Chen (Kontraktor)',
                        'comment' => 'Berapa kapasitas tonase maksimal untuk penjemputan scrap besi WF?',
                        'original_comment' => 'What is the maximum tonnage capacity for scrap WF steel pickup?',
                        'detected_language' => 'en',
                        'is_translated' => true,
                        'likes_count' => 5,
                    ],
                    [
                        'user_name' => 'H. Bambang Sugiarto',
                        'comment' => 'Pelayanan sangat mantap, uang kontan langsung cair begitu timbangan selesai.',
                        'original_comment' => 'Pelayanan sangat mantap, uang kontan langsung cair begitu timbangan selesai.',
                        'detected_language' => 'id',
                        'is_translated' => false,
                        'likes_count' => 8,
                    ],
                ],
            ],
            [
                'title' => 'Armada Truk & Pick-Up Siap Jemput Scrap',
                'subtitle' => 'Wilayah Jabodetabek & Sekitarnya',
                'tag' => 'Armada Angkut',
                'image_path' => 'uploads/hero/hero_sub2_1793883076.webp',
                'caption' => 'Armada logistik kami beroperasi setiap hari untuk melayani penjemputan scrap industri, bengkel, dan pergudangan tanpa biaya tambahan.',
                'likes_count' => 189,
                'order' => 2,
                'comments' => [
                    [
                        'user_name' => 'Pak Joko Widodo (Bengkel Bubut)',
                        'comment' => 'Apakah bisa menjemput scrap gram besi di daerah Cikarang besok lusa?',
                        'original_comment' => 'Menopo saged nampi jemputan gram wesi wonten tlatah Cikarang mbenjing?',
                        'detected_language' => 'jw',
                        'is_translated' => true,
                        'likes_count' => 7,
                    ],
                    [
                        'user_name' => 'David Lee',
                        'comment' => 'Respon cepat dan penimbangan sangat transparan. Rekomendasi sekali!',
                        'original_comment' => 'Very fast response and completely transparent weighing. Highly recommended!',
                        'detected_language' => 'en',
                        'is_translated' => true,
                        'likes_count' => 12,
                    ],
                ],
            ],
            [
                'title' => 'Pemilahan Scrap Tembaga, Kuningan & Aluminium',
                'subtitle' => 'Kategori Logam Non-Ferrous',
                'tag' => 'Logam Mulia Scrap',
                'image_path' => 'uploads/hero/hero_sub1_1793883076.webp',
                'caption' => 'Sortir teliti jenis tembaga super, tembaga kabel, kuningan as, dan plat aluminium dengan penetapan kadar serta harga terbaik.',
                'likes_count' => 254,
                'order' => 3,
                'comments' => [
                    [
                        'user_name' => 'Kang Asep Sukardi',
                        'comment' => 'Harga tembaga super hari ini berapa per kilogram ya juragan?',
                        'original_comment' => 'Pangaos tambaga super dinten ieu sabaraha sakilo na juragan?',
                        'detected_language' => 'su',
                        'is_translated' => true,
                        'likes_count' => 15,
                    ],
                    [
                        'user_name' => 'Rudy Hendrawan',
                        'comment' => 'Timbangan digital ganda sangat jelas, penjual bisa melihat langsung angkanya tanpa takut curang.',
                        'original_comment' => 'Timbangan digital ganda sangat jelas, penjual bisa melihat langsung angkanya tanpa takut curang.',
                        'detected_language' => 'id',
                        'is_translated' => false,
                        'likes_count' => 19,
                    ],
                ],
            ],
            [
                'title' => 'Aktivitas Harian Depo & Penimbangan Digital Akurat',
                'subtitle' => 'PT. Seberaya Akses Multi Pusat',
                'tag' => 'Timbangan Digital Tera',
                'image_path' => 'uploads/hero/hero_main_1793882880.jpg',
                'caption' => 'Depo utama kami dengan sertifikasi kalibrasi metrologi resmi. Melayani ribuan transaksi setiap bulan dengan aman, jujur, dan terpercaya.',
                'likes_count' => 320,
                'order' => 4,
                'comments' => [
                    [
                        'user_name' => 'Robert Johnson',
                        'comment' => 'Fasilitas yang sangat rapi dan tertata untuk depo daur ulang logam. Sangat mengesankan!',
                        'original_comment' => 'Very neat and organized facility for metal recycling depot. Extremely impressive!',
                        'detected_language' => 'en',
                        'is_translated' => true,
                        'likes_count' => 22,
                    ],
                    [
                        'user_name' => 'Siti Nurhaliza',
                        'comment' => 'Pengepul pemula juga dilayani dengan sangat ramah, staf depo sangat membantu menurunkan barang.',
                        'original_comment' => 'Pengepul pemula juga dilayani dengan sangat ramah, staf depo sangat membantu menurunkan barang.',
                        'detected_language' => 'id',
                        'is_translated' => false,
                        'likes_count' => 31,
                    ],
                ],
            ],
        ];

        foreach ($stories as $storyData) {
            $comments = $storyData['comments'] ?? [];
            unset($storyData['comments']);

            $story = LandingStory::create($storyData);

            foreach ($comments as $commentData) {
                $commentData['story_id'] = $story->id;
                LandingStoryComment::create($commentData);
            }
        }
    }
}

