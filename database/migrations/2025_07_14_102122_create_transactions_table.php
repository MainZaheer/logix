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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shipping_id');
            $table->foreign('shipping_id')->references('id')->on('shippings')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('business_id');
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('account_id')->nullable(); // Nullable for transactions not linked to an account
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->string('transaction_reference')->unique()->nullable();
            $table->string('model_type')->nullable(); // e.g., 'invoice', 'expense', 'refund'
            $table->unsignedBigInteger('model_id')->nullable(); // ID of the related model
            $table->string('payment_method')->nullable(); // e.g., 'cash', 'bank_transfer', 'credit_card'
            $table->enum('payment_type', ['credit', 'debit' , 'opening_balance'])->comment('1.Payable (Debit) 2.Receivable (Credit) 3. opening_balance'); // e.g., 'credit', 'debit'
            $table->string('payment_status')->nullable(); // e.g., 'Due', 'Paid', 'Partial'
            $table->string('description')->nullable();
            $table->timestamp('transaction_date')->useCurrent();
            $table->decimal('amount', 15, 2)->default(0.00);;
            $table->timestamps();

            $table->index(['business_id', 'user_id' , 'account_id' , 'shipping_id'], 'idx_business_user_account_shipping'); // Index for faster queries
            $table->index(['model_type', 'model_id'], 'idx_model_type_id'); // Index for model type and ID
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
