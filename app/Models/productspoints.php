<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class productspoints extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'ProductsPoints_id';
protected $fillable=['user_id','ProductsPoints_id','name','point','image_url'];
}
