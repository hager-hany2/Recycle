<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class products extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['product_id', 'product_name', 'product_description','price_product','point_product','category_name','image_url','QuantityType','category_id'];
}
