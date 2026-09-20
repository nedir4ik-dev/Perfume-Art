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
        Schema::create('popups', function (Blueprint $table) {
            $table->id();

            $table->string('title_tm')->nullable();
            $table->string('title_ru')->nullable();
            $table->string('title_en')->nullable();

            // 3 Dilli Düşündiriş (Description)
            $table->text('description_tm')->nullable();
            $table->text('description_ru')->nullable();
            $table->text('description_en')->nullable();

            // Beýleki zerur sütünler
            $table->string('image'); // Popup suraty
            $table->string('link')->nullable(); // Basylanda gitjek salgysy
            $table->integer('seconds')->default(5); // Sahypada näçe sekunt durmalygy
            $table->boolean('is_active')->default(true); // Aktiw / Passiw statusy

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('popups');
    }
};
