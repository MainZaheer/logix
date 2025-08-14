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
        Schema::create('opening_balance_histories', function (Blueprint $table) {
          $table->id();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('business_id');
            $table->decimal('old_balance', 15, 2);
            $table->decimal('new_balance', 15, 2);
            $table->decimal('difference', 15, 2);
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

             $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
             $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');

              $table->index(['business_id', 'updated_by' , 'account_id'], 'idx_business_user_account');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opening_balance_histories');
    }
};
