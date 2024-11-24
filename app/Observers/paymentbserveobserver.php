<?php

namespace App\Observers;

use App\Models\ayment;

class paymentbserveobserver
{
    /**
     * Handle the ayment "created" event.
     */
//    public function created(ayment $payment): void
//    {
////      dd($payment);
//    }

    /**
     * Handle the ayment "updated" event.
     */
//    public function updated(payment $payment): void
//    {
//        if ($payment->isDirty('status') && $payment->status === 'pending') {
//            // إعداد الطلب لإرسال الدفع
//            $response = Http::withHeaders([
//                'Authorization' => 'Bearer ' . env('VODAFONE_CASH_API_KEY'),
//            ])->post('https://vodafonecashapi.com/pay', [
//                'account_id' => env('VODAFONE_CASH_ACCOUNT_ID'),
//                'transaction_id' => $payment->transaction_id,
//                'Amount_paid' => $payment->Amount_paid,
//                'callback_url' => env('VODAFONE_CASH_CALLBACK_URL'),
//            ]);
//
//            // تحديث الحالة بناءً على رد فودافون
//            if ($response->successful()) {
//                $payment->status = 'completed';
//            } else {
//                $payment->status = 'failed';
//            }
//            $payment->save();
//        }
//
//
//    }

    /**
     * Handle the ayment "deleted" event.
     */
    public function deleted(ayment $payment): void
    {
        //
    }

    /**
     * Handle the ayment "restored" event.
     */
    public function restored(ayment $payment): void
    {
        //
    }

    /**
     * Handle the ayment "force deleted" event.
     */
    public function forceDeleted(ayment $payment): void
    {
        //
    }
}
