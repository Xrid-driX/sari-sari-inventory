<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;

class SaleController extends Controller
{
 public function scan(Request $request)
{
    $barcode = $request->barcode;

    // 👇 THIS IS THE LINE YOU ASKED ABOUT
    $quantity = $request->quantity ?? 1;

    $product = Product::where('barcode', $barcode)->first();

    if (!$product) {
        return response()->json([
            'success' => false,
            'message' => 'Product not found!',
        ]);
    }

    if ($product->quantity < $quantity) {
        return response()->json([
            'success' => false,
            'message' => 'Not enough stock!',
        ]);
    }

    // Deduct stock
    $product->decrement('quantity', $quantity);

    // Record sale
    Sale::create([
        'product_id' => $product->id,
        'quantity' => $quantity,
        'total' => $product->price * $quantity,
    ]);

    return response()->json([
        'success' => true,
        'message' => "Added {$quantity} item(s)",
        'product' => [
            'name' => $product->name,
            'price' => $product->price,
            'barcode' => $product->barcode,
        ],
    ]);
}

    public function index()
{
    $sales = Sale::with('product')->latest()->get();

    $totalRevenue = $sales->sum('total');
    $totalItemsSold = $sales->sum('quantity');

    return view('sales.index', compact(
        'sales',
        'totalRevenue',
        'totalItemsSold'
    ));
}
}

