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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id'); // Optional for multi-business support
            $table->unsignedBigInteger('user_id');
            $table->string('account_name');
            $table->string('account_number')->unique();
            $table->string('account_type')->nullable(); // e.g., 'savings', 'checking'
            $table->decimal('balance', 15, 2)->default(0.00);
            $table->string('status')->default('active'); // e.g., 'active', 'inactive', 'closed'
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
            $table->string('description')->nullable(); // Optional description for the account
            $table->timestamps();

            $table->index(['business_id', 'user_id'], 'ids_business_user'); // Index for faster queries
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
