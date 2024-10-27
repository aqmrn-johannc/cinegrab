<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'price',
        'poster_filename',
        'trailer_filename',
    ];

    protected $casts = [
        'release_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($movie) {

            if ($movie->poster) {
                Storage::delete('public/images/' . $movie->poster);
            }

            if ($movie->trailer) {
                Storage::delete('public/trailers/' . $movie->trailer);
            }
        });
    }
}

