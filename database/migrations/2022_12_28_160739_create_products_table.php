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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->uuid('product_category_id')->nullable();
            $table->foreign('product_category_id')->references('id')->on('product_categories');
            $table->string('name', 150);
            $table->string('slug');
            $table->text('thumbnail')->nullable();
            $table->integer('stock')->nullable()->default(0);
            $table->double('price')->nullable()->default(0);
            $table->double('discount')->nullable()->default(0);
            $table->string('status')->nullable()->default('active');
            $table->boolean('is_active')->nullable()->default(true);
            $table->boolean('is_selected')->nullable()->default(false);
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
        Schema::dropIfExists('products');
    }
};
