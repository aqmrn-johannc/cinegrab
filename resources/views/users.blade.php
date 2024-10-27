<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <h2 class="text-2xl font-bold mb-6 text-white">Registered Users</h2>
            <div class="text-gray-900 dark:text-gray-100 mb-4">
                Total: {{ $totalUsers }}
            </div>


            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Date Registered</th>
                                <th>Ban Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        @if($user->banned_until && now()->isBefore($user->banned_until))
                                            <span class="countdown" data-banned-until="{{ $user->banned_until->toIso8601String() }}">
                                                {{ \Carbon\Carbon::parse($user->banned_until)->diffInSeconds(now()) }} seconds remaining
                                            </span>
                                        @else
                                            Not Banned
                                        @endif
                                    </td>
                                    <td>
                                        <button onclick="openBanModal({{ $user->id }})" class="bg-yellow-500 text-white py-1 px-3 rounded">Ban User</button>
                                        <button onclick="unbanUser({{ $user->id }})" class="bg-green-500 text-white py-1 px-3 rounded ml-2">Unban User</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
