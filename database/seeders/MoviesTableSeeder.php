<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MoviesTableSeeder extends Seeder
{
    public function run()
    {
        $trailers = [
            1 => 'trailer1.mp4',
            2 => 'trailer2.mp4',
            3 => 'trailer3.mp4',
            4 => 'trailer4.mp4',
            5 => 'trailer5.mp4',
            6 => 'trailer6.mp4',
            7 => 'trailer7.mp4',
            8 => 'trailer8.mp4',
            9 => 'trailer9.mp4',
        ];

        $posters = [
            1 => 'card1.jpg',
            2 => 'card2.jpg',
            3 => 'card3.jpg',
            4 => 'card4.jpg',
            5 => 'card5.jpg',
            6 => 'card6.jpg',
            7 => 'card7.jpg',
            8 => 'card8.jpg',
            9 => 'card9.jpg',
        ];

        foreach ($trailers as $id => $trailerFilename) {
            DB::table('movies')->where('id', $id)->update([
                'trailer_filename' => $trailerFilename,
                'poster_filename' => $posters[$id] ?? null, 
            ]);
        }
    }
}
