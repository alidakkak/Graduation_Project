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
        Schema::create('academic_years', function (Blueprint $table) {
            $table->id();
<<<<<<<< HEAD:database/migrations/2023_01_12_202607_create_academic_years_table.php
            $table->string('name');
========
            $table->string('year_name');
>>>>>>>> 1c70f34abd4cdedc4baa1d70c18f0d5ca5c30701:database/migrations/2025_04_17_125737_create_academic_years_table.php
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_years');
    }
};
