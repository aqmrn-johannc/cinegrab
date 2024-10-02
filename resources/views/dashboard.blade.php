<x-app-layout>

    @if(Auth::check())
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Hi there, {{ Auth::user()->name }}!
            </h2>
        </x-slot>
    @else
    @endif

    @if(!Auth::check())
        <div class="mt-6 text-center">
            <p class="text-gray-600 dark:text-gray-300">
                {{ __("Please login or register before accessing more features.") }}
            </p>
        </div>
    @endif

    <div class="py-12 background-image">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <h2 class="text-5xl font-bold mb-6 text-center text-gray-800 dark:text-gray-200">NOW SHOWING</h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 tooltip-container">
                        
                        @foreach([
                            'Deadpool & Wolverine' => 'Deadpools peaceful existence comes crashing down when the Time Variance Authority recruits him to help safeguard the multiverse. He soon unites with his would-be pal, Wolverine, to complete the mission and save his world from an existential threat.',
                            'Inside Out 2' => 'Joy, Sadness, Anger, Fear and Disgust have been running a successful operation by all accounts. However, when Anxiety shows up, they arent sure how to feel.',
                            'Despicable Me 4' => 'Gru welcomes a new member to the family, Gru Jr., whos intent on tormenting his dad. However, their peaceful existence soon comes crashing down when criminal mastermind Maxime Le Mal escapes from prison and vows revenge against Gru.',
                            'Alien: Romulus' => 'Space colonizers come face to face with the most terrifying life-form in the universe while scavenging the deep ends of a derelict space station.',
                            'TRANSFORMERS ONE' => 'Optimus Prime and Megatron, as former friends, bonded like brothers. Their relationship ultimately changes Cybertrons fate forever.',
                            'The Wild Robot' => 'Shipwrecked on a deserted island, a robot named Roz must learn to adapt to its new surroundings. Building relationships with the native animals, Roz soon develops a parental bond with an orphaned gosling.',
                            'Speak No Evil' => 'On a vacation in Toscana, a Danish family instantly becomes friends with a Dutch family. Months later, the Danish couple receives an unexpected invitation. It doesnt take long before the joy of reunion is replaced with misunderstandings.',
                            'Bad Boys: Ride or Die' => 'When their late police captain gets linked to drug cartels, wisecracking Miami cops Mike Lowrey and Marcus Burnett embark on a dangerous mission to clear his name.',
                            'It Ends With Us' => 'Lily Bloom moves to Boston to chase her lifelong dream of opening her own business. A chance meeting with charming neurosurgeon Ryle Kincaid soon sparks an intense connection, but as the two fall deeply in love, she begins to see sides of Ryle that remind her of her parents relationship. When Lilys first love, Atlas Corrigan, suddenly reenters her life, her relationship with Ryle gets upended, leaving her with an impossible choice.'
                        ] as $title => $description)
                            <div class="flex flex-col items-center group relative">
                                <div class="card-{{ $loop->index + 1 }} h-100 w-full transition-transform duration-300 ease-in-out transform group-hover:scale-105"></div> 
                                <div class="bg-black text-white text-center p-2 mt-2 w-80 rounded-lg">
                                    <p>{{ $title }}</p>
                                </div>
                                <div class="tooltip">
                                    <span class="tooltip-text">{{ $description }}</span>
                                </div>                                 
                            </div>
                        @endforeach

                    </div>                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
