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
        Schema::table('orders', function (Blueprint $table) {
            // Müşderini tanamak üçin cookie token
            $table->string('customer_token')->nullable()->index();
            // Statuslary has takyk saklamak üçin (pending, accepted, shipped, completed, cancelled)
            // Eger öň bar bolsa, diňe default we başga sütünleri barlaň
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
