<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class productspoints extends Model
{
    use HasFactory, SoftDeletes;
<<<<<<< HEAD

    // key
    protected $primaryKey = 'id';
    protected $table = 'productspoints';
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

=======
    protected $primaryKey = 'ProductsPoints_id';
protected $fillable=['ProductsPoints_id','name','point','image_url'];
>>>>>>> 0300525f4a97b5eec70b92647ce911221f0f9110
}
