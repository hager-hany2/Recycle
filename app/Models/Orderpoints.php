<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orderpoints extends Model
{
    use HasFactory,SoftDeletes;
    protected $primaryKey = 'OrderPoint_id';
    protected $fillable=['OrderPoint_id','ProductsPoints_id','user_id', 'address','phone','status','total_price','quantity'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(productspoints::class,'ProductsPoints_id', 'ProductsPoints_id')->withTrashed();
    }

}
