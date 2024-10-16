<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center mb-6">
                <a href="{{ route('movies.show', $movie->id) }}" class="flex flex-col items-center group relative mr-6">
                    <div class="small-card-{{ $movie->id }} h-100 w-80"></div>
                    <div class="text-white text-center p-2 mt-2 w-80 rounded-lg"></div>
                </a>

                <div class="flex flex-col">
                    <h2 class="text-4xl font-bold text-white">
                        Buying Ticket for <span class="text-yellow-500">{{ $movie->title }}</span>
                    </h2>
                    <p class="mb-0 text-4xl font-bold text-white">Ticket Price: ₱{{ number_format($movie->price, 2) }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex">
                    <div class="w-1/2">
                        <form id="reservation-form" action="{{ route('reservation.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="movie_id" value="{{ $movie->id }}">

                            <!-- Time Slot Selection -->
                            <div class="mb-4">
                                <label for="time_slot" class="block text-lg font-medium text-white">Choose your time:</label>
                                <div class="mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="time_slot" value="09:00" class="form-radio" checked>
                                        <span class="ml-2 text-white">9:00 AM</span>
                                    </label>
                                    <label class="inline-flex items-center ml-6">
                                        <input type="radio" name="time_slot" value="12:00" class="form-radio">
                                        <span class="ml-2 text-white">12:00 PM</span>
                                    </label>
                                    <label class="inline-flex items-center ml-6">
                                        <input type="radio" name="time_slot" value="15:00" class="form-radio">
                                        <span class="ml-2 text-white">3:00 PM</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Seat Selection -->
                            <div class="mb-4">
                                <label for="seat" class="block text-lg font-medium text-white">Choose your seat:</label>
                                <select id="seat" name="seat" class="mt-1 block w-1/4 bg-gray-500 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                                    <!-- Seats will be dynamically updated here -->
                                </select>
                            </div>

                            <button type="button" class="bg-blue-500 text-white font-bold py-2 px-4 rounded" id="reserve-button">Reserve</button>
                        </form>
                    </div>

                    <!-- Seat Layout -->
                    <div class="w-1/2 pl-6">
                        <h3 class="text-lg font-medium text-white mb-2">Seat Layout</h3>
                        <div class="grid grid-cols-10 gap-1" id="seat-layout">
                            <!-- Seat layout will be dynamically updated here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmation-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-4">Confirm Payment</h2>
            <p>Are you sure you want to proceed with the reservation?</p>
            <div class="mt-6 flex justify-end">
                <button id="cancel-button" class="bg-red-500 text-white py-2 px-4 rounded mr-2">No</button>
                <button id="confirm-button" class="bg-green-500 text-white py-2 px-4 rounded">Yes</button>
            </div>
        </div>
    </div>

    <!-- Add the necessary script for dynamic seat loading and modal confirmation -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const timeSlots = document.querySelectorAll('input[name="time_slot"]');
            const seatSelect = document.getElementById('seat');
            const seatLayout = document.getElementById('seat-layout');
            const reserveButton = document.getElementById('reserve-button');
            const confirmationModal = document.getElementById('confirmation-modal');
            const confirmButton = document.getElementById('confirm-button');
            const cancelButton = document.getElementById('cancel-button');
            const reservationForm = document.getElementById('reservation-form');

            // Function to fetch available seats
            function fetchSeats(timeSlot) {
            const movieId = {{ $movie->id }}; // Use the current movie ID

            // Make AJAX call to fetch seats
            fetch(`/movies/${movieId}/seats/${timeSlot}`)
                .then(response => response.json())
                .then(data => {
                    // Clear current seat options and layout
                    seatSelect.innerHTML = '';
                    seatLayout.innerHTML = '';

                    // Update seat options in the select dropdown
                    data.seats.forEach(seat => {
                        const option = document.createElement('option');
                        option.value = seat.seat_number;

                        // If the seat is booked, style it yellow and disable it
                        if (seat.is_booked) {
                            option.disabled = true;
                            option.style.color = 'yellow';  // Change color to yellow for reserved seats
                        } else {
                            option.style.color = 'white'; // Change color to white for available seats
                        }

                        option.textContent = seat.seat_number + (seat.is_booked ? ' (Reserved)' : '');
                        seatSelect.appendChild(option);
                    });

                    // Update seat layout grid
                    data.seats.forEach(seat => {
                        const seatDiv = document.createElement('div');
                        seatDiv.classList.add('relative', 'h-10', 'w-10', 'flex', 'items-center', 'justify-center');
                        const img = document.createElement('img');
                        img.src = seat.is_booked ? '{{ asset("images/seat_green.png") }}' : '{{ asset("images/seat.png") }}'; // Adjust this logic as needed
                        img.alt = seat.seat_number;
                        img.classList.add('h-full', 'w-full', 'object-contain');
                        seatDiv.appendChild(img);
                        // const span = document.createElement('span');
                        // span.classList.add('absolute', 'text-xs', 'text-black');
                        // span.textContent = seat.seat_number;
                        // seatDiv.appendChild(span);
                        seatLayout.appendChild(seatDiv);
                    });
                })
                .catch(error => {
                    console.error('Error fetching seats:', error);
                });
        }

            timeSlots.forEach(slot => {
                slot.addEventListener('change', function () {
                    const selectedTimeSlot = this.value;
                    fetchSeats(selectedTimeSlot);
                });
            });

            fetchSeats('09:00');

            // Handle the reserve button click
            reserveButton.addEventListener('click', function() {
                confirmationModal.classList.remove('hidden'); // Show the modal
            });

            // Handle confirmation
            confirmButton.addEventListener('click', function() {
                confirmationModal.classList.add('hidden'); // Hide the modal
                reservationForm.submit(); // Submit the form after confirmation
            });

            // Handle cancellation
            cancelButton.addEventListener('click', function() {
                confirmationModal.classList.add('hidden'); // Hide the modal
            });
        });

        document.getElementById('confirmCancelButton').addEventListener('click', function() {
        fetch(`/reservations/${reservationIdToCancel}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
        .then(response => {
            if (response.ok) {
                alert('Reservation cancelled successfully.');
                // Call fetchSeats with the currently selected time slot to refresh the seat status
                const selectedTimeSlot = document.querySelector('input[name="time_slot"]:checked').value;
                fetchSeats(selectedTimeSlot); // Refresh the seats for the selected time slot
            } else {
                alert('Failed to cancel reservation. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error canceling reservation:', error);
            alert('An error occurred. Please try again later.');
        });

        closeModal();
    });

    </script>    
</x-app-layout>
