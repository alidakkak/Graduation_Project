<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->unsignedBigInteger('last_message_id')->nullable()->after('id');

            $table->foreign('last_message_id')
                ->references('id')
                ->on('messages')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropForeign(['last_message_id']);
            $table->dropColumn('last_message_id');
        });
    }
};
