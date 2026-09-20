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
        Schema::create('tickers', function (Blueprint $table) {
            $table->id();
            $table->string('content'); // Mahabat teksti
            $table->string('icon')->default('bi-stars'); // Bootstrap icon ady
            $table->string('color')->default('text-warning'); // Reňk klasy
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0); // Görkeziliş tertibi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickers');
    }
};
