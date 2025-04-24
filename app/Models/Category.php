<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug', 'description' ];

    /**
     * Get the services for the category.
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}