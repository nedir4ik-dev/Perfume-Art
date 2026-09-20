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
        Schema::table('advertisements', function (Blueprint $table) {
            $table->string('badge_tm')->nullable();
            $table->string('badge_ru')->nullable();
            $table->string('badge_en')->nullable();

            $table->string('title_tm')->nullable();
            $table->string('title_ru')->nullable();
            $table->string('title_en')->nullable();

            $table->text('description_tm')->nullable();
            $table->text('description_ru')->nullable();
            $table->text('description_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            //
        });
    }
};
