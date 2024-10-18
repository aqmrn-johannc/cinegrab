<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center mb-6">
                <h2 class="text-4xl font-bold text-white">
                    Editing Reservation for <span class="text-yellow-500">{{ $movie->title }}</span>
                </h2>
                <p class="mb-0 text-4xl font-bold text-white ml-6">Ticket Price: ₱{{ number_format($movie->price, 2) }}</p>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex">
                    <div class="w-1/2">
                        <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                            <input type="hidden" name="price" value="{{ $movie->price }}">
                            <input type="hidden" name="title" value="{{ $movie->title }}">

                            <div class="mb-4">
                                <label for="time_slot" class="block text-lg font-medium text-white">Choose your time:</label>
                                <div class="mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="time_slot" value="09:00" class="form-radio" {{ $reservation->time_slot == '09:00' ? 'checked' : '' }}>
                                        <span class="ml-2 text-white">9:00 AM</span>
                                    </label>
                                    <label class="inline-flex items-center ml-6">
                                        <input type="radio" name="time_slot" value="12:00" class="form-radio" {{ $reservation->time_slot == '12:00' ? 'checked' : '' }}>
                                        <span class="ml-2 text-white">12:00 PM</span>
                                    </label>
                                    <label class="inline-flex items-center ml-6">
                                        <input type="radio" name="time_slot" value="15:00" class="form-radio" {{ $reservation->time_slot == '15:00' ? 'checked' : '' }}>
                                        <span class="ml-2 text-white">3:00 PM</span>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="seat" class="block text-lg font-medium text-white">Choose your seat:</label>
                                <select id="seat" name="seat" class="mt-1 block w-1/4 bg-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                                    <option value="{{ $reservation->seat_number }}" selected>{{ $reservation->seat_number }}</option>
                                    <!-- You can dynamically add other options if needed -->
                                </select>
                            </div>

                            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Update </button>
                        </form>
                        
                    </div>

                    <div class="w-1/2 pl-6">
                        
                        <h3 class="text-lg font-medium text-white">Movie Theatre Layout</h3>
                                    <!-- Legend -->
                        <div class="mt-1">
                            <h4 class="text-lg font-medium text-white">Legend</h4>
                            <div class="flex items-center">
                                <div class="h-5 w-5 bg-white border border-gray-700 rounded mr-2"></div>
                                <span class="text-white">Available Seat</span>
                            </div>
                            <div class="flex items-center mt-1">
                                <div class="h-5 w-5 bg-lime-600 border border-gray-700 rounded mr-2"></div>
                                <span class="text-white">Reserved Seat</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-10 gap-1 overflow-y-auto h-96" id="seat-layout">
                            <!-- Seat layout will be dynamically populated here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const timeSlots = document.querySelectorAll('input[name="time_slot"]');
            const seatSelect = document.getElementById('seat');
            const seatLayout = document.getElementById('seat-layout');
            const movieId = {{ $movie->id }};
            const selectedTimeSlot = '{{ $reservation->time_slot }}'; // Pre-selected time slot

            function fetchSeats(timeSlot) {
                fetch(`/movies/${movieId}/seats/${timeSlot}`)
                    .then(response => response.json())
                    .then(data => {
                        seatSelect.innerHTML = '';
                        seatLayout.innerHTML = '';

                        data.seats.forEach(seat => {
                            const option = document.createElement('option');
                            option.value = seat.seat_number;
                            option.textContent = seat.seat_number + (seat.is_booked ? ' (Reserved)' : '');
                            option.disabled = seat.is_booked;

                            if (seat.is_booked) {
                                option.style.color = 'yellow'; // reserved seats
                            } else {
                                option.style.color = 'white'; // available seats
                            }

                            seatSelect.appendChild(option);

                            const seatDiv = document.createElement('div');
                            seatDiv.classList.add('relative', 'h-10', 'w-10', 'flex', 'items-center', 'justify-center');
                            seatDiv.setAttribute('title', seat.seat_number); 

                            const img = document.createElement('img');
                            img.src = seat.is_booked ? '{{ asset("images/seat_green.png") }}' : '{{ asset("images/seat.png") }}'; 
                            img.alt = seat.seat_number;
                            img.classList.add('h-full', 'w-full', 'object-contain');
                            seatDiv.appendChild(img);
                            seatLayout.appendChild(seatDiv);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching seats:', error);
                    });
            }

            // Fetch seats for the pre-selected time slot
            fetchSeats(selectedTimeSlot);

            // Update seats on time slot change
            timeSlots.forEach(slot => {
                slot.addEventListener('change', function () {
                    fetchSeats(this.value);
                });
            });
        });
    </script>
</x-app-layout>
