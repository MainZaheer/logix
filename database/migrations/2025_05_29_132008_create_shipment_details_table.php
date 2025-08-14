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
        Schema::create('shipment_details', function (Blueprint $table) {
            $table->id();

             $table->unsignedBigInteger('shipment_id');
             $table->foreign('shipment_id')->references('id')->on('shippings')->onDelete('cascade');

            $table->longtext('bilty_container_number')->nullable();
            $table->string('no_of_packges')->nullable();
            $table->string('description')->nullable();
            $table->string('bilty_number')->nullable();

             $table->unsignedBigInteger('sendar_id')->nullable();
             $table->foreign('sendar_id')->references('id')->on('contacts')->onDelete('cascade');

             $table->unsignedBigInteger('recipient_id')->nullable();
             $table->foreign('recipient_id')->references('id')->on('contacts')->onDelete('cascade');


            $table->string('from_location')->nullable();
            $table->string('to_location')->nullable();


            $table->string('vehicle_no')->nullable();
            $table->string('driver_no')->nullable();

             $table->unsignedBigInteger('broker_id')->nullable();
             $table->foreign('broker_id')->references('id')->on('brokers')->onDelete('cascade');

            $table->decimal('booker_vhicle_freight_amount', 10, 2)->default(0);

            $table->string('mt_return_place')->nullable();

            $table->decimal('booker_mt_charges_amount', 10, 2)->default(0);
            $table->decimal('gate_pass_amount', 10, 2)->default(0);

             $table->unsignedBigInteger('lifter_charges_id')->nullable();
             $table->foreign('lifter_charges_id')->references('id')->on('lifter_charges')->onDelete('cascade');
             $table->decimal('lifter_charges_amount', 10, 2)->default(0);



             $table->unsignedBigInteger('labour_charges_id')->nullable();
             $table->foreign('labour_charges_id')->references('id')->on('labour_charges')->onDelete('cascade');
             $table->decimal('labour_charges_amount', 10, 2)->default(0);

             $table->unsignedBigInteger('local_charges_id')->nullable();
             $table->foreign('local_charges_id')->references('id')->on('local_charges')->onDelete('cascade');
            $table->decimal('local_charges_amount', 10, 2)->default(0);

            $table->unsignedBigInteger('party_commission_charges_id')->nullable();
             $table->foreign('party_commission_charges_id')->references('id')->on('party_commission_charges')->onDelete('cascade');
            $table->decimal('party_commision_charges_amount', 10, 2)->default(0);


             $table->unsignedBigInteger('tracker_charges_id')->nullable();
             $table->foreign('tracker_charges_id')->references('id')->on('tracker_charges')->onDelete('cascade');
             $table->decimal('tracker_charges_amount', 10, 2)->default(0);


             $table->unsignedBigInteger('other_charges_id')->nullable();
             $table->foreign('other_charges_id')->references('id')->on('other_charges')->onDelete('cascade');
             $table->decimal('other_charges_amount', 10, 2)->default(0);

            $table->decimal('bilty_expence_amount', 10, 2)->default(0);
            $table->decimal('bilty_invoice_amount', 10, 2)->default(0);
            $table->decimal('bilty_to_pay_amount', 10, 2)->default(0);



             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_details');
    }
};
