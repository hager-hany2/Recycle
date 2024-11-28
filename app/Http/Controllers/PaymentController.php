<?php

namespace App\Http\Controllers;

use App\Http\Requests\callbackFormRequest;
use App\Http\Requests\PaymentFormRequest;
use App\Models\Payment;
use App\Services\TranslationGoogle;

class PaymentController extends Controller
{
    public function store(PaymentFormRequest $request)
    {
        //add translate in Services
        $lang = $request->header('lang', 'en');
        $translator = new TranslationGoogle($lang);
        // call in new object TranslationGoogle and add url use App\Services\TranslationGoogle; because porotect must inhert this function
//        dd($lang); //test lang
        // التحقق من البيانات

        $data = $request->validated();
//        dd($data);
        // إنشاء سجل جديد في جدول المدفوعات
        $payment = Payment::create($request->only(['user_id', 'order_id', 'Amount_paid', 'status', 'transaction_id', 'payment_method']));
//        dd($payment);
        if ($payment) {
            return response()->json([
                'message' => $translator->translate('Payment has been made successfully'),
            ], 201);
        }
        return response()->json([
            'error' => $translator->translate('failed payment'),
        ]);
    }

    public function handleCallback(callbackFormRequest $request)
    {
        $lang = $request->header('lang', 'en');
        $translator = new TranslationGoogle($lang);
        $payment = Payment::where('transaction_id', $request->transaction_id)->first();

        if ($payment) {
            $payment->status = $request->status === 'success' ? 'completed' : 'failed';
            $payment->save();
        }
        return response()->json(['message' => $translator->translate('Callback received')]);
    }

}
