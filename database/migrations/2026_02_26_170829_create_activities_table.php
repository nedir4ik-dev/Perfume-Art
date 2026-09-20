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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->nullable(); // Ulanyjynyň IP adresi
            $table->string('user_agent')->nullable();    // Haýsy brauzer we enjam (Windows, iPhone we s.m.)
            $table->string('url')->nullable();           // Haýsy sahypa girdi
            $table->string('method')->nullable();        // GET ýa-da POST
            $table->integer('visit_count')->default(1);  // Şu gün näçe gezek girdi
            $table->timestamp('last_activity')->useCurrent(); // Iň soňky hereket wagty
            $table->integer('duration')->default(0);     // Sahypada sarp eden wagty (sekuntda)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
