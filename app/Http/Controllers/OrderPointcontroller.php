<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderFormRequest;
use App\Http\Requests\OrderPointFormRequest;
use App\Http\Requests\PaymentFormRequest;
use App\Models\Order;
use App\Services\TranslationGoogle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Orderpoints;

class OrderPointcontroller extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderPointFormRequest $request,$id)
    {

        //add translate in Services
        $lang = $request->header('lang', 'en');
        $translator = new TranslationGoogle($lang);
        // call in new object TranslationGoogle and add url use App\Services\TranslationGoogle; because protect must inhert this function
//        dd($lang); //test lang
        $data=$request->validated();
//        dd($data);
        DB::beginTransaction();
        $order =Orderpoints::create($request->only(['user_id', 'OrderPoint_id','address','phone','status','total_price','quantity']));
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
