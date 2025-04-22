<?php

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
        Schema::create('work_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semester_id')->constrained('semesters')->cascadeOnDelete();
            $table->integer('academic_level');
            $table->string('specialization')->nullable();
            $table->string('course_name');
            $table->string('instructor_name');
            $table->string('day');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_schedules');
    }
};
