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
        Schema::create('offers', function (Blueprint $table) {
                $table->id();
                $table->string('name_ar');
                $table->string('name_en')->nullable();
                $table->longText('description_en')->nullable();
                $table->longText('description_ar')->nullable();
                $table->unsignedBigInteger('vendor_id')->nullable();
                $table->unsignedBigInteger('section_id');
                $table->unsignedBigInteger('category_id');
                $table->unsignedBigInteger('sub_category_id')->nullable();
                $table->decimal('service_price',10,2)->nullable();
                $table->enum('price_type', ['service','free','special','discount'])->default('service');
                $table->decimal('discount_percentage')->nullable();
                $table->decimal('offer_price')->nullable();
                $table->enum('is_active', [0,1])->default(1);
                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->softDeletes();
                $table->timestamps();
                $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
                $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
                $table->foreign('category_id')->references('id')->on('service_categories')->onDelete('cascade');
                $table->foreign('sub_category_id')->references('id')->on('service_categories')->onDelete('cascade');
                $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
