<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
    return view('dashboard.index', [
        'totalProducts' => Product::count(),
        'lowStock' => Product::where('quantity', '<=', 5)->count(),
        'todaySales' => Sale::whereDate('created_at', today())->sum('total'),
         ]);
    }
}
