<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_id', 'product_id', 'quantity', 'total_price'];

    // ارتباط با فاکتور (هر فروش مربوط به یک فاکتور است)
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    // ارتباط با محصول
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

