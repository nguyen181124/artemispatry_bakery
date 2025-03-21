<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cake extends Model
{
    protected $table = 'cake';
    public $timestamps = false;

    protected $guarded = [];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')
                ->withPivot('quantity', 'price');
    }
}
