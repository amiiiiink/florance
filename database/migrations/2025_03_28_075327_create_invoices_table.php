<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_price', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('final_price', 15, 2)->default(0); // مقدار پیش‌فرض ۰
            $table->timestamps();
        });

    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
