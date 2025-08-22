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
        Schema::create('products', function (Blueprint $table) {
            $table->id('productId');
            $table->string('name');
            $table->integer('quantity')->default(0);
            $table->foreignId('category_id')->constrained('categories','categoryId');
            $table->decimal('price', 12, 2);
            $table->foreignId('discount_id')->nullable()->constrained('discounts','discount_id');
            $table->timestamp('available_at')->nullable();
            $table->foreignId('status_id')->constrained('statuses');
            $table->string('slug')->unique();
            $table->decimal('weight', 10, 3)->nullable();
            $table->decimal('height', 10, 3)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
