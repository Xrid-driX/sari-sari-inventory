<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function dashboard() {
    $lowStock = Product::where('quantity', '<', 5)->get(); // low stock threshold
    return view('dashboard', compact('lowStock'));
}

}
