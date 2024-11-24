<?php

namespace App\Http\Controllers;

use App\Models\Order;
//use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;


class ReportOrdercontroller extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $orders = Order::with('user') // نربط الـ orders مع الـ user للحصول على اسم كل مستخدم
        ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()])
            ->get();
        $total_price = $orders->sum('total_price');
        $data = [
            'orders' => $orders,
            '$total_price' => $total_price,
            'date' => Carbon::now()->toDateString(),
        ];
        return response()->json($data);
    }
}
