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
        Schema::table('tickers', function (Blueprint $table) {
            $table->string('content_tm')->nullable()->after('content');
            $table->string('content_ru')->nullable()->after('content_tm');
            $table->string('content_en')->nullable()->after('content_ru');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickers', function (Blueprint $table) {
            $table->dropColumn(['content_tm', 'content_ru', 'content_en']);
        });
    }
};
