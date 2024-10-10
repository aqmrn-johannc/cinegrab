<x-app-layout>
    @if(!Auth::check())
    <div class="mt-6 text-center">
        <p class="text-gray-600 dark:text-gray-300">
            {{ __("Please login or register before accessing more features.") }}
        </p>
    </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-col md:flex-row items-center md:items-start">  

                        <div class="flex flex-col items-center group relative md:w-1/3">
                            @php
                                $cardClass = '';
                                switch($movie->id) {
                                    case '1':
                                        $cardClass = 'card-1';
                                        break;
                                    case '2':
                                        $cardClass = 'card-2';
                                        break;
                                    case '3':
                                        $cardClass = 'card-3';
                                        break;
                                    case '4':
                                        $cardClass = 'card-4';
                                        break;
                                    case '5':
                                        $cardClass = 'card-5';
                                        break;
                                    case '6':
                                        $cardClass = 'card-6';
                                        break;
                                    case '7':
                                        $cardClass = 'card-7';
                                        break;
                                    case '8':
                                        $cardClass = 'card-8';
                                        break;
                                    case '9':
                                        $cardClass = 'card-9';
                                        break;
                                    default:
                                        $cardClass = 'card-1'; 
                                }
                            @endphp
                            <div class="{{ $cardClass }} h-100 w-full transition-transform duration-300 ease-in-out transform group-hover:scale-105"></div>
                        </div>

                        <div class="md:ml-8 md:w-2/3 mt-8 md:mt-0"> 
                            <h1 class="text-4xl font-bold mb-6">{{ $movie->title }}</h1>
                            <p><strong>Genre:</strong> {{ $movie->genre }}</p>
                            <p><strong>Director:</strong> {{ $movie->director }}</p>
                            <p><strong>Duration:</strong> {{ $movie->duration }} minutes</p>
                            <p><strong>Release Date:</strong> {{ $movie->release_date->format('F d, Y') }}</p>
                            <p><strong>Rating:</strong> {{ $movie->rating }}</p>
                            <p class="text-xl mt-8"><strong>Description:</strong> {{ $movie->description }}</p>

                            @if(Auth::check())
                                <a href="{{ route('movies.reservation', ['movie' => $movie->id]) }}" 
                                   class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded mt-6 inline-block">
                                    Purchase Seat and Ticket
                                </a>
                            @else
                                <div class="relative inline-block mt-6 cursor-pointer">
                                    <button class="bg-green-800 text-white font-bold py-2 px-4 rounded cursor-not-allowed" disabled>
                                        Purchase Seat and Ticket
                                    </button>
                                    <div class="absolute left-full -top-3 ml-1 mt-0 w-48 bg-gray-700 text-white text-sm rounded-lg p-2 opacity-0 tooltip transition-opacity duration-200">
                                        You must be signed up and logged in to do this action.
                                    </div>
                                </div>
                            @endif
                                                    
                        </div>
                    </div>     
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
