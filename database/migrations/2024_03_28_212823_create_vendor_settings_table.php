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
        Schema::create('vendor_settings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('stock_alert')->default(1);
            $table->tinyInteger('calender_differance')->default(10);
            $table->enum('calender_differance_type',['fixed','vary'])->default('fixed');
            $table->tinyInteger('booking_differance')->default(1);
            $table->enum('booking_range',['one_month','two_month','three_month','four_month','five_month','six_month','seven_month','eight_month','nine_month','ten_month','eleven_month','twelve_month'])->default('one_month');
            $table->tinyInteger('cancel_booking')->default(1);
            $table->tinyInteger('reschedule_booking')->default(1);
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->enum('is_system',[0,1])->default(0);
            $table->enum('is_active',[0,1])->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_settings');
    }
};
