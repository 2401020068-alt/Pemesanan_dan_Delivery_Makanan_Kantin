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
        Schema::create('shops', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('owner_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->string('location')->nullable();
            $table->string('hours')->nullable();
            $table->boolean('open')->default(true);
            $table->string('approval')->default('pending'); // pending, approved, rejected
            $table->date('submitted')->nullable();
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('menu_items', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('shop_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category')->default('Makanan');
            $table->integer('price')->default(0);
            $table->text('image')->nullable();
            $table->boolean('available')->default(true);
            $table->timestamps();

            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('trx_id');
            $table->string('buyer_id');
            $table->string('shop_id');
            $table->string('driver_id')->nullable();
            $table->integer('subtotal')->default(0);
            $table->integer('delivery_fee')->default(3000);
            $table->integer('total')->default(0);
            $table->text('address');
            $table->text('note')->nullable();
            $table->string('payment_method')->default('QRIS');
            $table->string('payment_status')->default('unpaid'); // unpaid, pending, verified, rejected
            $table->text('proof')->nullable();
            $table->string('status')->default('created'); // created, paid, processing, ready, delivering, done, cancelled
            $table->string('delivery_status')->default('waiting'); // waiting, picked, onway, done
            $table->timestamps();

            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('menu_id');
            $table->string('name');
            $table->text('image')->nullable();
            $table->integer('price')->default(0);
            $table->integer('qty')->default(1);
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });

        Schema::create('disputes', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('order_id');
            $table->string('buyer_id');
            $table->string('issue');
            $table->text('description');
            $table->text('proof')->nullable();
            $table->string('status')->default('open'); // open, review, resolved, rejected
            $table->text('resolution')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->dateTime('time');
            $table->string('admin');
            $table->string('action');
            $table->string('target');
            $table->string('status')->default('success'); // success, failed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('disputes');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('menu_items');
        Schema::dropIfExists('shops');
    }
};
