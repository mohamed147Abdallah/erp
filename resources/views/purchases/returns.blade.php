<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
            {{ __('messages.purchase_returns') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card p-12 text-center animate-fade-in-up">
                <div class="text-6xl mb-4">🔙</div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">{{ __('messages.no_returns_yet') }}</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-6">{{ __('messages.purchase_returns_upcoming') }}</p>
                <a href="{{ route('purchases.orders.index') }}" class="btn-premium px-6 py-2 rounded-xl">{{ __('messages.back_to_purchase_orders') }}</a>
            </div>
        </div>
    </div>
</x-app-layout>