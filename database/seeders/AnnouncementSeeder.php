<?php

namespace Database\Seeders;

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
                'specialization' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('announcement_images')->insert([
            'announcement_id' => 1,
            'image' => '/announcements_image/ann1.jpg',
        ]);

        DB::table('announcements')->insert([
            [
                'title' => 'إعلان لطلاب السنة الأولى',
                'description' => 'نرحب بطلاب السنة الأولى في كلية الهندسة المعلوماتية، وننصحكم بالالتزام بالمحاضرات النظرية والعملية والتواصل مع المرشد الأكاديمي لحل أي إشكاليات أكاديمية.',
                'academic_year' => '1',
                'specialization' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('announcement_images')->insert([
            'announcement_id' => 2,
            'image' => '/announcements_image/ann2.jpg',
        ]);

        DB::table('announcements')->insert([
            [
                'title' => 'إعلان لطلاب السنة الثانية',
                'description' => 'على طلاب السنة الثانية مراجعة جداولهم الدراسية المحدثة والتأكد من مواعيد المختبرات العملية. كما ننوه إلى ضرورة استكمال متطلبات المواد الأساسية تمهيداً للتخصص في السنوات القادمة.',
                'academic_year' => '2',
                'specialization' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('announcement_images')->insert([
            'announcement_id' => 3,
            'image' => '/announcements_image/ann1.jpg',
        ]);

        DB::table('announcements')->insert([
            [
                'title' => 'إعلان لطلاب السنة الثالثة',
                'description' => 'تبدأ مرحلة التعمق في المواد التخصصية في السنة الثالثة، لذا نحث الطلاب على متابعة المحاضرات العملية بعناية، مع الاستفادة من الموارد الإلكترونية المتاحة عبر المنصة الجامعية.',
                'academic_year' => '3',
                'specialization' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('announcement_images')->insert([
            'announcement_id' => 4,
            'image' => '/announcements_image/ann3.jpg',
        ]);

        DB::table('announcements')->insert([
            [
                'title' => 'إعلان لطلاب السنة الرابعة جميع الاختصاصات',
                'description' => 'ندعو طلاب السنة الرابعة إلى الاهتمام بالمقررات التطبيقية والمشاريع العملية، إذ تشكل أساساً مهماً للتحضير لمشروع التخرج. كما يرجى متابعة فرص التدريب العملي المتاحة عبر الكلية.',
                'academic_year' => '4',
                'specialization' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('announcement_images')->insert([
            'announcement_id' => 5,
            'image' => '/announcements_image/ann3.jpg',
        ]);

        DB::table('announcements')->insert([
            [
                'title' => 'إعلان لطلاب السنة الرابعة هندسة برمجيات',
                'description' => '',
                'academic_year' => '4',
                'specialization' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('announcement_images')->insert([
            'announcement_id' => 6,
            'image' => '/announcements_image/ann2.jpg',
        ]);

        DB::table('announcements')->insert([
            [
                'title' => 'إعلان لطلاب السنة الخامسة',
                'description' => 'على طلاب السنة الخامسة الاستعداد لتسليم ومناقشة مشاريع التخرج، مع الالتزام بمواعيد الامتحانات النهائية. كما نؤكد أهمية التواصل مع المشرفين الأكاديميين لإنهاء متطلبات التخرج بنجاح.',
                'academic_year' => '5',
                'specialization' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('announcement_images')->insert([
            'announcement_id' => 7,
            'image' => '/announcements_image/ann2.jpg',
        ]);

        DB::table('announcements')->insert([
            [
                'title' => 'إعلان هام بخصوص الامتحانات',
                'description' => 'يرجى من جميع الطلاب الالتزام بمواعيد الامتحانات النهائية، والتأكد من اصطحاب البطاقة الجامعية قبل الدخول إلى قاعات الامتحان.',
                'academic_year' => '6',
                'specialization' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('announcement_images')->insert([
            'announcement_id' => 8,
            'image' => '/announcements_image/ann3.jpg',
        ]);

        DB::table('announcements')->insert([
            [
                'title' => 'فرص تدريب عملي',
                'description' => 'تعلن الكلية عن فتح باب التسجيل لفرص التدريب العملي في الشركات التقنية المحلية، فعلى الراغبين مراجعة مكتب شؤون الطلاب لتقديم الطلبات.',
                'academic_year' => '5',
                'specialization' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('announcement_images')->insert([
            'announcement_id' => 9,
            'image' => '/announcements_image/ann2.jpg',
        ]);

        DB::table('announcements')->insert([
            [
                'title' => 'تعليق محاضرات',
                'description' => 'نظرًا للظروف الجوية، سيتم تعليق جميع المحاضرات ليوم غد على أن يتم تعويضها لاحقاً وفق جدول يعلن لاحقاً.',
                'academic_year' => '5',
                'specialization' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('announcement_images')->insert([
            'announcement_id' => 10,
            'image' => '/announcements_image/ann1.jpg',
        ]);

        DB::table('announcements')->insert([
            [
                'title' => 'ورشة عمل برمجية',
                'description' => 'تنظم الكلية ورشة عمل بعنوان "مدخل إلى الذكاء الاصطناعي" يوم السبت القادم، الدعوة عامة لجميع الطلاب مع منح شهادات حضور.',
                'academic_year' => '3',
                'specialization' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('announcement_images')->insert([
            'announcement_id' => 11,
            'image' => '/announcements_image/ann3.jpg',
        ]);
    }
}
