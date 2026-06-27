<header class="h-16 flex items-center justify-between px-4 md:px-6 bg-white/80 dark:bg-[#0c0f1a]/80 backdrop-blur-xl border-b border-slate-200/80 dark:border-slate-800/60 z-10 shrink-0 transition-colors duration-300">
    <div class="flex items-center gap-4 flex-1 min-w-0">
        <!-- Mobile Menu Button -->
        <button onclick="toggleSidebar()" class="md:hidden text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white focus:outline-none shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>

        <!-- Global Search Bar -->
        <form action="{{ route('search.index') }}" method="GET" class="hidden md:flex relative w-72 lg:w-96 flex-1 max-w-lg">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" name="q" placeholder="{{ __('messages.search_placeholder') }}"
                value="{{ request('q') }}"
                class="w-full bg-slate-100/80 dark:bg-slate-800/60 border border-transparent dark:border-slate-700/50 rounded-xl pl-10 pr-4 py-2 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-800 placeholder-slate-400 dark:placeholder-slate-500 transition-all duration-200">
        </form>
    </div>

    <div class="flex items-center gap-1 md:gap-2 shrink-0 ml-4">
        <!-- Language Switcher -->
        <a href="{{ route('lang.switch', app()->getLocale() == 'en' ? 'ar' : 'en') }}"
            class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50"
            title="{{ app()->getLocale() == 'en' ? 'العربية' : 'English' }}">
            <span class="text-sm font-semibold uppercase">{{ app()->getLocale() == 'en' ? 'AR' : 'EN' }}</span>
        </a>

        <!-- Theme Toggle -->
        <button id="theme-toggle" title="{{ __('messages.dark_mode') }}"
            class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
            <svg id="theme-toggle-dark-icon" class="hidden w-4.5 h-4.5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
            <svg id="theme-toggle-light-icon" class="hidden w-4.5 h-4.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
        </button>

        <!-- Notifications -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-200 relative focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                @if(Auth::user()->unreadNotifications->count() > 0)
                    <span class="absolute top-1.5 right-1.5 block h-2 w-2 rounded-full bg-indigo-500 ring-2 ring-white dark:ring-[#0c0f1a] animate-pulse"></span>
                @endif
            </button>

            <div x-show="open" @click.away="open = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 mt-2 w-80 bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700/80 z-50 overflow-hidden">
                <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white">{{ __('messages.notifications') }}</h3>
                    <span class="badge badge-info text-[10px]">{{ Auth::user()->unreadNotifications->count() }} new</span>
                </div>
                <div class="max-h-80 overflow-y-auto divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse(Auth::user()->unreadNotifications as $notification)
                        <div class="px-4 py-3 hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors">
                            <p class="text-sm font-medium text-slate-800 dark:text-white">{{ $notification->data['title'] ?? 'Notification' }}</p>
                            <p class="text-xs text-slate-500 mt-0.5 line-clamp-2">{{ $notification->data['message'] ?? '' }}</p>
                            <span class="text-[10px] text-slate-400 mt-1 block">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <div class="px-4 py-8 text-center">
                            <svg class="w-8 h-8 text-slate-300 dark:text-slate-700 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <p class="text-sm text-slate-500">You're all caught up!</p>
                        </div>
                    @endforelse
                </div>
                <div class="px-4 py-2.5 border-t border-slate-100 dark:border-slate-800 text-center">
                    <a href="#" class="text-xs text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-medium transition-colors">View all notifications</a>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="w-px h-6 bg-slate-200 dark:bg-slate-800 mx-1"></div>

        <!-- Profile Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center gap-2.5 focus:outline-none p-1 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-white text-sm font-bold shadow-sm">
                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                </div>
                <div class="hidden md:block text-left">
                    <p class="text-sm font-semibold text-slate-800 dark:text-white leading-tight">{{ Auth::user()->name ?? 'User' }}</p>
                    <p class="text-[10px] text-slate-500 leading-tight">{{ __('messages.administrator') }}</p>
                </div>
                <svg class="w-3.5 h-3.5 text-slate-400 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <div x-show="open" @click.away="open = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 mt-2 w-52 bg-white dark:bg-slate-900 rounded-2xl shadow-xl py-2 border border-slate-200 dark:border-slate-700/80 z-50 overflow-hidden">
                <div class="px-4 py-2 border-b border-slate-100 dark:border-slate-800 mb-1">
                    <p class="text-xs font-semibold text-slate-800 dark:text-white">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-slate-500 truncate">{{ Auth::user()->email }}</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    {{ __('messages.profile') }}
                </a>
                <a href="{{ route('settings.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ __('messages.settings') }}
                </a>
                <div class="border-t border-slate-100 dark:border-slate-800 mt-1 pt-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2.5 w-full px-4 py-2 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 hover:text-red-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            {{ __('messages.logout') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
