<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
            {{ __('messages.purchase_orders') }}
        </h2>
            <a href="{{ route('purchases.orders.create') }}" class="btn-premium">
                + {{ __('messages.create_po') }}
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
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ __('messages.recent_purchase_orders') }}</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse data-table">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-900/30 text-slate-500 dark:text-text-muted text-sm uppercase tracking-wider">
                                <th class="p-4 font-medium text-left">{{ __('messages.po_number') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.date') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.supplier') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.total_amount') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.status') }}</th>
                                <th class="p-4 font-medium text-right">{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-200 dark:divide-slate-700/50">
                            @forelse($orders as $order)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="p-4 text-slate-900 dark:text-white font-mono text-left">{{ $order->order_number }}</td>
                                <td class="p-4 text-slate-500 dark:text-text-muted text-left">{{ $order->order_date->format('M d, Y') }}</td>
                                <td class="p-4 text-slate-900 dark:text-white font-medium text-left">{{ $order->supplier->name ?? 'Unknown' }}</td>
                                <td class="p-4 text-left font-bold text-slate-900 dark:text-white">${{ number_format($order->total_amount, 2) }}</td>
                                <td class="p-4 text-left">
                                    @if($order->status == 'received')
                                        <span class="bg-green-500/20 text-green-400 py-1 px-3 rounded-full text-xs font-medium uppercase">{{ $order->status }}</span>
                                    @elseif($order->status == 'ordered')
                                        <span class="bg-blue-500/20 text-blue-400 py-1 px-3 rounded-full text-xs font-medium uppercase">{{ $order->status }}</span>
                                    @else
                                        <span class="bg-slate-500/20 text-slate-400 py-1 px-3 rounded-full text-xs font-medium uppercase">{{ $order->status }}</span>
                                    @endif
                                </td>
                                <td class="p-4 text-right">
                                    <div class="flex gap-2 justify-end">
                                        <a href="#" class="text-brand-primary hover:text-brand-accent transition-colors text-xs font-medium border border-brand-primary/30 px-2 py-1 rounded">{{ __('messages.view') }}</a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-500 dark:text-text-muted">
                                    {{ __('messages.no_purchase_orders') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="p-4 border-t border-slate-700/50">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>