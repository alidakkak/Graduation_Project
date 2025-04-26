<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('students')->insert([
            [
                'first_name' => 'Ali',
                'last_name' => 'Ahmed',
                'father_name' => 'Hassan',
                'university_number' => 'U2025001',
                'image' => 'images/students/ali.jpg',
                'password' => Hash::make('password123'),
                'verified' => true,
                'is_registration_complete' => true,
            ],
            [
                'first_name' => 'Sara',
                'last_name' => 'Mohamed',
                'father_name' => 'Omar',
                'university_number' => 'U2025002',
                'image' => 'images/students/sara.jpg',
                'password' => Hash::make('password123'),
                'verified' => false,
                'is_registration_complete' => false,
            ],
        ]);
    }
}
