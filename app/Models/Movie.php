<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'description',
        'genre',
        'director',
        'duration',
        'release_date',
        'rating',
        'trailer_filename',
    ];

    protected $casts = [
        'release_date' => 'date',
    ];
}
