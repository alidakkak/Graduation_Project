<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicYearsSeeder extends Seeder
{
    public function run(): void
    {
        $academic_years = [
            ['year_name' => 'العام الدراسي ل 2024-2025'],
        ];

        DB::table('academic_years')->insert($academic_years);
    }
}
