<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('reservation.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                        <div class="mb-4">
                            <label for="seat" class="block text-lg font-medium text-white">Choose your seat:</label>
                            <select id="seat" name="seat" class="mt-1 block w-1/4 bg-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                                @foreach($seats as $seat)
                                    <option value="{{ $seat->seat_number }}" {{ $seat->is_booked ? 'disabled' : '' }}>
                                        {{ $seat->seat_number }} {{ $seat->is_booked ? '(Reserved)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Reserve</button>
                    </form>   
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
