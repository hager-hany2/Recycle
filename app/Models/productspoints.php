<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class productspoints extends Model
{
    use HasFactory, SoftDeletes;

    // key
    protected $primaryKey = 'id';
    protected $table = 'productspoints';
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
