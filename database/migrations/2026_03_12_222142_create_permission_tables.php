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
        // Roles tablisasy (admin, moderator, etc.)
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // admin, moderator
            $table->string('label')->nullable(); // Adminstrator, Redaktor
            $table->timestamps();
        });

        // Rugsatlar tablisasy (create-product, delete-user, etc.)
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label')->nullable();
            $table->timestamps();
        });

        // Haýsy role haýsy rugsat degişli (Many-to-Many)
        Schema::create('permission_role', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->primary(['role_id', 'permission_id']);
        });

        // Ulanyja role birikdirmek
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_tables');
    }
};
