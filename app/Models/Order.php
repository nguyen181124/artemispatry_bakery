<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'payment_method',
        'created_at',
        'updated_at',
    ];

    public function cakes()
    {
        return $this->belongsToMany(Cake::class, 'order_items')
                ->withPivot('quantity', 'price');
    }
}
