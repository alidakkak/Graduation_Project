<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('announcements')->insert([
            [
                'title' => 'إعــلان هام',
                'description' => 'بناءً على تعميم وزارة التعليم العالي
على الطلاب الذين لم يتمكنوا من حضور جلسات العملي خلال الفصل الثاني من العام الدراسي 2024-2025، التقدم بطلبات لسكرتاريا القسم التابع له اعتباراً من يوم الثلاثاء 2025/6/14 ولغاية نهاية الدوام الرسمي يوم الخميس 2025/6/19.

وسيتم دراسة الطلبات من قبل رؤساء الأقسام.',
                'academic_year' => '6',
                'specialization' => '4'
            ],
        ]);

        DB::table('announcement_images')->insert([
            'announcement_id' => 1,
            'image' => '/announcements_image/ann1.jpg"'
        ]);
    }
}
