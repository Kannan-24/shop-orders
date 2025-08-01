<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'total_amount',
        'balance',
        'status'
    ];

    public function paymentItems()
    {
        return $this->hasMany(PaymentItem::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
