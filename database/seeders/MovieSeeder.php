<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;

class MovieSeeder extends Seeder
{
    public function run()
    {
        Movie::create([
            'title' => 'Deadpool & Wolverine',
            'description' => 'Deadpools peaceful existence comes crashing down when the Time Variance Authority recruits him to help safeguard the multiverse. He soon unites with his would-be pal, Wolverine, to complete the mission and save his world from an existential threat.',
            'genre' => 'Action,Comedy,Superhero,Science Fiction,Adventure',
            'director' => 'Shawn Levy',
            'duration' => '127',
            'release_date' => '2024-7-25',
            'rating' => 'R',
            'price' => 250.00, // Added price
        ]);

        Movie::create([
            'title' => 'Inside Out 2',
            'description' => 'Joy, Sadness, Anger, Fear and Disgust have been running a successful operation by all accounts. However, when Anxiety shows up, they arent sure how to feel.',
            'genre' => 'Animation, Childrens film, Comedy, Adventure, Drama, Coming-of-age story',
            'director' => 'Pete Docter',
            'duration' => 96,
            'release_date' => '2024-6-14',
            'rating' => 'PG',
            'price' => 220.00, // Added price
        ]);

        Movie::create([
            'title' => 'Despicable Me 4',
            'description' => 'Gru welcomes a new member to the family, Gru Jr., whos intent on tormenting his dad. However, their peaceful existence soon comes crashing down when criminal mastermind Maxime Le Mal escapes from prison and vows revenge against Gru.',
            'genre' => 'Animation, Childrens film, Comedy, Adventure, Science Fiction, Family film',
            'director' => 'Kyle Balda',
            'duration' => 94,
            'release_date' => '2024-7-3',
            'rating' => 'PG',
            'price' => 200.00, // Added price
        ]);

        Movie::create([
            'title' => 'Alien: Romulus',
            'description' => 'Space colonizers come face to face with the most terrifying life-form in the universe while scavenging the deep ends of a derelict space station.',
            'genre' => 'Horror, Science fiction, Action, Thriller',
            'director' => 'Fede Álvarez',
            'duration' => 119,
            'release_date' => '2024-8-15',
            'rating' => 'R',
            'price' => 300.00, // Added price
        ]);

        Movie::create([
            'title' => 'TRANSFORMERS: ONE',
            'description' => 'Optimus Prime and Megatron, as former friends, bonded like brothers. Their relationship ultimately changes Cybertrons fate forever.',
            'genre' => 'Animation, Action, Adventure, Science fiction, Fantasy, Family film',
            'director' => 'Josh Cooley',
            'duration' => 104,
            'release_date' => '2024-9-20',
            'rating' => 'PG',
            'price' => 280.00, // Added price
        ]);

        Movie::create([
            'title' => 'the Wild Robot',
            'description' => 'Shipwrecked on a deserted island, a robot named Roz must learn to adapt to its new surroundings. Building relationships with the native animals, Roz soon develops a parental bond with an orphaned gosling.',
            'genre' => 'Animation, Novel, Science fiction',
            'director' => 'Chris Sanders',
            'duration' => 102,
            'release_date' => '2024-9-27',
            'rating' => 'PG',
            'price' => 150.00, // Added price
        ]);

        Movie::create([
            'title' => 'Speak No Evil',
            'description' => 'A dream holiday turns into a living nightmare when an American couple and their daughter spend the weekend at a British familys idyllic country estate.',
            'genre' => 'Horror, Thriller, Pyschological horror, Psychological thriller, Drama, Mystery, Pscycological fiction',
            'director' => 'Christian Tafdrup',
            'duration' => 110,
            'release_date' => '2024-9-13',
            'rating' => 'R',
            'price' => 350.00, // Added price
        ]);

        Movie::create([
            'title' => 'Bad Boys: Ride or Die',
            'description' => 'When their late police captain gets linked to drug cartels, wisecracking Miami cops Mike Lowrey and Marcus Burnett embark on a dangerous mission to clear his name.',
            'genre' => 'Action, Comedy, Action comedy, Buddy cop, Adventure, Thriller, Detective fiction, Crime fiction, Police procedural',
            'director' => 'Adil El Arbi, Bilall Fallah',
            'duration' => 115,
            'release_date' => '2024-6-7',
            'rating' => 'R',
            'price' => 300.00, // Added price
        ]);

        Movie::create([
            'title' => 'It Ends with Us',
            'description' => 'Lily Bloom moves to Boston to chase her lifelong dream of opening her own business. A chance meeting with charming neurosurgeon Ryle Kincaid soon sparks an intense connection, but as the two fall deeply in love, she begins to see sides of Ryle that remind her of her parents relationship. When Lilys first love, Atlas Corrigan, suddenly reenters her life, her relationship with Ryle gets upended, leaving her with an impossible choice.',
            'genre' => 'Romance, Drama, Melodrama',
            'director' => 'Justin Baldoni',
            'duration' => 131,
            'release_date' => '2024-8-9',
            'rating' => 'PG-13',
            'price' => 250.00, // Added price
        ]);
    }
}
