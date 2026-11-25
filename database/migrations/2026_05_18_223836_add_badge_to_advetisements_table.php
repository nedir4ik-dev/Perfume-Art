<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('advertisements') && !Schema::hasColumn('advertisements', 'badge')) {
            Schema::table('advertisements', function (Blueprint $table) {
                $table->string('badge')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('advertisements') && Schema::hasColumn('advertisements', 'badge')) {
            Schema::table('advertisements', function (Blueprint $table) {
                $table->dropColumn('badge');
            });
        }
    }
};
