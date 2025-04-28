<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'provider_id',
        'category_id',
        'is_available'
    ];

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }

    public function photos()
    {
        return $this->hasMany(ServicePhoto::class)->orderBy('order');
    }

    public function primaryPhoto()
    {
        return $this->hasOne(ServicePhoto::class)->where('is_primary', true);
    }
}