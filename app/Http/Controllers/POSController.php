<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class POSController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('pos.index', compact('products'));
    }

    public function scan(Request $request)
    {
        $request->validate([
            'barcode'  => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $product = Product::where('barcode', $request->barcode)
                ->lockForUpdate()
                ->first();

            if (!$product) {
                throw new \Exception('Product not found');
            }

            if ($product->quantity < $request->quantity) {
                throw new \Exception('Insufficient stock');
            }

            // ✅ Deduct stock
            $product->decrement('quantity', $request->quantity);

            // ✅ Record sale
            Sale::create([
                'product_id' => $product->id,
                'quantity'   => $request->quantity,
                'total'      => $product->price * $request->quantity,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sale recorded successfully',
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'barcode' => $product->barcode,
                    'quantity' => $product->quantity
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }  // ← Check this out retard

    public function deductWithQuantity(Request $request)
    {
        $request->validate([
            'barcode'  => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $product = Product::where('barcode', $request->barcode)
                ->lockForUpdate()
                ->first();

            if (!$product) {
                throw new \Exception('Product not found');
            }

            if ($product->quantity < $request->quantity) {
                throw new \Exception('Insufficient stock');
            }

            //  Deduct stock with user's quantity
            $product->decrement('quantity', $request->quantity);

            //  Record sale
            Sale::create([
                'product_id' => $product->id,
                'quantity'   => $request->quantity,
                'total'      => $product->price * $request->quantity,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sale recorded successfully',
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'barcode' => $product->barcode,
                    'quantity' => $product->quantity
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
