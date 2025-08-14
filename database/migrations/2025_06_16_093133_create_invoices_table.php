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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('shipment_id');
            $table->foreign('shipment_id')->references('id')->on('shippings')->onDelete('cascade');

            $table->unsignedBigInteger('business_id');
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');

            $table->unsignedBigInteger('fuel_id')->nullable();
            $table->foreign('fuel_id')->references('id')->on('fuels')->onDelete('cascade');

            $table->index(['business_id', 'fuel_id' , 'shipment_id']);

            $table->date('invoice_date');
            $table->decimal('invoice_amount', 10, 2)->default(0);
            $table->decimal('fuel_amount_percentage', 10, 2)->default(0);
            $table->decimal('fuel_amount_after_percentage', 10, 2)->default(0);

            $table->decimal('tax_amount_percentage', 10, 2)->default(0);
            $table->decimal('tax_amount_after_percentage', 10, 2)->default(0);

            $table->decimal('final_amount', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
