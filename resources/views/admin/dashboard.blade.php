<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold mb-6 text-white">Reservations</h2>
            <div class="text-gray-900 dark:text-gray-100 mb-4">
                Total: {{ $totalReservations }} <!-- Display total reservations -->
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-x1 font-medium text-gray-500 uppercase tracking-wider">Movie</th>
                                <th class="px-6 py-3 text-left text-x1 font-medium text-gray-500 uppercase tracking-wider">Seat Number</th>
                                <th class="px-6 py-3 text-left text-x1 font-medium text-gray-500 uppercase tracking-wider">Time Slot</th>
                                <th class="px-6 py-3 text-left text-x1 font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-x1 font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($reservations as $reservation)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->movie->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->seat_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->time_slot }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('reservations.edit', $reservation->id) }}" class="border border-yellow-600 bg-yellow-600 text-white font-bold py-2 px-4 rounded hover:bg-yellow-600">Edit</a>
                                        <button onclick="confirmDelete({{ $reservation->id }})" class="border border-red-500 bg-red-500 text-white font-bold py-2 px-4 rounded ml-4 hover:bg-red-600">Delete</button>
                                    </td>                                
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- New Users Table -->
            <h2 class="text-2xl font-bold mb-6 text-white">Registered Users</h2>
            <div class="text-gray-900 dark:text-gray-100 mb-4">
                Total: {{ $totalUsers }} <!-- Display total users -->
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-x1 font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-x1 font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-x1 font-medium text-gray-500 uppercase tracking-wider">Date Registered</th>
                                <th class="px-6 py-3 text-left text-x1 font-medium text-gray-500 uppercase tracking-wider">Ban Status</th> <!-- New column -->
                                <th class="px-6 py-3 text-left text-x1 font-medium text-gray-500 uppercase tracking-wider">Actions</th>
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
                                        <!-- Ban Button -->
                                        <button onclick="openBanModal({{ $user->id }})" class="bg-yellow-500 text-white py-1 px-3 rounded">Ban User</button>
                                    
                                        <!-- Unban Button -->
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
                                const bannedUntil = new Date(countdown.getAttribute('data-banned-until')).getTime();
                    
                                const updateCountdown = () => {
                                    const now = new Date().getTime();
                                    const distance = bannedUntil - now;
                    
                                    // Debugging logs
                                    console.log(`Now: ${now}, Banned Until: ${bannedUntil}, Distance: ${distance}`);
                    
                                    if (distance <= 0) {
                                        countdown.innerHTML = "Not Banned"; // Update the UI when the countdown ends
                                    } else {
                                        // Calculate remaining time
                                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    
                                        // Display the remaining time
                                        countdown.innerHTML = `${hours}h ${minutes}m ${seconds}s remaining`;
                                    }
                                };
                    
                                // Initial countdown update
                                updateCountdown();
                    
                                // Update countdown every second
                                const interval = setInterval(() => {
                                    const now = new Date().getTime();
                                    const distance = bannedUntil - now;
                    
                                    // Check if the time has expired
                                    if (distance <= 0) {
                                        clearInterval(interval);
                                        countdown.innerHTML = "Not Banned"; // Update the UI when the countdown ends
                                    } else {
                                        updateCountdown(); // Update the countdown display
                                    }
                                }, 1000);
                            });
                        });
                    </script>                                                         
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
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
                        location.reload(); // Reload the page to see the updated user status
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
