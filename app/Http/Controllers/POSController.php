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

    /**
     * Handle the barcode scanning and inventory deduction.
     */
    public function scan(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        // Find the product by barcode
        $product = Product::where('barcode', $request->barcode)->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in inventory.'
            ]);
        }

        // FIXED: Changed 'stock' to 'quantity' to match your database column
        if ($product->quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => "Insufficient stock. Only {$product->quantity} left."
            ]);
        }

        // ✅ FIXED: DEDUCT from 'quantity' column
        $product->decrement('quantity', $request->quantity);

        // ✅ RECORD SALE
        // Note: Ensure your Sale model has $fillable for these fields!
        Sale::create([
            'product_id' => $product->id,
            'quantity'   => $request->quantity,
            'total'      => $product->price * $request->quantity,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Added to cart and stock updated!',
            'product' => [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity
            ]
        ]);
    }
}
