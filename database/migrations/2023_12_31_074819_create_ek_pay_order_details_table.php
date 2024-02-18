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
        Schema::create('ek_pay_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->double('tran_amount')->nullable();
            $table->text('tran_data')->nullable();
            $table->string('transactionid')->nullable();
            $table->string('pre_transactionid')->nullable();
            $table->string('val_id')->nullable();
            $table->string('order_number')->nullable();
            $table->double('amount')->nullable();
            $table->float('share')->nullable();
            $table->double('muktopaath')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('card_or_bank_number')->nullable();
            $table->string('bank_info')->nullable();
            $table->string('transaction_number')->nullable();
            $table->string('coupons_id')->nullable();
            $table->boolean('payment_status')->nullable();
            $table->boolean('type')->nullable();
            $table->double('discount')->nullable();
            $table->string('payment_gatway')->nullable();
            $table->boolean('pib_course')->nullable();
            $table->date('order_created_at')->nullable();
            $table->date('order_update_at')->nullable();
            $table->json('ekpay_detail')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ek_pay_order_details');
    }
};







