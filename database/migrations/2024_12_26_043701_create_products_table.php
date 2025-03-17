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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
            $table->string('gold_type');
            $table->string('productcode');
            $table->string('productname');
            $table->double('quantity');
            $table->double('cost_per_gram');
            $table->double('price_per_gram');
            $table->double('grams');
            $table->double('cost');
            $table->double('price');

            // Foreign key for supplier
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');

            // Foreign key for gold_type
             $table->foreign('gold_type')->references('id')->on('gold')->onDelete('cascade');
           
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
