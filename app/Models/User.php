<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'phone',
        'role',
        'status',
        'approval',
        'avatar',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function determineAvatarByName(?string $name): string
    {
        if (empty($name)) {
            return '/images/avatars/male_1.png';
        }

        $pattern = '/\b(siti|dewi|rini|rina|putri|ayu|tri|linda|diah|sari|wulan|wulandari|anggraeni|anggraini|lestari|kartika|nadia|rahma|yura|sulistiya|anisa|annisa|aisyah|fatimah|mega|maya|dina|fitri|lia|ria|tia|nia|mia|tari|ratna|susanti|novita|desi|widya|melati|bunga|mira|yulia|yuliana|citra|indah|safitri|maharani|amalia|zahra|tiara|shinta|mutia|nita|rahayu|pertiwi|salma|syifa|hanifah|hidayah|cantika|nurul)\b/i';
        $isFemale = (bool) preg_match($pattern, $name);

        $femaleAvatars = [
            '/images/avatars/female_1.png',
            '/images/avatars/female_2.png',
            '/images/avatars/female_3.png',
            '/images/avatars/female_4.png',
        ];

        $maleAvatars = [
            '/images/avatars/male_1.png',
            '/images/avatars/male_2.png',
            '/images/avatars/male_3.png',
            '/images/avatars/male_4.png',
        ];

        $pool = $isFemale ? $femaleAvatars : $maleAvatars;
        $index = abs(crc32($name)) % count($pool);
        return $pool[$index];
    }

    public function getAvatarAttribute($value): string
    {
        // Jika belum ada avatar atau masih menggunakan foto Unsplash eksternal lama, ganti ke ilustrasi kartun lokal
        if (empty($value) || str_contains($value, 'unsplash.com') || str_contains($value, '1535713875002-d1d0cf377fde')) {
            return self::determineAvatarByName($this->name ?? '');
        }
        return $value;
    }

    public function shop()
    {
        return $this->hasOne(Shop::class, 'owner_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function deliveries()
    {
        return $this->hasMany(Order::class, 'driver_id');
    }

    public function disputes()
    {
        return $this->hasMany(Dispute::class, 'buyer_id');
    }
}
