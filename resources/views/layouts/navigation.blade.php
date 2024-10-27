<nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 sticky top-0 z-10 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::check() && Auth::user()->is_admin ? route('admin.dashboard') : route('dashboard') }}">
                        <img src="{{ asset('images/cinegrablogo.png') }}" style="width:200px; height: auto; margin-top:10px;" />
                    </a>                    
                </div>
            </div>

            <div class="flex items-center">
                @if(Auth::check())
                <!-- User Notifications Icon -->
                @if(!Auth::user()->is_admin)
                <div class="relative mr-4">
                    <button id="user-notification-button" class="flex items-center">
                        <img src="{{ asset('images/bell.png') }}" alt="Notifications" class="h-6 w-6 hover:opacity-75">
                        <span id="user-notification-count" class="absolute top-0 right-0 -mr-1 -mt-1 bg-red-500 text-white rounded-full px-1 text-xs {{ auth()->user()->unreadNotifications->count() == 0 ? 'hidden' : '' }}">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>                            
                    </button>
                    <div id="user-notification-dropdown" class="absolute right-0 w-72 mt-2 bg-white dark:bg-gray-800 rounded-md shadow-lg hidden">
                        <div id="user-notification-list" class="py-2">
                            @if(auth()->user()->notifications->isEmpty())
                                <div class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300">
                                    You have no notifications.
                                </div>
                            @else
                                @foreach(auth()->user()->notifications as $notification)
                                    <div class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300">
                                        Your reservation for <strong>{{ $notification->data['movie_title'] }}</strong> (Seat ID: <strong>{{ $notification->data['seat_number'] }}</strong>) has been <strong>{{ $notification->data['status'] }}</strong>.
                                        <span class="text-gray-500 text-xs"> {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>                                     
                </div>
                @endif

                <!-- Notifications Icon for Admin -->
                @if(Auth::user()->is_admin)
                    @if(Auth::check() && Auth::user()->is_admin)
                    <div class="relative mr-4">
                        <button id="admin-notification-button" class="flex items-center">
                            <img src="{{ asset('images/bell.png') }}" alt="Notifications" class="h-6 w-6 hover:opacity-75">
                            <span id="admin-notification-count" class="absolute top-0 right-0 -mr-1 -mt-1 bg-red-500 text-white rounded-full px-1 text-xs {{ auth()->user()->unreadNotifications->count() == 0 ? 'hidden' : '' }}">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        </button>
                        <div id="admin-notification-dropdown" class="absolute right-0 w-72 mt-2 bg-white dark:bg-gray-800 rounded-md shadow-lg hidden">
                            <div id="admin-notification-list" class="py-2">
                                @if(auth()->user()->notifications->isEmpty())
                                    <div class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300">
                                        You have no notifications.
                                    </div>
                                @else
                                    @foreach(auth()->user()->notifications as $notification)
                                        <div class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300">
                                            {{ $notification->data['message'] }}
                                            <span class="text-gray-500 text-xs"> {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>                        
                    </div>
                    @endif
                @endif

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 px-4 py-2 border border-transparent leading-4 font-medium rounded-md transition ease-in-out duration-150">
                            {{ __('Login') }}
                        </a>
                        <a href="{{ route('register') }}" class="text-sm text-gray-700 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 px-4 py-2 border border-transparent leading-4 font-medium rounded-md transition ease-in-out duration-150">
                            {{ __('Register') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Admin notifications handling
        const adminNotificationButton = document.getElementById('admin-notification-button');
        const adminNotificationDropdown = document.getElementById('admin-notification-dropdown');
        const adminNotificationCount = document.getElementById('admin-notification-count');

        // Show admin notification count
        @if(Auth::check() && Auth::user()->is_admin)
            const adminUnreadCount = @json(auth()->user()->unreadNotifications->count());
            if (adminUnreadCount > 0) {
                adminNotificationCount.textContent = adminUnreadCount;
            } else {
                adminNotificationCount.classList.add('hidden');
            }
        @endif

        // Toggle admin notification dropdown and mark as read
        adminNotificationButton?.addEventListener('click', () => {
            adminNotificationDropdown.classList.toggle('hidden');

            if (adminNotificationCount.textContent !== '') {
                fetch("{{ route('notifications.markAsRead') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        adminNotificationCount.classList.add('hidden');
                    }
                });
            }
        });

        // User notifications handling
        const userNotificationButton = document.getElementById('user-notification-button');
        const userNotificationDropdown = document.getElementById('user-notification-dropdown');
        const userNotificationCount = document.getElementById('user-notification-count');

        // Toggle user notification dropdown and mark as read
        userNotificationButton?.addEventListener('click', () => {
            userNotificationDropdown.classList.toggle('hidden');

            if (userNotificationCount.textContent !== '') {
                fetch("{{ route('notifications.markAsRead') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        userNotificationCount.classList.add('hidden');
                    }
                });
            }
        });

    });
</script>


