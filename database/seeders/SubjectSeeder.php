<?php

namespace Database\Seeders;

use App\Statuses\Specialization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            // السنة الأولى
            ['name' => 'الجبر العام', 'academic_year_id' => 1, 'specialization' => Specialization::General],
            ['name' => 'تحليل 1', 'academic_year_id' => 1, 'specialization' => Specialization::General],
            ['name' => 'اللغة الإنكليزية 1', 'academic_year_id' => 1, 'specialization' => Specialization::General],
            ['name' => 'مبادئ عمل الحاسب', 'academic_year_id' => 1, 'specialization' => Specialization::General],
            ['name' => 'الفيزياء', 'academic_year_id' => 1, 'specialization' => Specialization::General],
            ['name' => 'برمجة 1', 'academic_year_id' => 1, 'specialization' => Specialization::General],
            // // فصل 2
            ['name' => 'الدارات الكهربائية والإلكترونية', 'academic_year_id' => 1, 'specialization' => Specialization::General],
            ['name' => 'تحليل 2', 'academic_year_id' => 1, 'specialization' => Specialization::General],
            ['name' => 'اللغة العربية', 'academic_year_id' => 1, 'specialization' => Specialization::General],
            ['name' => 'الجبر الخطي', 'academic_year_id' => 1, 'specialization' => Specialization::General],
            ['name' => 'اللغة الإنكليزية 2', 'academic_year_id' => 1, 'specialization' => Specialization::General],
            ['name' => 'الثقافة القومية الاشتراكية', 'academic_year_id' => 1, 'specialization' => Specialization::General],
            ['name' => 'برمجة 2', 'academic_year_id' => 2, 'specialization' => Specialization::General],

            // السنة الثانية
            ['name' => 'تحليل 3', 'academic_year_id' => 2, 'specialization' => Specialization::General],
            ['name' => 'الخوارزميات وبنى المعطيات 1', 'academic_year_id' => 3, 'specialization' => Specialization::General],
            ['name' => 'برمجة 3', 'academic_year_id' => 2, 'specialization' => Specialization::General],
            ['name' => 'اللغة الإنكليزية 3', 'academic_year_id' => 2, 'specialization' => Specialization::General],
            ['name' => 'الدارات المنطقية', 'academic_year_id' => 2, 'specialization' => Specialization::General],
            ['name' => 'الاحتمالات والإحصاء', 'academic_year_id' => 2, 'specialization' => Specialization::General],
            // // فصل 2
            ['name' => 'الاتصالات الرقمية ونظرية المعلومات', 'academic_year_id' => 2, 'specialization' => Specialization::General],
            ['name' => 'مهارات تواصل', 'academic_year_id' => 2, 'specialization' => Specialization::General],
            ['name' => 'بنيان الحواسيب 1', 'academic_year_id' => 2, 'specialization' => Specialization::General],
            ['name' => 'التحليل العددي', 'academic_year_id' => 2, 'specialization' => Specialization::General],
            ['name' => 'اللغة الإنكليزية 4', 'academic_year_id' => 2, 'specialization' => Specialization::General],
            ['name' => 'الخوارزميات وبنى المعطيات 2', 'academic_year_id' => 2, 'specialization' => Specialization::General],

            // السنة الثالثة
            ['name' => 'بحوث عمليات', 'academic_year_id' => 3, 'specialization' => Specialization::General],
            ['name' => 'بيانيات حاسوبية', 'academic_year_id' => 3, 'specialization' => Specialization::General],
            ['name' => 'بنيان الحواسيب 2', 'academic_year_id' => 3, 'specialization' => Specialization::General],
            ['name' => 'أساسيات الشبكات الحاسوبية', 'academic_year_id' => 3, 'specialization' => Specialization::General],
            ['name' => 'لغات البرمجة', 'academic_year_id' => 3, 'specialization' => Specialization::General],
            // /// فصل 2
            ['name' => 'مشروع 1', 'academic_year_id' => 3, 'specialization' => Specialization::General],
            ['name' => 'مبادئ الذكاء الصنعي', 'academic_year_id' => 3, 'specialization' => Specialization::General],
            ['name' => 'حسابات علمية', 'academic_year_id' => 3, 'specialization' => Specialization::General],
            ['name' => 'اللغات الصورية', 'academic_year_id' => 3, 'specialization' => Specialization::General],
            ['name' => 'قواعد المعطيات 1', 'academic_year_id' => 3, 'specialization' => Specialization::General],

            // السنة الرابعة - برمجيات
            ['name' => 'هندسة البرمجيات 1', 'academic_year_id' => 4, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'الاقتصاد والإدارة في المؤسسة', 'academic_year_id' => 4, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'قواعد المعطيات 2', 'academic_year_id' => 4, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'نظم التشغيل 1', 'academic_year_id' => 4, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'المترجمات', 'academic_year_id' => 4, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'خوارزميات البحث الذكية', 'academic_year_id' => 4, 'specialization' => Specialization::Software_Engineering],
            // /// فصل 2
            ['name' => 'مشروع مترجمات', 'academic_year_id' => 4, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'مشروع 2', 'academic_year_id' => 4, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'نظم وسائط متعددة وفائقة', 'academic_year_id' => 4, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'البرمجة التفرعية', 'academic_year_id' => 4, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'هندسة البرمجيات 2', 'academic_year_id' => 4, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'تسويق', 'academic_year_id' => 4, 'specialization' => Specialization::Software_Engineering],

            // السنة الرابعة - ذكاء اصطناعي
            ['name' => 'هندسة البرمجيات 1', 'academic_year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'الاقتصاد والإدارة في المؤسسة', 'academic_year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'المترجمات', 'academic_year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'نظم التشغيل 1', 'academic_year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'الشبكات العصبونية', 'academic_year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'خوارزميات البحث الذكية', 'academic_year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],
            // /// فصل 2
            ['name' => 'مشروع 2', 'academic_year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'الحائق الأفتراضية', 'academic_year_id' => 4, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'نظم وسائط متعددة وفائقة', 'academic_year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'البرمجة التفرعية', 'academic_year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'نظم قواعد المعرفة', 'academic_year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'تسويق', 'academic_year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],

            // السنة الرابعة - شبكات
            ['name' => 'هندسة البرمجيات 1', 'academic_year_id' => 4, 'specialization' => Specialization::Networks],
            ['name' => 'الاقتصاد والإدارة في المؤسسة', 'academic_year_id' => 4, 'specialization' => Specialization::Networks],
            ['name' => 'نظم التشغيل 1', 'academic_year_id' => 4, 'specialization' => Specialization::Networks],
            ['name' => 'برمجة التطبيقات الشبكية', 'academic_year_id' => 4, 'specialization' => Specialization::Networks],
            ['name' => 'خوارزميات البحث الذكية', 'academic_year_id' => 4, 'specialization' => Specialization::Networks],
            // /// فصل 2
            ['name' => 'مشروع 2', 'academic_year_id' => 4, 'specialization' => Specialization::Networks],
            ['name' => 'بروتوكولات الاتصال الحاسوبية', 'academic_year_id' => 4, 'specialization' => Specialization::Networks],
            ['name' => 'نظم وسائط متعددة وفائقة', 'academic_year_id' => 4, 'specialization' => Specialization::Networks],
            ['name' => 'البرمجة التفرعية', 'academic_year_id' => 4, 'specialization' => Specialization::Networks],
            ['name' => 'نظم تشغيل 2', 'academic_year_id' => 4, 'specialization' => Specialization::Networks],
            ['name' => 'تسويق', 'academic_year_id' => 4, 'specialization' => Specialization::Networks],

            // السنة الخامسة - برمجيات
            ['name' => 'مشروع تخرج', 'academic_year_id' => 5, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'هندسة برمجيات 3', 'academic_year_id' => 5, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'قواعد معطيات متقدمة', 'academic_year_id' => 5, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'إدارة المشاريع', 'academic_year_id' => 5, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'تطبيقات الإنترنت', 'academic_year_id' => 5, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'أمن نظم المعلومات', 'academic_year_id' => 5, 'specialization' => Specialization::Software_Engineering],
            // //  فصل 2
            ['name' => 'النظم والتطبيقات الموزعة', 'academic_year_id' => 5, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'نظم البحث عن المعلومات', 'academic_year_id' => 5, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'هندسة نظم المعلومات', 'academic_year_id' => 5, 'specialization' => Specialization::Software_Engineering],

            // السنة الخامسة - ذكاء اصطناعي
            ['name' => 'مشروع تخرج', 'academic_year_id' => 5, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'الروبوتية', 'academic_year_id' => 5, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'الرؤية الحاسوبية', 'academic_year_id' => 5, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'إدارة المشاريع', 'academic_year_id' => 5, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'معالجة اللغات الطبيعية', 'academic_year_id' => 5, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'أمن نظم المعلومات', 'academic_year_id' => 5, 'specialization' => Specialization::Artificial_Intelligence],
            // /// فصل
            ['name' => 'المنطق الترجيحي والخوارزميات الوراثية', 'academic_year_id' => 5, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'استكشاف المعرفة', 'academic_year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'التعلم التلقائي', 'academic_year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],

            // السنة الخامسة - شبكات
            ['name' => 'مشروع تخرج', 'academic_year_id' => 5, 'specialization' => Specialization::Networks],
            ['name' => 'نظم التطبيقات الموزعة', 'academic_year_id' => 5, 'specialization' => Specialization::Networks],
            ['name' => 'إدارة الشبكات الحاسوبية', 'academic_year_id' => 5, 'specialization' => Specialization::Networks],
            ['name' => 'إدارة المشاريع', 'academic_year_id' => 5, 'specialization' => Specialization::Networks],
            ['name' => 'تصميم الشبكات الحاسوبية', 'academic_year_id' => 5, 'specialization' => Specialization::Networks],
            ['name' => 'أمن نظم المعلومات', 'academic_year_id' => 5, 'specialization' => Specialization::Networks],
            // /// فصل 2
            ['name' => 'أمن الشبكات الحاسوبية', 'academic_year_id' => 5, 'specialization' => Specialization::Networks],
            ['name' => 'نمذجة ومحاكاة النظم الشبكية', 'academic_year_id' => 5, 'specialization' => Specialization::Networks],
            ['name' => 'نظم الزمن الحقيقي', 'academic_year_id' => 5, 'specialization' => Specialization::Networks],

        ];

        DB::table('subjects')->insert($subjects);
    }
}
