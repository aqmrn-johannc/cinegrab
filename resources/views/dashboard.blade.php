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
