<?php

use App\Statuses\AcademicYear;
use App\Statuses\Specialization;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name');
            $table->string('university_number')->unique();
            $table->string('image');
            $table->string('profileImage')->default('/students_profile_image/default-user-profile.jpg');
            $table->string('password');
            $table->boolean('verified')->nullable();
            $table->boolean('is_registration_complete')->default(0);
            $table->enum('academic_year', [AcademicYear::First_Year, AcademicYear::Second_Year, AcademicYear::Third_Year, AcademicYear::Fourth_Year, AcademicYear::Fifth_Year]);
            $table->enum('specialization', [Specialization::Software_Engineering, Specialization::Artificial_Intelligence, Specialization::Networks, Specialization::General]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
