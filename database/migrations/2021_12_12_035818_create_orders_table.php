<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
             $table->string('order_id')->unique();
            $table->bigInteger('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('users');
            $table->enum('status', ['Pending', 'Processing', 'Shipped','Deliveried', 'Cancel'])->default('Pending');
            $table->decimal('sub_total', 20, 6);
            $table->decimal('grand_total', 20, 6);
            $table->string('payment_method')->nullable();
            $table->text('products');
            $table->string('name');
            $table->string('phone_number');
            $table->string('email');
            $table->text('shipping_address');
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
        Schema::dropIfExists('orders');
    }
}
