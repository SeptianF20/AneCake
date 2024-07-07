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
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('order_id');
            $table->string('transaction_status');
            $table->date('tanggal');
            $table->decimal('gross_amount', 10, 2);
            $table->string('payment_type');
            $table->dateTime('transaction_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemesanan');
    }
};
