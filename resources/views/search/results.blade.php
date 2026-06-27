<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
            {{ __('{{ __('messages.search_results') }} for: ') }} "{{ $query }}"
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 animate-fade-in-up">
            
            @if(empty($query))
                <div class="glass-card p-12 text-center text-slate-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <h3 class="text-xl font-medium text-slate-900 dark:text-white mb-2">Start Searching</h3>
                    <p>Enter a query above to search across the entire ERP system.</p>
                </div>
            @else
                
                @php
                    $totalResults = count($products) + count($customers) + count($suppliers) + count($invoices) + count($purchaseOrders);
                @endphp

                @if($totalResults === 0)
                    <div class="glass-card p-12 text-center text-slate-500">
                        <svg class="w-16 h-16 mx-auto mb-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="text-xl font-medium text-slate-900 dark:text-white mb-2">No Results Found</h3>
                        <p>We couldn't find anything matching "{{ $query }}".</p>
                    </div>
                @else
                    
                    @if(count($products) > 0)
                    <div class="glass-card p-6">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 border-b border-slate-200 dark:border-slate-700 pb-2">Products ({{ count($products) }})</h3>
                        <ul class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach($products as $product)
                            <li class="py-3 flex justify-between items-center hover:bg-slate-50 dark:hover:bg-slate-800/50 rounded-lg px-2 transition-colors">
                                <div>
                                    <p class="font-medium text-slate-900 dark:text-white">{{ $product->name }}</p>
                                    <p class="text-sm text-slate-500">SKU: {{ $product->sku }} | Price: ${{ number_format($product->price, 2) }}</p>
                                </div>
                                <a href="{{ route('products.edit', $product) }}" class="btn-premium text-xs py-1 px-3">{{ __('messages.view') }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(count($customers) > 0)
                    <div class="glass-card p-6">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 border-b border-slate-200 dark:border-slate-700 pb-2">Customers ({{ count($customers) }})</h3>
                        <ul class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach($customers as $customer)
                            <li class="py-3 flex justify-between items-center hover:bg-slate-50 dark:hover:bg-slate-800/50 rounded-lg px-2 transition-colors">
                                <div>
                                    <p class="font-medium text-slate-900 dark:text-white">{{ $customer->name }}</p>
                                    <p class="text-sm text-slate-500">{{ $customer->email }} | {{ $customer->company }}</p>
                                </div>
                                <a href="{{ route('customers.edit', $customer) }}" class="btn-premium text-xs py-1 px-3">{{ __('messages.view') }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(count($suppliers) > 0)
                    <div class="glass-card p-6">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 border-b border-slate-200 dark:border-slate-700 pb-2">Suppliers ({{ count($suppliers) }})</h3>
                        <ul class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach($suppliers as $supplier)
                            <li class="py-3 flex justify-between items-center hover:bg-slate-50 dark:hover:bg-slate-800/50 rounded-lg px-2 transition-colors">
                                <div>
                                    <p class="font-medium text-slate-900 dark:text-white">{{ $supplier->name }}</p>
                                    <p class="text-sm text-slate-500">{{ $supplier->email }} | {{ $supplier->company }}</p>
                                </div>
                                <a href="{{ route('suppliers.edit', $supplier) }}" class="btn-premium text-xs py-1 px-3">{{ __('messages.view') }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(count($invoices) > 0)
                    <div class="glass-card p-6">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 border-b border-slate-200 dark:border-slate-700 pb-2">Invoices ({{ count($invoices) }})</h3>
                        <ul class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach($invoices as $invoice)
                            <li class="py-3 flex justify-between items-center hover:bg-slate-50 dark:hover:bg-slate-800/50 rounded-lg px-2 transition-colors">
                                <div>
                                    <p class="font-medium text-slate-900 dark:text-white">{{ $invoice->invoice_number }}</p>
                                    <p class="text-sm text-slate-500">Total: ${{ number_format($invoice->total_amount, 2) }} | Status: {{ $invoice->status }}</p>
                                </div>
                                <a href="{{ route('sales.invoices.show', $invoice) }}" class="btn-premium text-xs py-1 px-3">{{ __('messages.view') }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(count($purchaseOrders) > 0)
                    <div class="glass-card p-6">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 border-b border-slate-200 dark:border-slate-700 pb-2">Purchase Orders ({{ count($purchaseOrders) }})</h3>
                        <ul class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach($purchaseOrders as $po)
                            <li class="py-3 flex justify-between items-center hover:bg-slate-50 dark:hover:bg-slate-800/50 rounded-lg px-2 transition-colors">
                                <div>
                                    <p class="font-medium text-slate-900 dark:text-white">{{ $po->order_number }}</p>
                                    <p class="text-sm text-slate-500">Total: ${{ number_format($po->total_amount, 2) }} | Status: {{ $po->status }}</p>
                                </div>
                                <a href="{{ route('purchases.orders.show', $po) }}" class="btn-premium text-xs py-1 px-3">{{ __('messages.view') }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                @endif
            @endif
            
        </div>
    </div>
</x-app-layout>
