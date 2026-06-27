<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
            {{ __('messages.system_permissions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card overflow-hidden animate-fade-in-up">
                <div class="p-6 border-b border-slate-200 dark:border-slate-700/50">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">{{ __('messages.available_permissions') }}</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('messages.permissions_description') }}</p>
                </div>
                
                <div class="p-6 grid grid-cols-2 md:grid-cols-4 gap-4 bg-slate-50 dark:bg-slate-900/30">
                    @forelse($permissions as $permission)
                        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-4 rounded-xl shadow-sm flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-brand-primary/10 flex items-center justify-center text-brand-primary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                            </div>
                            <span class="text-slate-700 dark:text-slate-300 font-medium text-sm">{{ $permission->name }}</span>
                        </div>
                    @empty
                        <div class="col-span-full p-8 text-center text-slate-500 dark:text-text-muted">
                            <p class="mb-4">{{ __('messages.no_permissions_seeded') }}</p>
                            <code class="bg-slate-200 dark:bg-slate-800 p-2 rounded text-xs">php artisan db:seed --class=PermissionSeeder</code>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
