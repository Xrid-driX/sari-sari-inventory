<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    \App\Models\Product::create([
        'barcode' => '123456789012',
        'name' => 'Royal Softdrink 1L',
        'price' => 45.00,
        'quantity' => 10,
    ]);

    // 🔽 ADD A NEW LINE (just duplicate and change values)
    \App\Models\Product::create([
        'barcode' => '987654321098',
        'name' => 'Piattos Cheese',
        'price' => 25.00,
        'quantity' => 30,
    ]);
}
}
