<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'reservation_date',
        'status',
        'notes',
        'amount',
        'payment_status',
        'paypal_transaction_id',
    ];

    protected $casts = [
        'reservation_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function provider()
    {
        return $this->hasOneThrough(User::class, Service::class, 'id', 'id', 'service_id', 'provider_id');
    }
}