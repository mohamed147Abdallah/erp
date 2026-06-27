<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
            {{ __('messages.inventory_overview') }}
        </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card overflow-hidden animate-fade-in-up">
                <div class="p-4 sm:p-6 border-b border-slate-200 dark:border-slate-700/50 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ __('messages.current_stock_levels') }}</h3>
                    
                    <div class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto">
                        <input type="text" placeholder="{{ __('messages.search') }} {{ __('messages.by_sku_or_name') }}" class="input-premium w-full sm:w-64 !py-2 !px-3 !text-sm">
                        <button class="btn-premium !py-2 !px-4 !rounded-xl">{{ __('messages.search_btn') }}</button>
                        
                        <a href="{{ route('inventory.movements.create') }}" class="btn-premium !py-2 !px-4 !rounded-xl !bg-indigo-600 hover:!bg-indigo-700 !border-none flex justify-center items-center gap-1 shadow-md shadow-indigo-500/20 w-full sm:w-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            {{ __('messages.add_stock') }}
                        </a>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse data-table">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-900/30 text-slate-500 dark:text-text-muted text-sm uppercase tracking-wider">
                                <th class="p-4 font-medium text-left">{{ __('messages.sku') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.product_name') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.category_single') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.stock_quantity') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.status_indicator') }}</th>
                                <th class="p-4 font-medium text-right">{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-200 dark:divide-slate-700/50">
                            @forelse($products as $product)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="p-4 text-slate-500 dark:text-text-muted text-left font-mono">{{ $product->sku }}</td>
                                <td class="p-4 text-slate-900 dark:text-white font-medium text-left">{{ $product->name }}</td>
                                <td class="p-4 text-slate-500 dark:text-text-muted text-left">{{ $product->category->name ?? '-' }}</td>
                                <td class="p-4 text-left">
                                    <span class="font-bold text-lg {{ $product->stock_quantity <= 5 ? 'text-red-500' : 'text-slate-700 dark:text-slate-300' }}">
                                        {{ $product->stock_quantity }}
                                    </span>
                                </td>
                                <td class="p-4 text-left">
                                    @if($product->stock_quantity <= 0)
                                        <span class="bg-red-500/20 text-red-400 py-1 px-3 rounded-full text-xs font-medium">{{ __('messages.out_of_stock') }}</span>
                                    @elseif($product->stock_quantity <= 5)
                                        <span class="bg-amber-500/20 text-amber-500 py-1 px-3 rounded-full text-xs font-medium">{{ __('messages.low_stock') }}</span>
                                    @else
                                        <span class="bg-green-500/20 text-green-400 py-1 px-3 rounded-full text-xs font-medium">{{ __('messages.in_stock') }}</span>
                                    @endif
                                </td>
                                <td class="p-4 text-right">
                                    <div class="flex gap-2 justify-end">
                                        <a href="{{ route('inventory.adjustments.create', ['product_id' => $product->id]) }}" class="text-brand-primary hover:text-brand-accent transition-colors text-xs font-medium border border-brand-primary/30 px-2 py-1 rounded">{{ __('messages.adjust_stock') }}</a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-500 dark:text-text-muted">
                                    {{ __('messages.no_products_found') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="p-4 border-t border-slate-700/50">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
