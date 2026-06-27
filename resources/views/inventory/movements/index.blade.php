<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
            {{ __('messages.stock_movements') }}
        </h2>
            <a href="{{ route('inventory.movements.create') }}" class="btn-premium">
                + {{ __('messages.record_movement') }}
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

            <div class="glass-card overflow-hidden animate-fade-in-up">
                <div class="p-4 sm:p-6 border-b border-slate-200 dark:border-slate-700/50 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ __('messages.movement_history') }}</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse data-table">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-900/30 text-slate-500 dark:text-text-muted text-sm uppercase tracking-wider">
                                <th class="p-4 font-medium text-left">{{ __('messages.date') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.reference') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.product') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.type') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.quantity') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.notes') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-200 dark:divide-slate-700/50">
                            @forelse($movements as $movement)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="p-4 text-slate-500 dark:text-text-muted text-left">{{ $movement->created_at->format('M d, Y H:i') }}</td>
                                <td class="p-4 text-slate-900 dark:text-white font-medium text-left">{{ $movement->reference ?? '-' }}</td>
                                <td class="p-4 text-slate-500 dark:text-text-muted text-left">{{ $movement->product->name ?? 'Unknown' }}</td>
                                <td class="p-4 text-left">
                                    @if($movement->type == 'in')
                                        <span class="bg-green-500/20 text-green-400 py-1 px-3 rounded-full text-xs font-medium">{{ __('messages.stock_in') }}</span>
                                    @else
                                        <span class="bg-red-500/20 text-red-400 py-1 px-3 rounded-full text-xs font-medium">{{ __('messages.stock_out') }}</span>
                                    @endif
                                </td>
                                <td class="p-4 text-left font-bold {{ $movement->type == 'in' ? 'text-green-500' : 'text-red-500' }}">
                                    {{ $movement->type == 'in' ? '+' : '-' }}{{ $movement->quantity }}
                                </td>
                                <td class="p-4 text-slate-500 dark:text-text-muted text-left">{{ Str::limit($movement->notes, 30) ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-500 dark:text-text-muted">
                                    {{ __('messages.no_stock_movements') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="p-4 border-t border-slate-700/50">
                    {{ $movements->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>