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

        foreach ($trailers as $id => $filename) {
            DB::table('movies')->where('id', $id)->update(['trailer_filename' => $filename]);
        }
    }
}
