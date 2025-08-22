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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('orderId');
            $table->string('reference')->unique();
            $table->foreignId('delivery_id')->nullable()->constrained('deliveries','deliveryId');
            $table->foreignId('customer_id')->constrained('customers','customer_id');
            $table->string('order_status')->default(\App\Enums\OrderStatusEnum::UNPAID->value);
            $table->foreignId('status_id')->constrained('statuses');
            $table->string('payment_method')->nullable(); // use PaymentMethod enum values
            $table->foreignId('discount_id')->nullable()->constrained('discounts','discount_id');
            $table->integer('total_product')->default(0);
            $table->decimal('price_total', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('cash_paid', 12, 2)->default(0);
            $table->string('label_url')->nullable();
            $table->timestamps();
        });
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders','orderId')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products','productId');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 12, 2);
            $table->unsignedTinyInteger('discount_percent')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
