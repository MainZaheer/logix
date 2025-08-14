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
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('job_no')->uniqid();
            $table->enum('import_export', ['import', 'export']);
            $table->string('bill_no')->nullable();
            $table->string('lc_no')->nullable();
            $table->string('shipping_line')->nullable();
            $table->integer('container_number')->nullable();
            $table->unsignedBigInteger('gate_pass_id');
            $table->foreign('gate_pass_id')->references('id')->on('gate_passes')->onDelete('cascade');



            $table->unsignedBigInteger('clearing_agent_id');
            $table->foreign('clearing_agent_id')->references('id')->on('clearing_agents')->onDelete('cascade');

            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');


            $table->decimal('total_invoice_amount', 22, 2);
            $table->decimal('total_to_pay_amount', 22, 2);
            $table->decimal('total_expence_amount', 22, 2);

            $table->enum('payment', ['cash', 'credit'])->comment('"TOPAY" MEANS CASH , "PAID" MEANS CREDIT');

            $table->unsignedBigInteger('business_id');
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
             $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->index(['business_id', 'user_id', 'gate_pass_id' , 'clearing_agent_id'] , 'shipping_composite_index');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
