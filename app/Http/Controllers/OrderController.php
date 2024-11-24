<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderFormRequest;
use App\Models\Categories;
use App\Models\Order;
use App\Models\Payment;
use App\Models\products;
use App\Services\TranslationGoogle;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentFormRequest;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public function store(OrderFormRequest $request,$id)
    {
        //add translate in Services
        $lang = $request->header('lang', 'en');
        $translator = new TranslationGoogle($lang);
        // call in new object TranslationGoogle and add url use App\Services\TranslationGoogle; because protect must inhert this function
//        dd($lang); //test lang
        $data=$request->validated();
//        dd($data);
        DB::beginTransaction();
        $order = Order::create($request->only(['user_id', 'product_id','address','phone','status','total_price','quantity']));
//        dd($Order);
        DB::commit();
        if ($order) {
            return response()->json([
                'message' => $translator->translate('Order  successfully'),
            ], 201);
        }
        return response()->json([
        'error'=>$translator->translate('failed save Order'),
    ]);
    }

}
