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
        Schema::table('activities', function (Blueprint $table) {
            $table->integer('status_code')->nullable()->after('method'); // 200, 404, 500
            $table->string('level')->default('info')->after('status_code'); // info, warning, error
            $table->text('error_message')->nullable()->after('level'); // Ýalňyşlyk habary
            $table->json('payload')->nullable()->after('error_message'); // Formadan gelen maglumatlar
            $table->string('referer')->nullable()->after('url'); // Nireden geldi?
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn(['status_code', 'level', 'error_message', 'payload', 'referer']);
        });
    }
};
