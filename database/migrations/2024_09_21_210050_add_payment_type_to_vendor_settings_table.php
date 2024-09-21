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
        Schema::table('vendor_settings', function (Blueprint $table) {
            $table->enum('accept_payment',['cash','online','both'])->default('both');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendor_settings', function (Blueprint $table) {
            $table->dropColumn('accept_payment');
        });
    }
};
