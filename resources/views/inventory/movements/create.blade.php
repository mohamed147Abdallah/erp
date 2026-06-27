<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
            {{ __('messages.record_stock_movement') }}
        </h2>
            <a href="{{ route('inventory.movements.index') }}" class="text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300 transition-colors">
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

                <form action="{{ route('inventory.movements.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.product_star') }}</label>
                            <select name="product_id" class="input-premium" required>
                                <option value="">{{ __('messages.select_product') }}</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        [{{ $product->sku }}] {{ $product->name }} (Current Stock: {{ $product->stock_quantity }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.movement_type') }} *</label>
                            <select name="type" class="input-premium" required>
                                <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>{{ __('messages.stock_in') }}</option>
                                <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>{{ __('messages.stock_out') }}</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.quantity_star') }}</label>
                            <input type="number" name="quantity" min="1" value="{{ old('quantity') }}" class="input-premium" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.reference_number') }}</label>
                            <input type="text" name="reference" value="{{ old('reference') }}" placeholder="{{ __('messages.eg_reference') }}" class="input-premium">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.notes') }}</label>
                            <textarea name="notes" rows="3" class="input-premium">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-slate-200 dark:border-slate-700/50">
                        <button type="submit" class="btn-premium bg-brand-primary hover:bg-brand-accent text-white font-bold py-2 px-6 rounded-xl shadow-lg hover:shadow-brand-primary/50 transition-all duration-300 transform hover:-translate-y-0.5">
                            {{ __('messages.record_movement') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
