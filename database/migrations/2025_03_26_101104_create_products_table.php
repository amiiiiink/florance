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
            $table->id();
            $table->string('name');
            $table->integer('purchase_price')->nullable(); // قیمت خرید
            $table->integer('sale_price'); // قیمت فروش واحد کوچک
            $table->integer('stock_quantity')->default(0); // موجودی به صورت دانه‌ای
            $table->enum('purchase_unit', ['carton', 'package', 'single','box'])->default('single'); // واحد خرید
            $table->integer('unit_per_purchase')->default(1); // تعداد دانه در هر واحد خرید
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
