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
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->integer('branches')->default(1);
            $table->integer('employee')->default(1);
            $table->integer('customers')->default(1);
            $table->enum('payments',["cash","percentage"])->default("cash");
            $table->enum('remove_copy_right',[0,1])->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('branches');
            $table->dropColumn('employees');
            $table->dropColumn('customers');
            $table->dropColumn('payments');
            $table->dropColumn('remove_copy_right');
        });
    }
};
