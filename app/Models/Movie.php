<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'genre',
        'director',
        'duration',
        'release_date',
        'rating',
    ];

    protected $casts = [
        'release_date' => 'date',
    ];
}
