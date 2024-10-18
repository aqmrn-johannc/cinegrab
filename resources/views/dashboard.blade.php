<x-app-layout>
    @if(auth()->check())
        @if(auth()->user()->banned_until && now()->isBefore(auth()->user()->banned_until))
            <div class="flex flex-col items-center justify-center h-screen bg-gray-800 text-white">

                <img src="{{ asset('images/ban.png') }}" alt="Banned" class="mb-5" style="max-width: 100px;">

                <h1 class="text-6xl font-bold mb-4 text-red-500">You Are Temporarily Banned</h1>
                
                <!-- Display the ban reason -->
                <p class="text-4xl text-white mb-4">
                    Reason: {{ auth()->user()->ban_reason ?? 'No reason specified.' }}
                </p>

                <p class="text-2xl text-white">Time remaining: <span id="countdown"></span></p>
            </div>

            <script>
                // Convert PHP date to ISO format for JavaScript compatibility
                const bannedUntil = new Date("{{ \Carbon\Carbon::parse(auth()->user()->banned_until)->toIso8601String() }}").getTime();

                console.log("Banned Until Time (ms):", bannedUntil); // Debugging: Ensure correct time is passed to JS

                const countdown = setInterval(function() {
                    const now = new Date().getTime();
                    const distance = bannedUntil - now;

                    if (distance < 0) {
                        clearInterval(countdown);
                        window.location.href = "{{ route('dashboard') }}"; // Redirect to user dashboard
                    } else {
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        document.getElementById("countdown").innerHTML = hours + "h " + minutes + "m " + seconds + "s ";
                    }
                }, 1000);
            </script>
        @endif
    @else
        <div>Please log in to view your account details.</div>
    @endif

    <div class="flex py-12" style="background-image: url('/images/bgimage.png'); background-size: cover; background-position: center;">

        <div class="w-1/3 bg-gray-800 p-6 rounded-lg shadow-lg mr-6 sticky top-0"> 
            @if(Auth::check())
                <h2 class="text-3xl font-bold mb-6 text-center text-white">Your Reservations ({{ Auth::user()->reservations->count() }})</h2>

                <div class="text-center mb-4">
                    <a href="{{ route('reservations.export') }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">
                        Export to EXCEL
                    </a>
                </div>



                @if(session('success'))
                    <div class="bg-green-500 text-white text-center p-3 mb-4 rounded">
                        {{ session('success') }}
                    </div>
                @endif
        

                <div class="reservations-container h-80 overflow-y-auto space-y-4">
                    @if(Auth::user()->reservations->isEmpty())
                        <div class="bg-gray-700 p-4 rounded-lg shadow-md text-center text-gray-300">
                            You don't have any reservations as of the moment.
                        </div>
                    @else
                        @foreach(Auth::user()->reservations as $reservation)
                            <div class="bg-gray-700 p-4 rounded-lg shadow-md">
                                <div class="flex items-center mb-2">
                                    <div class="flex flex-col items-center group relative mr-4">
                                        <div class="small-card-{{ $reservation->movie->id }} h-20 w-32"></div> 
                                        <div class="text-white text-center p-2 mt-1 w-32 rounded-lg">
                                            <p class="font-semibold">{{ $reservation->movie->title }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-white">{{ $reservation->movie->title }}</h3>
                                        <p class="text-gray-300">Duration: {{ $reservation->movie->duration }} mins</p>
                                        <p class="text-gray-300">Order ID: {{ $reservation->order_number }}</p>
                                        <p class="text-gray-300">Seat: {{ $reservation->seat_number }}</p>
                                        <p class="text-gray-300">Price: ₱{{ number_format($reservation->movie->price, 2) }}</p>
                                        <p class="text-gray-300">Schedule: {{ $reservation->time_slot }}</p>
                                        <button onclick="confirmCancel({{ $reservation->id }})" class="mt-2 bg-red-500 text-white font-bold py-2 px-4 rounded">Cancel Purchase</button>
                                    </div>    
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endif
        
            @if(!Auth::check())
                <div class="mt-6 text-center">
                    <h2 class="text-3xl font-bold mb-6 text-center text-white">Your Reservations</h2>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __("Please login or register before accessing more features.") }}
                    </p>
                </div>
            @endif
        </div>
        

        <div class="w-2/3">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-5xl font-bold mb-6 text-center text-gray-800 dark:text-gray-200">NOW SHOWING</h2>
                
        
                <div class="movies-container h-80 overflow-y-auto space-y-4"> 
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

 
    <div id="cancelConfirmationModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <h3 class="text-lg font-semibold mb-4">Are you sure you want to cancel this reservation?</h3>
            <button id="confirmCancelButton" class="bg-red-500 text-white font-bold py-2 px-4 rounded">Yes</button>
            <button onclick="closeModal()" class="bg-gray-300 text-black font-bold py-2 px-4 rounded">No</button>
        </div>
    </div>

    <script>
        let reservationIdToCancel;
    
        function confirmCancel(reservationId) {
            reservationIdToCancel = reservationId;
            document.getElementById('cancelConfirmationModal').classList.remove('hidden');
        }
    
        function closeModal() {
            document.getElementById('cancelConfirmationModal').classList.add('hidden');
        }
    
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
                    location.reload(); 
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
