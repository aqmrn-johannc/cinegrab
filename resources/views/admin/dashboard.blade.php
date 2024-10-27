<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">

            <div class="mb-6">
                <a href="{{ route('movies.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Add Movie
                </a>
            </div>

            <h2 class="text-2xl font-bold mb-6 text-white">Movies</h2>
            <div class="text-gray-900 dark:text-gray-100 mb-4">
                Total: {{ $movies->count() }} 
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg mb-8">
                <div class="p-4 text-gray-900 dark:text-gray-100"> 
                    <div class="max-h-auto overflow-y-auto">
                        <table class="min-w-full table-auto divide-y divide-gray-200"> 
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Genre</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Director</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Release Date</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($movies as $movie)
                                    <tr>
                                        <td class="px-4 py-2 text-sm">{{ $movie->title }}</td> 
                                        <td class="px-4 py-2 text-sm">{{ $movie->genre }}</td>
                                        <td class="px-4 py-2 text-sm">{{ $movie->director }}</td>
                                        <td class="px-4 py-2 text-sm">{{ $movie->release_date->format('Y-m-d') }}</td>
                                        <td class="px-4 py-2 text-sm">{{ number_format($movie->price, 2) }}</td>
                                        <td class="px-4 py-2 text-sm">
                                            <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="border border-red-500 bg-red-500 text-white font-bold py-1 px-2 rounded hover:bg-red-600">Delete</button> 
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <h2 class="text-2xl font-bold mb-6 text-white">Reservations</h2>
            <div class="text-gray-900 dark:text-gray-100 mb-4">
                Total: {{ $totalReservations }} 
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Movie</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Time Slot</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Seat Number</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($reservations as $reservation)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->movie->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->time_slot }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->seat_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($reservation->status) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($reservation->status == 'pending')
                                        <form action="{{ route('reservations.approve', $reservation->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Approve</button>
                                        </form>
                                        <form action="{{ route('reservations.deny', $reservation->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Deny</button>
                                        </form>
                                    @endif
                                </td>                                
                            </tr>
                            @endforeach                            
                        </tbody>
                    </table>
                </div>
            </div>

            <h2 class="text-2xl font-bold mb-6 text-white">Registered Users</h2>
            <div class="text-gray-900 dark:text-gray-100 mb-4">
                Total: {{ $totalUsers }} 
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Date Registered</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Ban Status</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($user->banned_until && now()->isBefore($user->banned_until))
                                            <span class="countdown" data-banned-until="{{ $user->banned_until->toIso8601String() }}">
                                                {{ \Carbon\Carbon::parse($user->banned_until)->diffInSeconds(now()) }} seconds remaining
                                            </span>
                                        @else
                                            Not Banned
                                        @endif
                                    </td>                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button onclick="openBanModal({{ $user->id }})" class="bg-yellow-500 text-white py-1 px-3 rounded">Ban User</button>
                                        <button onclick="unbanUser({{ $user->id }})" class="bg-green-500 text-white py-1 px-3 rounded ml-2">Unban User</button>
                                    </td>                                 
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const countdowns = document.querySelectorAll('.countdown');
                    
                            countdowns.forEach(countdown => {
                                const bannedUntil = countdown.dataset.bannedUntil;
                                const endTime = new Date(bannedUntil);
                    
                                function updateCountdown() {
                                    const now = new Date();
                                    const remainingTime = Math.max(0, endTime - now);
                                    const secondsRemaining = Math.floor(remainingTime / 1000);
                                    countdown.textContent = `${secondsRemaining} seconds remaining`;
                                    if (remainingTime <= 0) {
                                        countdown.textContent = 'Not Banned';
                                        clearInterval(interval);
                                    }
                                }
                    
                                updateCountdown();
                                const interval = setInterval(updateCountdown, 1000);
                            });
                        });
                    </script>
                                                   
                </div>
            </div>
        </div>
    </div>

  
    <div id="deleteConfirmationModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <h3 class="text-lg font-semibold mb-4">Are you sure you want to delete this reservation?</h3>
            <button id="confirmDeleteButton" class="bg-red-500 text-white font-bold py-2 px-4 rounded">Yes</button>
            <button onclick="closeDeleteModal()" class="bg-gray-300 text-black font-bold py-2 px-4 rounded">No</button>
        </div>
    </div>

    <div id="banModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <h3 class="text-lg font-semibold mb-4">Ban User</h3>
            <input type="number" id="banDuration" placeholder="Duration in minutes" class="border p-2 w-full mb-4" />
            <textarea id="banReason" placeholder="Reason for ban" class="border p-2 w-full mb-4"></textarea>
            <button id="confirmBanButton" class="bg-red-500 text-white font-bold py-2 px-4 rounded">Ban</button>
            <button onclick="closeBanModal()" class="bg-gray-300 text-black font-bold py-2 px-4 rounded">Cancel</button>
        </div>
    </div>
    

    <script>
        let reservationIdToDelete;
    
        function confirmDelete(reservationId) {
            reservationIdToDelete = reservationId;
            document.getElementById('deleteConfirmationModal').classList.remove('hidden');
        }
    
        function closeDeleteModal() {
            document.getElementById('deleteConfirmationModal').classList.add('hidden');
        }
    
        document.getElementById('confirmDeleteButton').addEventListener('click', function() {
            fetch(`/reservations/${reservationIdToDelete}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => {
                if (response.ok) {
                    alert('Reservation deleted successfully.');
                    location.reload(); 
                } else {
                    alert('Failed to delete reservation. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error deleting reservation:', error);
                alert('An error occurred. Please try again later.');
            });
    
            closeDeleteModal();
        });

        let userIdToBan;

        function openBanModal(userId) {
            userIdToBan = userId;
            document.getElementById('banModal').classList.remove('hidden');
        }

        function closeBanModal() {
            document.getElementById('banModal').classList.add('hidden');
        }

        document.getElementById('confirmBanButton').addEventListener('click', function() {
            const duration = document.getElementById('banDuration').value;
            const reason = document.getElementById('banReason').value;

            fetch(`/ban-user/${userIdToBan}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ duration, reason }),
            })
            .then(response => {
                if (response.ok) {
                    alert('User banned successfully.');
                    location.reload();
                } else {
                    alert('Failed to ban user. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error banning user:', error);
                alert('An error occurred. Please try again later.');
            });

            closeBanModal();
        });

        function unbanUser(userId) {
            if (confirm('Are you sure you want to unban this user?')) {
                fetch(`/unban-user/${userId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    if (response.ok) {
                        alert('User unbanned successfully.');
                        location.reload(); 
                    } else {
                        alert('Failed to unban user. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error unbanning user:', error);
                    alert('An error occurred. Please try again later.');
                });
            }
        }


    </script>
</x-app-layout>
