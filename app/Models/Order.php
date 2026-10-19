<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'trx_id',
        'buyer_id',
        'shop_id',
        'driver_id',
        'subtotal',
        'delivery_fee',
        'total',
        'address',
        'note',
        'payment_method',
        'payment_status',
        'proof',
        'status',
        'delivery_status',
    ];

    protected $casts = [
        'subtotal' => 'integer',
        'delivery_fee' => 'integer',
        'total' => 'integer',
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function disputes()
    {
        return $this->hasMany(Dispute::class, 'order_id');
    }
}
