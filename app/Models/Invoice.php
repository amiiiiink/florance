<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['total_price', 'discount', 'final_price'];

    // رابطه فاکتور با فروش‌ها (یک فاکتور می‌تواند چندین فروش داشته باشد)
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
