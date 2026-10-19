<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'time',
        'admin',
        'action',
        'target',
        'status',
    ];

    protected $casts = [
        'time' => 'datetime',
    ];
}
