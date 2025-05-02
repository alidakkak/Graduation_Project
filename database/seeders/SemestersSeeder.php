<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemestersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $semesters = [
            [
                'academic_year_id' => 1,
                'semester' => '1',
            ],
            [
                'academic_year_id' => 1,
                'semester' => '2',
            ],
        ];

        DB::table('semesters')->insert($semesters);
    }
}
