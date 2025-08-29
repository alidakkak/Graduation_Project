<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConversationYearSeeder extends Seeder
{
    public function run(): void
    {
        $years = [
            ['id' => 1, 'name' => 'سنة اولى'],
            ['id' => 2, 'name' => 'سنة ثانية'],
            ['id' => 3, 'name' => 'سنة ثالثة'],
            ['id' => 4, 'name' => 'سنة رابعة'],
            ['id' => 5, 'name' => 'سنة خامسة'],
        ];

        $conversations = [];
        foreach ($years as $index => $year) {
            $conversations[$index] = [
                'label' => $year['name'],
                'year_id' => $year['id'],
            ];
        }

        DB::table('conversations')->insert($conversations);
        $specializations = [
            ['id' => 3, 'name' => 'اختصاص شبكات'],
            ['id' => 1, 'name' => 'اختصاص هندسة برمجيات'],
            ['id' => 2, 'name' => 'اختصاص ذكاء صنعي'],
        ];
        $conversations2 = [];
        foreach ($specializations as $index => $specialization) {
            $specialization[$index] = [
                'label' => $specialization['name'],
                'specialization' => $specialization['id'],
            ];
        }
        DB::table('conversations')->insert($conversations2);

    }
}
