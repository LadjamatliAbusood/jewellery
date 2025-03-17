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
        Schema::create('customerstorage', function (Blueprint $table) {
            $table->id();
            $table->string( 'account');
            $table->unsignedBigInteger('layaway_id');
            $table->string('customername');
            $table->decimal('sellingprice');
            $table->decimal('downpayment');
            $table->decimal('balance');
            $table->boolean('status')->default(0);
            $table->timestamps();


             // Foreign key for customer_layaway_info
             $table->foreign('layaway_id')->references('id')->on('customer_layaway_info')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customerstorage');
    }
};
