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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->enum('academic_year', [AcademicYear::First_Year, AcademicYear::Second_Year, AcademicYear::Third_Year
                , AcademicYear::Fourth_Year, AcademicYear::Fifth_Year, AcademicYear::General]);
            $table->enum('specialization', [Specialization::Software_Engineering, Specialization::Artificial_Intelligence
                , Specialization::Networks, Specialization::General]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_announcements');
    }
};
