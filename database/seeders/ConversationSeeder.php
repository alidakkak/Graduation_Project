<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConversationSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = Subject::all();
        $conversations = [];
        foreach ($subjects as $index => $subject) {
            $conversations[$index] = [
                'label' => $subject->name,
                'subject_id' => $subject->id,

            ];

        }

        DB::table('conversations')->insert($conversations);

    }
}
