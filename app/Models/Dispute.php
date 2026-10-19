<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'order_id',
        'buyer_id',
        'issue',
        'description',
        'proof',
        'status',
        'resolution',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
