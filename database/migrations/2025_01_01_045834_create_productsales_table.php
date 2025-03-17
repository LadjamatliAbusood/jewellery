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
        Schema::create('productsales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_id');
            $table->string('account');
            $table->string('productcode');
            $table->string('productname');
            $table->decimal('cost');
            $table->decimal('price');
            $table->integer('qty');
            $table->decimal('grams');
            $table->decimal('total_cost');
            $table->decimal('net_sale');
            $table->foreign('sales_id')->references('id')->on('sales')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productsales');
    }
};
