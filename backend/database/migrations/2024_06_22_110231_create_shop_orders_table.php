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
        Schema::create('shop_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->date('order_date');
            $table->foreignId('payment_method_id')->constrained('user_payment_methods');
            $table->foreignId('shipping_address')->constrained('addresses');
            $table->foreignId('shipping_method')->constrained('shipping_methods');
            $table->unsignedBigInteger('order_total');
            $table->foreignId('order_status')->constrained('order_statuses');
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
        Schema::dropIfExists('shop_orders');
    }
};
