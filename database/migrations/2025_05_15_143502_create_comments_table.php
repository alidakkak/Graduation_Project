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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('lost_item_id')->constrained('lost_items')->onDelete('cascade');
            $table->text('comment');
            $table->string('image')->nullable();
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('comments')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('parent_id');
        });
        Schema::dropIfExists('comments');
    }
};
