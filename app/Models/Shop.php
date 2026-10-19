<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'owner_id',
        'name',
        'description',
        'image',
        'location',
        'hours',
        'open',
        'approval',
        'submitted',
    ];

    protected $casts = [
        'open' => 'boolean',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class, 'shop_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'shop_id');
    }
}
