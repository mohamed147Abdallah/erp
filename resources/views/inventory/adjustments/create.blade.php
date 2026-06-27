<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
            {{ __('messages.new_adjustment') }}
        </h2>
            <a href="{{ route('inventory.adjustments.index') }}" class="text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300 transition-colors">
                &larr; {{ __('messages.back_to_history') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card p-8 animate-fade-in-up">
                
                @if ($errors->any())
                    <div class="mb-6 bg-red-500/20 border border-red-500 text-red-400 px-4 py-3 rounded-xl">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-6 bg-blue-500/10 border border-blue-500/20 text-blue-600 dark:text-blue-400 px-4 py-3 rounded-xl">
                    <p class="text-sm">{!! __('messages.adjustment_instructions') !!}</p>
                </div>

                <form action="{{ route('inventory.adjustments.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.product_star') }}</label>
                            <select name="product_id" class="input-premium" required>
                                <option value="">{{ __('messages.select_product') }}</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ (old('product_id') ?? $selectedProductId) == $product->id ? 'selected' : '' }}>
                                        [{{ $product->sku }}] {{ $product->name }} (Current Stock: {{ $product->stock_quantity }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.adjusted_quantity_star') }}</label>
                            <input type="number" name="adjusted_quantity" value="{{ old('adjusted_quantity') }}" placeholder="{{ __('messages.eg_adjusted_quantity') }}" class="input-premium" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.reason_for_adjustment_star') }}</label>
                            <input type="text" name="reason" value="{{ old('reason') }}" placeholder="{{ __('messages.eg_reason') }}" class="input-premium" required>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-slate-200 dark:border-slate-700/50">
                        <button type="submit" class="btn-premium bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-6 rounded-xl shadow-lg transition-all duration-300">
                            {{ __('messages.apply_adjustment') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
