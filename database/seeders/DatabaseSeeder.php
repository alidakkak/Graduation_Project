<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([StudentSeeder::class, AcademicYearsSeeder::class,
            SemestersSeeder::class, YearsSeeder::class, SubjectSeeder::class, ConversationSeeder::class, WorkScheduleSeeder::class,
            ExamSchedulesSeeder::class,
            AdminSedder::class,
            AnnouncementSeeder::class,
            LostItemsSeeder::class,
            ConversationYearSeeder::class,


        ]);
    }
}
