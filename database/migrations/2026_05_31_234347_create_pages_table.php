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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');            // Sahypanyň başlygy (Mysal: Biz barada)
            $table->string('slug')->unique();   // URL salgysy (Mysal: about-us)
            $table->string('image')->nullable(); // Sahypa degişli uly surat
            $table->longText('content');        // Sahypanyň içindäki doly tekstler (HTML goldawly)

            // SEO Sazlamalary (Her sahypanyň öz SEO-sy bolar ýaly)
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->boolean('is_active')->default(true); // Sahypa işjeňmi ýa-da ýapyk?
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
