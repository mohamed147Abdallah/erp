<x-app-layout>
    <div class="animate-fade-in-up">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">{{ __('messages.products') }}</h1>
                <p class="page-subtitle">{{ __('messages.manage_products') }}</p>
            </div>
            <a href="{{ route('products.create') }}" class="btn-premium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                {{ __('messages.add_product') }}
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-6">
                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Table Card -->
        <div class="glass-card overflow-hidden">
            <!-- Card Header -->
            <div class="p-5 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center gap-4">
                <div class="flex-1">
                    <h3 class="text-base font-semibold text-slate-900 dark:text-white">{{ __('messages.product_list') }}</h3>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $products->total() }} {{ __('messages.total_products') }}</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" placeholder="{{ __('messages.search_products') }}" class="input-premium pl-9 w-52">
                    </div>
                    <a href="{{ route('products.create') }}" class="btn-premium !py-2 !px-4 !rounded-xl !bg-indigo-600 hover:!bg-indigo-700 !border-none flex justify-center items-center gap-1 shadow-md shadow-indigo-500/20 w-full sm:w-auto">
                        + {{ __('messages.add_product') }}
                    </a>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>{{ __('messages.sku') }}</th>
                            <th>{{ __('messages.product') }}</th>
                            <th>{{ __('messages.category') }}</th>
                            <th>{{ __('messages.price') }}</th>
                            <th>{{ __('messages.stock') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th class="text-right">{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>
                                <code class="text-xs bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded-lg font-mono text-slate-600 dark:text-slate-300">{{ $product->sku }}</code>
                            </td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-500/10 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    </div>
                                    <span class="font-medium text-slate-900 dark:text-white">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td class="text-slate-500 dark:text-slate-400">{{ $product->category->name ?? '—' }}</td>
                            <td class="font-semibold text-slate-800 dark:text-slate-200">${{ number_format($product->price, 2) }}</td>
                            <td>
                                @if($product->stock_quantity <= ($product->minimum_stock ?? 5))
                                    <span class="badge badge-danger">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block"></span>
                                        {{ $product->stock_quantity }}
                                    </span>
                                @else
                                    <span class="badge badge-neutral">{{ $product->stock_quantity }}</span>
                                @endif
                            </td>
                            <td>
                                @if($product->is_active)
                                    <span class="badge badge-success">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                                        {{ __('messages.active') }}
                                    </span>
                                @else
                                    <span class="badge badge-danger">{{ __('messages.inactive') }}</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('products.edit', $product) }}" class="action-btn-edit">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        {{ __('messages.edit') }}
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('messages.delete') }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn-delete">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            {{ __('messages.delete') }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-0">
                                <div class="empty-state">
                                    <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    <p class="empty-state-title">{{ __('messages.no_products_yet') }}</p>
                                    <p class="empty-state-text">{{ __('messages.add_first_product') }}</p>
                                    <a href="{{ route('products.create') }}" class="btn-premium mt-4">{{ __('messages.add_product') }}</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
            <div class="p-4 border-t border-slate-200 dark:border-slate-800">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
