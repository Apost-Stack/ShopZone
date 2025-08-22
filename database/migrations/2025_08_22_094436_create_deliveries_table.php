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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id('deliveryId');
            $table->string('name');
            $table->foreignId('province_id')->constrained('provinces');
            $table->text('address')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->text('description')->nullable();
            $table->decimal('cost', 10, 2)->default(0);
            $table->foreignId('status_id')->constrained('statuses');
            $table->foreignId('employee_id')->nullable()->constrained('employees','employeeId');
            $table->foreignId('discount_id')->nullable()->constrained('discounts','discount_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
