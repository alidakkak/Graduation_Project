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
            ['name' => 'الجبر العام', 'year_id' => 1, 'specialization' => Specialization::General],
            ['name' => 'تحليل 1', 'year_id' => 1, 'specialization' => Specialization::General],
            ['name' => 'اللغة الإنكليزية 1', 'year_id' => 1, 'specialization' => Specialization::General],
            ['name' => 'مبادئ عمل الحاسب', 'year_id' => 1, 'specialization' => Specialization::General],
            ['name' => 'الفيزياء', 'year_id' => 1, 'specialization' => Specialization::General],
            ['name' => 'برمجة 1', 'year_id' => 1, 'specialization' => Specialization::General],
            // // فصل 2
            ['name' => 'الدارات الكهربائية والألكترونية', 'year_id' => 1, 'specialization' => Specialization::General],
            ['name' => 'تحليل 2', 'year_id' => 1, 'specialization' => Specialization::General],
            ['name' => 'اللغة العربية', 'year_id' => 1, 'specialization' => Specialization::General],
            ['name' => 'الجبر الخطي', 'year_id' => 1, 'specialization' => Specialization::General],
            ['name' => 'اللغة الإنكليزية 2', 'year_id' => 1, 'specialization' => Specialization::General],
            ['name' => 'الثقافة القومية الاشتراكية', 'year_id' => 1, 'specialization' => Specialization::General],
            ['name' => 'برمجة 2', 'year_id' => 2, 'specialization' => Specialization::General],

            // السنة الثانية
            ['name' => 'تحليل 3', 'year_id' => 2, 'specialization' => Specialization::General],
            ['name' => 'الخوارزميات وبنى المعطيات 1', 'year_id' => 3, 'specialization' => Specialization::General],
            ['name' => 'برمجة 3', 'year_id' => 2, 'specialization' => Specialization::General],
            ['name' => 'اللغة الإنكليزية 3', 'year_id' => 2, 'specialization' => Specialization::General],
            ['name' => 'الدارات المنطقية', 'year_id' => 2, 'specialization' => Specialization::General],
            ['name' => 'الاحتمالات والإحصاء', 'year_id' => 2, 'specialization' => Specialization::General],
            // // فصل 2
            ['name' => 'الاتصالات الرقمية ونظرية المعلومات', 'year_id' => 2, 'specialization' => Specialization::General],
            ['name' => 'مهارات تواصل', 'year_id' => 2, 'specialization' => Specialization::General],
            ['name' => 'بنيان الحواسيب 1', 'year_id' => 2, 'specialization' => Specialization::General],
            ['name' => 'التحليل العددي', 'year_id' => 2, 'specialization' => Specialization::General],
            ['name' => 'اللغة الإنكليزية 4', 'year_id' => 2, 'specialization' => Specialization::General],
            ['name' => 'الخوارزميات وبنى المعطيات 2', 'year_id' => 2, 'specialization' => Specialization::General],

            // السنة الثالثة
            ['name' => 'بحوث عمليات', 'year_id' => 3, 'specialization' => Specialization::General],
            ['name' => 'بيانيات حاسوبية', 'year_id' => 3, 'specialization' => Specialization::General],
            ['name' => 'بنيان الحواسيب 2', 'year_id' => 3, 'specialization' => Specialization::General],
            ['name' => 'أساسيات الشبكات الحاسوبية', 'year_id' => 3, 'specialization' => Specialization::General],
            ['name' => 'لغات البرمجة', 'year_id' => 3, 'specialization' => Specialization::General],
            // /// فصل 2
            ['name' => 'مشروع 1', 'year_id' => 3, 'specialization' => Specialization::General],
            ['name' => 'مبادئ الذكاء الصنعي', 'year_id' => 3, 'specialization' => Specialization::General],
            ['name' => 'حسابات علمية', 'year_id' => 3, 'specialization' => Specialization::General],
            ['name' => 'اللغات الصورية', 'year_id' => 3, 'specialization' => Specialization::General],
            ['name' => 'قواعد المعطيات 1', 'year_id' => 3, 'specialization' => Specialization::General],

            // السنة الرابعة - برمجيات
            ['name' => 'هندسة البرمجيات 1', 'year_id' => 4, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'الاقتصاد والإدارة في المؤسسة', 'year_id' => 4, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'قواعد المعطيات 2', 'year_id' => 4, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'نظم التشغيل 1', 'year_id' => 4, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'المترجمات', 'year_id' => 4, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'خوارزميات البحث الذكية', 'year_id' => 4, 'specialization' => Specialization::Software_Engineering],
            // /// فصل 2
            ['name' => 'مشروع مترجمات', 'year_id' => 4, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'مشروع 2', 'year_id' => 4, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'نظم وسائط متعددة وفائقة', 'year_id' => 4, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'البرمجة التفرعية', 'year_id' => 4, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'هندسة البرمجيات 2', 'year_id' => 4, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'تسويق', 'year_id' => 4, 'specialization' => Specialization::Software_Engineering],

            // السنة الرابعة - ذكاء اصطناعي
            ['name' => 'هندسة البرمجيات 1', 'year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'الاقتصاد والإدارة في المؤسسة', 'year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'المترجمات', 'year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'نظم التشغيل 1', 'year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'الشبكات العصبونية', 'year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'خوارزميات البحث الذكية', 'year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],
            // /// فصل 2
            ['name' => 'مشروع 2', 'year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'الحائق الأفتراضية', 'year_id' => 4, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'نظم وسائط متعددة وفائقة', 'year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'البرمجة التفرعية', 'year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'نظم قواعد المعرفة', 'year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'تسويق', 'year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],

            // السنة الرابعة - شبكات
            ['name' => 'هندسة البرمجيات 1', 'year_id' => 4, 'specialization' => Specialization::Networks],
            ['name' => 'الاقتصاد والإدارة في المؤسسة', 'year_id' => 4, 'specialization' => Specialization::Networks],
            ['name' => 'نظم التشغيل 1', 'year_id' => 4, 'specialization' => Specialization::Networks],
            ['name' => 'برمجة التطبيقات الشبكية', 'year_id' => 4, 'specialization' => Specialization::Networks],
            ['name' => 'خوارزميات البحث الذكية', 'year_id' => 4, 'specialization' => Specialization::Networks],
            // /// فصل 2
            ['name' => 'مشروع 2', 'year_id' => 4, 'specialization' => Specialization::Networks],
            ['name' => 'بروتوكولات الاتصال الحاسوبية', 'year_id' => 4, 'specialization' => Specialization::Networks],
            ['name' => 'نظم وسائط متعددة وفائقة', 'year_id' => 4, 'specialization' => Specialization::Networks],
            ['name' => 'البرمجة التفرعية', 'year_id' => 4, 'specialization' => Specialization::Networks],
            ['name' => 'نظم تشغيل 2', 'year_id' => 4, 'specialization' => Specialization::Networks],
            ['name' => 'تسويق', 'year_id' => 4, 'specialization' => Specialization::Networks],

            // السنة الخامسة - برمجيات
            ['name' => 'مشروع تخرج', 'year_id' => 5, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'هندسة برمجيات 3', 'year_id' => 5, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'قواعد معطيات متقدمة', 'year_id' => 5, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'إدارة المشاريع', 'year_id' => 5, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'تطبيقات الإنترنت', 'year_id' => 5, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'أمن نظم المعلومات', 'year_id' => 5, 'specialization' => Specialization::Software_Engineering],
            // //  فصل 2
            ['name' => 'النظم والتطبيقات الموزعة', 'year_id' => 5, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'نظم البحث عن المعلومات', 'year_id' => 5, 'specialization' => Specialization::Software_Engineering],
            ['name' => 'هندسة نظم المعلومات', 'year_id' => 5, 'specialization' => Specialization::Software_Engineering],

            // السنة الخامسة - ذكاء اصطناعي
            ['name' => 'مشروع تخرج', 'year_id' => 5, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'الروبوتية', 'year_id' => 5, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'الرؤية الحاسوبية', 'year_id' => 5, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'إدارة المشاريع', 'year_id' => 5, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'معالجة اللغات الطبيعية', 'year_id' => 5, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'أمن نظم المعلومات', 'year_id' => 5, 'specialization' => Specialization::Artificial_Intelligence],
            // /// فصل
            ['name' => 'المنطق الترجيحي والخوارزميات الوراثية', 'year_id' => 5, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'استكشاف المعرفة', 'year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],
            ['name' => 'التعلم التلقائي', 'year_id' => 4, 'specialization' => Specialization::Artificial_Intelligence],

            // السنة الخامسة - شبكات
            ['name' => 'مشروع تخرج', 'year_id' => 5, 'specialization' => Specialization::Networks],
            ['name' => 'نظم التطبيقات الموزعة', 'year_id' => 5, 'specialization' => Specialization::Networks],
            ['name' => 'إدارة الشبكات الحاسوبية', 'year_id' => 5, 'specialization' => Specialization::Networks],
            ['name' => 'إدارة المشاريع', 'year_id' => 5, 'specialization' => Specialization::Networks],
            ['name' => 'تصميم الشبكات الحاسوبية', 'year_id' => 5, 'specialization' => Specialization::Networks],
            ['name' => 'أمن نظم المعلومات', 'year_id' => 5, 'specialization' => Specialization::Networks],
            // /// فصل 2
            ['name' => 'أمن الشبكات الحاسوبية', 'year_id' => 5, 'specialization' => Specialization::Networks],
            ['name' => 'نمذجة ومحاكاة النظم الشبكية', 'year_id' => 5, 'specialization' => Specialization::Networks],
            ['name' => 'نظم الزمن الحقيقي', 'year_id' => 5, 'specialization' => Specialization::Networks],

        ];

        DB::table('subjects')->insert($subjects);
    }
}
