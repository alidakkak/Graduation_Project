<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcdmicYearSeeder extends Seeder
{
    public function run(): void
    {
        $academic_years = [
            ['name' => '1'],
            ['name' => '2'],
            ['name' => '3'],
            ['name' => '4'],
            ['name' => '5'],

        ];

        DB::table('academic_years')->insert($academic_years);
    }
}
