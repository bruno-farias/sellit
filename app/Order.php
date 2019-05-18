<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'customer_id',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_ud');
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
