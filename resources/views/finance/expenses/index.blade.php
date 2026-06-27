<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
            {{ __('messages.expenses') }}
        </h2>
            <a href="{{ route('finance.expenses.create') }}" class="btn-premium">
                + {{ __('messages.log_expense') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-500/20 border border-green-500 text-green-400 px-4 py-3 rounded-xl relative" role="alert">
                    <strong class="font-bold">{{ __('messages.success') }}</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="glass-card p-6 flex items-center justify-between animate-fade-in-up" style="animation-delay: 0.1s">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400 font-medium uppercase tracking-wider mb-1">{{ __('messages.this_months_expenses') }}</p>
                        <h4 class="text-3xl font-bold text-slate-900 dark:text-white">${{ number_format($thisMonthExpenses, 2) }}</h4>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-red-500/20 flex items-center justify-center text-red-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                    </div>
                </div>
                
                <div class="glass-card p-6 flex items-center justify-between animate-fade-in-up" style="animation-delay: 0.2s">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400 font-medium uppercase tracking-wider mb-1">{{ __('messages.total_expenses_all_time') }}</p>
                        <h4 class="text-3xl font-bold text-slate-900 dark:text-white">${{ number_format($totalExpenses, 2) }}</h4>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-brand-primary/20 flex items-center justify-center text-brand-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="glass-card overflow-hidden animate-fade-in-up" style="animation-delay: 0.3s">
                <div class="p-4 sm:p-6 border-b border-slate-200 dark:border-slate-700/50 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ __('messages.expense_history') }}</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse data-table">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-900/30 text-slate-500 dark:text-text-muted text-sm uppercase tracking-wider">
                                <th class="p-4 font-medium text-left">{{ __('messages.date') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.category_single') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.amount') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.reference') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.description') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-200 dark:divide-slate-700/50">
                            @forelse($expenses as $expense)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="p-4 text-slate-500 dark:text-text-muted text-left">{{ $expense->expense_date->format('M d, Y') }}</td>
                                <td class="p-4 text-slate-900 dark:text-white font-medium text-left">{{ $expense->category }}</td>
                                <td class="p-4 text-left font-bold text-red-500">
                                    -${{ number_format($expense->amount, 2) }}
                                </td>
                                <td class="p-4 text-slate-500 dark:text-text-muted text-left">{{ $expense->reference ?? '-' }}</td>
                                <td class="p-4 text-slate-500 dark:text-text-muted text-left">{{ Str::limit($expense->description, 30) ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-slate-500 dark:text-text-muted">
                                    {{ __('messages.no_expenses_recorded') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="p-4 border-t border-slate-700/50">
                    {{ $expenses->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>