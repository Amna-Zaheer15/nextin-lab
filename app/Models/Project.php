<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

  

    protected $fillable = [
        'title',
        'short_description',
        'full_description',
        'status',
        'image_url',
        'technology',
        'price',
        'downloads',
        'purchases'
    ];

    protected $casts = [
        'downloads' => 'integer',
        'purchases' => 'integer',
    ];

    protected $attributes = [
        'status' => 'active',
        'downloads' => 0,
        'purchases' => 0,
    ];
}