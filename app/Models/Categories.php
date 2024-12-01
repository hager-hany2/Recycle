<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use HasFactory, SoftDeletes;


    // Rename id
    protected $primaryKey = 'category_id';
    protected $fillable = [ 'category_id', 'category_name', 'category_description', 'user_id', 'image_url'];


    //products
    public function products()
    {
        return $this->hasMany(products::class, 'category_id', 'category_id');
    }

}
