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
                    <h1 class="text-4xl font-bold mb-6">{{ $movie->title }}</h1>
                    <p><strong>Genre:</strong> {{ $movie->genre }}</p>
                    <p><strong>Director:</strong> {{ $movie->director }}</p>
                    <p><strong>Duration:</strong> {{ $movie->duration }} minutes</p>
                    <p><strong>Release Date:</strong> {{ $movie->release_date->format('F d, Y') }}</p>
                    <p><strong>Rating:</strong> {{ $movie->rating }}</p>
                    <p><strong>Description:</strong> {{ $movie->description }}</p>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
