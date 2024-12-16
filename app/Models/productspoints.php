<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class productspoints extends Model
{
    use HasFactory, SoftDeletes;

    // Primary key and table name
    protected $primaryKey = 'id'; // Assuming 'ProductsPoints_id' is the correct primary key
    protected $table = 'productspoints'; // Table name
    protected $guarded = []; // Use guarded to protect against mass assignment

    // Define fillable fields
    protected $fillable = ['id', 'name', 'point', 'image_url'];


}
