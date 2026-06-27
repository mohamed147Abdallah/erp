<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
                {{ __('{{ __('messages.edit_product') }}: ') }} {{ $product->name }}
            </h2>
            <a href="{{ route('products.index') }}" class="text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300 transition-colors">
                &larr; Back to List
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

                <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.product_name') }}</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="input-premium" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.sku') }}</label>
                            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="input-premium" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Selling Price</label>
                            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="input-premium" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Cost Price</label>
                            <input type="number" step="0.01" name="cost" value="{{ old('cost', $product->cost) }}" class="input-premium">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.stock_quantity') }}</label>
                            <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" class="input-premium" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Minimum Stock Alert</label>
                            <input type="number" name="minimum_stock" value="{{ old('minimum_stock', $product->minimum_stock) }}" class="input-premium">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.category_single') }}</label>
                            <select name="category_id" class="input-premium" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Product Image</label>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="h-10 w-10 object-cover rounded mb-2">
                            @endif
                            <input type="file" name="image" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-primary/10 file:text-brand-primary hover:file:bg-brand-primary/20">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.description') }}</label>
                            <textarea name="description" rows="3" class="input-premium">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="flex items-center mt-8">
                            <input type="checkbox" name="is_active" id="is_active" class="rounded border-slate-300 text-brand-primary shadow-sm focus:ring-brand-primary dark:bg-slate-800 dark:border-slate-600 h-5 w-5" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                            <label for="is_active" class="ml-2 block text-sm text-slate-700 dark:text-slate-300">
                                Active Product
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-slate-200 dark:border-slate-700/50">
                        <button type="submit" class="btn-premium">
                            Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
