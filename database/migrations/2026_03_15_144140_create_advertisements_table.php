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
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('image');       // Surat ýoly
            $table->string('link')->nullable(); // Basanda nirede gitmeli?
            $table->integer('seconds')->default(15); // Näçe sekunt durmaly?
            $table->boolean('is_active')->default(false); // Açykmy ýa-da ýapyk?
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
