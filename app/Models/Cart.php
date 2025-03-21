<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'product_id', 'quantity', 'image'];

    public function product()
    {
        return $this->belongsTo(Cake::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
