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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->text('description_ar');
            $table->text('description_en')->nullable();
            $table->enum('period',['unknown','days','month','quarter','half_year','year'])->default('unknown');
            $table->integer('days')->nullable();
            $table->float('unknown_price')->default(0);
            $table->float('days_price')->default(0);
            $table->float('month_price')->default(0);
            $table->float('quarter_price')->default(0);
            $table->float('half_year_price')->default(0);
            $table->float('year_price')->default(0);
            $table->enum('type',["public","private"])->default("public");
            $table->unsignedBigInteger('manager_role_id')->nullable();
            $table->enum('subscription_type',["subscribe","commission","subscribe_and_commission"])->default("subscribe");
            $table->float('commission')->default(0);
            $table->text('features')->nullable();
            $table->integer('sms_messages')->default(0);
            $table->integer('whatsapp_messages')->default(0);
            $table->enum('is_default',[0,1])->default(1);
            $table->text('policy')->nullable();
            $table->enum('is_active',[0,1])->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
