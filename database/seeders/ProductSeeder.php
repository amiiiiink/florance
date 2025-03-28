<?php


namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['name' => 'رانی', 'purchase_price' => 8000, 'sale_price' => 10000, 'purchase_unit' => 'carton', 'unit_per_purchase' => 12],
            ['name' => 'سیگار وبنستون الترا لایت', 'purchase_price' => 5000, 'sale_price' => 7000, 'purchase_unit' => 'box', 'unit_per_purchase' => 20],
            ['name' => 'دستمال کاغذی', 'purchase_price' => 1500, 'sale_price' => 2500, 'purchase_unit' => 'package', 'unit_per_purchase' => 6],
            ['name' => 'آب معدنی', 'purchase_price' => 3000, 'sale_price' => 4500, 'purchase_unit' => 'carton', 'unit_per_purchase' => 12],
            ['name' => 'شکلات تلخ', 'purchase_price' => 12000, 'sale_price' => 18000, 'purchase_unit' => 'box', 'unit_per_purchase' => 10],
            ['name' => 'کیک و بیسکویت', 'purchase_price' => 4000, 'sale_price' => 6000, 'purchase_unit' => 'carton', 'unit_per_purchase' => 24],
            ['name' => 'شیر 1 لیتری', 'purchase_price' => 5000, 'sale_price' => 7000, 'purchase_unit' => 'single', 'unit_per_purchase' => 1],
            ['name' => 'آدامس', 'purchase_price' => 1500, 'sale_price' => 2500, 'purchase_unit' => 'single', 'unit_per_purchase' => 1],
            ['name' => 'دمنوش', 'purchase_price' => 5000, 'sale_price' => 7000, 'purchase_unit' => 'package', 'unit_per_purchase' => 10],
            ['name' => 'نوشابه', 'purchase_price' => 6000, 'sale_price' => 9000, 'purchase_unit' => 'carton', 'unit_per_purchase' => 10],
            // ادامه محصولات...
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
