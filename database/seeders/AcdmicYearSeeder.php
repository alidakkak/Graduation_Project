<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcdmicYearSeeder extends Seeder
{
    public function run(): void
    {
        $academic_years = [
            ['year_name' => '1'],
            ['year_name' => '2'],
            ['year_name' => '3'],
            ['year_name' => '4'],
            ['year_name' => '5'],

        ];

        DB::table('academic_years')->insert($academic_years);
    }
}
