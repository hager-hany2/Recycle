<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
class VodafonePaymentService
{
    public function processVodafonePayment($phoneNumber, $amount)
    {
        // التحقق من أن المبلغ المدفوع أكبر من الصفر
        if ($amount <= 0) {
            return [
                'status' => 'error',
                'message' => 'The amount must be greater than zero.'
            ];
        }

        // إنشاء transaction_id فريد باستخدام uuid
        $transactionId = $this->generateTransactionId();

        // إرسال طلب الدفع إلى فودافون كاش عبر API
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('payment.vodafone_cash_api_key'),
        ])->post(config('payment.vodafone_cash_api_url'), [
            'phone_number' => $phoneNumber,  // رقم الهاتف الذي سيستقبل الرصيد
            'transaction_id' => $transactionId,
            'Amount_paid' => $amount,
            'callback_url' => config('payment.vodafone_cash_callback_url'),
        ]);

        // التحقق من نجاح الدفع
        if ($response->successful()) {
            // إذا كان الدفع ناجحاً، نعيد الـ transaction_id مع حالة النجاح
            return [
                'status' => 'success',
                'transaction_id' => $transactionId,
                'message' => 'Payment processed successfully.'
            ];
        } else {
            // إذا فشل الدفع، نعيد استجابة تحتوي على الخطأ
            return [
                'status' => 'error',
                'message' => 'Vodafone Cash payment failed: ' . $response->body()
            ];
        }
    }

    private function generateTransactionId()
    {
        return 'TXN-' . (string) \Str::uuid();  // استخدام uuid بدلًا من uniqid
    }

}
