<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;
use App\Models\Conversation;
use App\Models\Subject;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $studentsData = [
            [
                'first_name' => 'Ali',
                'last_name' => 'Ahmed',
                'father_name' => 'Hassan',
                'university_number' => '12341234',
                'image' => '/students_image/ali.jpg',
                'password' => Hash::make('12345678'),
                'verified' => true,
                'academic_year'=>5,
                'specialization'=>1,
                'is_registration_complete' => true,
            ],
            [
                'first_name' => 'Sara',
                'last_name' => 'Mohamed',
                'father_name' => 'Omar',
                'university_number' => '1234512345',
                'image' => '/students_image/sara.jpg',
                'password' => Hash::make('12345678'),
                'verified' => false,
                'is_registration_complete' => true,
                'academic_year'=>4,
                'specialization'=>2,
            ],
            [
                'first_name' => 'amer',
                'last_name' => 'Mohamed',
                'father_name' => 'Omar',
                'university_number' => '123456123456',
                'image' => '/students_image/sara.jpg',
                'password' => Hash::make('12345678'),
                'verified' => true,
                'is_registration_complete' => true,
                'academic_year'=>3,
                'specialization'=>4,
            ],
            [
                'first_name' => 'ahmad',
                'last_name' => 'Mohamed',
                'father_name' => 'Omar',
                'university_number' => '1234567',
                'image' => '/students_image/sara.jpg',
                'password' => Hash::make('12345678'),
                'verified' => true,
                'is_registration_complete' => true,
                'academic_year'=>2,
                'specialization'=>4,
            ],
            [
                'first_name' => 'yaser',
                'last_name' => 'Mohamed',
                'father_name' => 'Omar',
                'university_number' => '12345678',
                'image' => '/students_image/sara.jpg',
                'password' => Hash::make('12345678'),
                'verified' => true,
                'is_registration_complete' => true,
                'academic_year'=>1,
                'specialization'=>4,
            ],
        ];

        foreach ($studentsData as $data) {
            // إنشاء الطالب
            $student = Student::create($data);

            // جلب جميع المواد الخاصة بالسنة الدراسية والتخصص
            $subjects = Subject::where('year_id', $data['academic_year'])
                ->where('specialization', $data['specialization'])
                ->pluck('id')
                ->toArray();

            // ربط الطالب بالمواد
            $student->subjects()->sync($subjects);

            // جلب كل الـ conversations الخاصة بالمواد أو السنة أو التخصص
            $conversationIds = Conversation::whereIn('subject_id', $subjects)
                ->orWhere('year_id', $data['academic_year'])
                ->orWhere('specialization', $data['specialization'])
                ->pluck('id')
                ->toArray();

            // ربط الطالب بالـ conversations بدون حذف أي روابط مستقبلية
            $student->conversations()->syncWithoutDetaching($conversationIds);
        }
    }
}
