<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'purchase_price', 'sale_price', 'stock_quantity', 'purchase_unit', 'unit_per_purchase'];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function purchase($quantity, $totalPrice)
    {
        $this->stock_quantity += $quantity * $this->unit_per_purchase;
        $this->save();

        return Purchase::create([
            'product_id' => $this->id,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
        ]);
    }

    public function sell($quantity)
    {
        if ($this->stock_quantity < $quantity) {
            throw new \Exception("موجودی کافی نیست.");
        }

        $this->stock_quantity -= $quantity;
        $this->save();

        return Sale::create([
            'product_id' => $this->id,
            'quantity' => $quantity,
            'total_price' => $quantity * $this->sale_price,
        ]);
    }
}
