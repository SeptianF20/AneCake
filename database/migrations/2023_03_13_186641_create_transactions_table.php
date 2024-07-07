<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('invoice')->unique()->nullable();
            $table->uuid('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->uuid('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('payment_method')->nullable();
            $table->double('total_price', 8, 2)->nullable();
            $table->double('total_discount', 8, 2)->nullable();
            $table->double('grand_total', 8, 2)->nullable();
            $table->string('snap_token')->nullable();
            $table->string('receipt_number')->nullable();
            $table->string('status')->nullable()->default('Menunggu Pembayaran');
            $table->string('payment_status')->nullable()->default('Belum Lunas');
            $table->double('paid', 8, 2)->nullable();
            $table->double('change', 8, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
