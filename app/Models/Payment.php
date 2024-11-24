<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\User;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'order_id', 'Amount_paid', 'status', 'transaction_id', 'payment_method'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id', 'order_id')->withTrashed();
    }
}
