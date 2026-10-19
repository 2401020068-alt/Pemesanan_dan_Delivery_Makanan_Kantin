<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'shop_id',
        'name',
        'description',
        'category',
        'price',
        'image',
        'available',
    ];

    protected $casts = [
        'available' => 'boolean',
        'price' => 'integer',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}
