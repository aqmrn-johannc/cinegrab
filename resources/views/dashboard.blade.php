<x-app-layout>
    @if(Auth::check())
        <h2 class="text-3xl font-bold mb-6 text-center text-white">Your Reservations</h2>

        {{-- Success message --}}
        @if(session('success'))
            <div class="bg-green-500 text-white text-center p-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full border-collapse">
            <thead>
                <tr>
                    <th class="border text-left p-2 text-white">Order ID</th>
                    <th class="border text-left p-2 text-white">Seat</th>
                    <th class="border text-left p-2 text-white">Movie Title</th>
                </tr>
            </thead>
            <tbody>
                @foreach(Auth::user()->reservations as $reservation)
                    <tr class="bg-gray-800"> 
                        <td class="border p-2 text-white">{{ $reservation->order_number }}</td>
                        <td class="border p-2 text-white">{{ $reservation->seat }}</td>
                        <td class="border p-2 text-white">{{ $reservation->movie->title }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        
                        @foreach($movies as $movie)
                            <a href="{{ route('movies.show', $movie->id) }}" class="flex flex-col items-center group relative">
                                <div class="card-{{ $loop->index + 1 }} h-100 w-full transition-transform duration-300 ease-in-out transform group-hover:scale-105"></div> 
                                <div class="bg-black text-white text-center p-2 mt-2 w-80 rounded-lg">
                                    <p>{{ $movie->title }}</p>
                                </div>
                            </a>
                        @endforeach

                    </div>                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
