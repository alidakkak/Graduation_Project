<?php

namespace Database\Seeders;

use App\Statuses\SpecializationStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            ['name' => 'البرمجة الهيكلية', 'academic_year_id' => 1, 'specialization' => SpecializationStatus::GENERAL],
            ['name' => 'البرمجة الكائنية', 'academic_year_id' => 1, 'specialization' => SpecializationStatus::GENERAL],
            ['name' => 'هياكل البيانات', 'academic_year_id' => 2, 'specialization' => SpecializationStatus::GENERAL],
            ['name' => 'تحليل وتصميم الخوارزميات', 'academic_year_id' => 2, 'specialization' => SpecializationStatus::GENERAL],
            ['name' => 'نظم التشغيل', 'academic_year_id' => 3, 'specialization' => SpecializationStatus::GENERAL],
            ['name' => 'قواعد البيانات', 'academic_year_id' => 3, 'specialization' => SpecializationStatus::GENERAL],
            ['name' => 'شبكات الحاسوب', 'academic_year_id' => 1, 'specialization' => SpecializationStatus::GENERAL],
            ['name' => 'الذكاء الصنعي', 'academic_year_id' => 2, 'specialization' => SpecializationStatus::AI],
            ['name' => 'معالجة الصور', 'academic_year_id' => 2, 'specialization' => SpecializationStatus::AI],
            ['name' => 'معالجة اللغات الطبيعية', 'academic_year_id' => 3, 'specialization' => SpecializationStatus::GENERAL],
            ['name' => 'التعلم الآلي', 'academic_year_id' => 3, 'specialization' => SpecializationStatus::GENERAL],
            ['name' => 'رؤية الحاسوب', 'academic_year_id' => 4, 'specialization' => SpecializationStatus::AI],
            ['name' => 'الروبوتات', 'academic_year_id' => 4, 'specialization' => SpecializationStatus::AI],
            ['name' => 'التنقيب عن البيانات', 'academic_year_id' => 4, 'specialization' => SpecializationStatus::AI],
            ['name' => 'أمن المعلومات', 'academic_year_id' => 2, 'specialization' => SpecializationStatus::GENERAL],
            ['name' => 'هندسة البرمجيات', 'academic_year_id' => 3, 'specialization' => SpecializationStatus::GENERAL],
            ['name' => 'تصميم وتحليل النظم', 'academic_year_id' => 3, 'specialization' => SpecializationStatus::GENERAL],
            ['name' => 'الدوائر الكهربائية والإلكترونية', 'academic_year_id' => 1, 'specialization' => SpecializationStatus::GENERAL],
            ['name' => 'التحكم الآلي', 'academic_year_id' => 2, 'specialization' => SpecializationStatus::GENERAL],
            ['name' => 'الرياضيات المتقطعة', 'academic_year_id' => 1, 'specialization' => SpecializationStatus::GENERAL],
            ['name' => 'الاحتمالات والإحصاء', 'academic_year_id' => 2, 'specialization' => SpecializationStatus::GENERAL],
            ['name' => 'المنطق الرقمي', 'academic_year_id' => 1, 'specialization' => SpecializationStatus::GENERAL],
            ['name' => 'الرياضيات الهندسية', 'academic_year_id' => 1, 'specialization' => SpecializationStatus::GENERAL],
            ['name' => 'الفيزياء العامة', 'academic_year_id' => 1, 'specialization' => SpecializationStatus::GENERAL],
        ];

        DB::table('subjects')->insert($subjects);
    }
}
