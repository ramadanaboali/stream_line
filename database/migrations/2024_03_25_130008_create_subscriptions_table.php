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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('period',['unknown','days','month','quarter','half_year','year'])->default('unknown');
            $table->enum('subscription_type',["subscribe","commission","subscribe_and_commission"])->default("subscribe");
            $table->integer('days')->nullable();
            $table->float('price')->default(0);
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('payment_date')->nullable();
            $table->float('commission')->default(0);
            $table->integer('sms_messages')->default(0);
            $table->integer('whatsapp_messages')->default(0);
            $table->enum('auto_renew', [0,1])->default(1);
            $table->enum('status',['pending','wait_payment','cancelled','finished','expanded','renewed','suspended','active'])->default('pending');
            $table->enum('is_active', [0,1])->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
