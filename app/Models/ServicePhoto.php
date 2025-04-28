<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'filename',
        'is_primary',
        'order'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'order' => 'integer'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
