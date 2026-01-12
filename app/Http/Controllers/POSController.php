<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;

class POSController extends Controller
{
    public function index()
    {
        return view('pos.index');
    }

    public function scan(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::where('barcode', $request->barcode)->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ]);
        }

        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock'
            ]);
        }

        // ✅ DEDUCT STOCK
        $product->decrement('stock', $request->quantity);

        // ✅ RECORD SALE
        Sale::create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'total' => $product->price * $request->quantity,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Added successfully',
            'product' => [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity
            ]
        ]);
    }
}
