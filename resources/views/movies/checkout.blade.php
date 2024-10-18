<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-3xl font-bold text-yellow-500 mb-4">Checkout Details for {{ $title }}</h3>

                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-white">Movie Title: {{ $title }}</h3>
                        <p class="text-lg text-white">Price: ₱{{ number_format($price, 2) }}</p>
                        <p class="text-lg text-white">Selected Time: {{ $time_slot }}</p>
                        <p class="text-lg text-white">Seat Number: {{ $seat }}</p>
                    </div>

                    <form action="{{ route('reservation.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="movie_id" value="{{ $movie_id }}">
                        <input type="hidden" name="price" value="{{ $price }}">
                        <input type="hidden" name="time_slot" value="{{ $time_slot }}">
                        <input type="hidden" name="seat" value="{{ $seat }}">

                        <div class="flex justify-center">
                            <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded">Confirm Reservation</button>
                            <a href="{{ route('movies.show', $movie_id) }}" class="ml-4 bg-red-500 text-white font-bold py-2 px-4 rounded">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
