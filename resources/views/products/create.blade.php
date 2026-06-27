<x-app-layout>
    <div class="animate-fade-in-up">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <div class="breadcrumb">
                    <a href="{{ route('products.index') }}">{{ __('messages.products') }}</a>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span>{{ __('messages.add_new') }}</span>
                </div>
                <h1 class="page-title mt-1">{{ __('messages.add_product') }}</h1>
            </div>
            <a href="{{ route('products.index') }}" class="btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                {{ __('messages.back_to_list') }}
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mb-6">
                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Main Info -->
                <div class="lg:col-span-2 space-y-5">
                    <div class="form-card">
                        <h3 class="form-section-title mb-5">{{ __('messages.basic_information') }}</h3>
                        <div class="form-section space-y-5">
                            <div class="form-group">
                                <label class="form-label form-label-required">{{ __('messages.product_name') }}</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="input-premium @error('name') input-error @enderror"
                                    placeholder="{{ __('messages.eg_macbook') }}" required>
                            </div>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label form-label-required">{{ __('messages.sku') }}</label>
                                    <input type="text" name="sku" value="{{ old('sku') }}"
                                        class="input-premium font-mono @error('sku') input-error @enderror"
                                        placeholder="{{ __('messages.eg_sku') }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ __('messages.barcode') }}</label>
                                    <input type="text" name="barcode" value="{{ old('barcode') }}"
                                        class="input-premium font-mono @error('barcode') input-error @enderror"
                                        placeholder="{{ __('messages.eg_barcode') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label form-label-required">{{ __('messages.category_single') }}</label>
                                <select name="category_id" class="input-premium @error('category_id') input-error @enderror" required>
                                    <option value="">{{ __('messages.select_category_placeholder') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">{{ __('messages.description') }}</label>
                                <textarea name="description" rows="4"
                                    class="textarea-premium @error('description') input-error @enderror"
                                    placeholder="{{ __('messages.describe_product') }}">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing -->
                    <div class="form-card">
                        <h3 class="form-section-title mb-5">{{ __('messages.pricing') }}</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label form-label-required">{{ __('messages.selling_price') }}</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <span class="text-slate-400 text-sm font-medium">$</span>
                                    </div>
                                    <input type="number" step="0.01" name="price" value="{{ old('price') }}"
                                        class="input-premium pl-8 @error('price') input-error @enderror"
                                        placeholder="0.00" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">{{ __('messages.cost_price_label') }}</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <span class="text-slate-400 text-sm font-medium">$</span>
                                    </div>
                                    <input type="number" step="0.01" name="cost" value="{{ old('cost') }}"
                                        class="input-premium pl-8 @error('cost') input-error @enderror"
                                        placeholder="0.00">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stock -->
                    <div class="form-card">
                        <h3 class="form-section-title mb-5">{{ __('messages.inventory') }}</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label form-label-required">{{ __('messages.initial_stock_quantity') }}</label>
                                <input type="number" name="stock_quantity" value="{{ old('stock_quantity', 0) }}"
                                    class="input-premium @error('stock_quantity') input-error @enderror"
                                    min="0" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">{{ __('messages.minimum_stock_alert') }}</label>
                                <input type="number" name="minimum_stock" value="{{ old('minimum_stock', 0) }}"
                                    class="input-premium @error('minimum_stock') input-error @enderror"
                                    min="0">
                                <p class="text-xs text-slate-400 mt-1.5">{{ __('messages.alert_triggers_when_stock_drops') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-5">
                    <!-- Status -->
                    <div class="form-card">
                        <h3 class="form-section-title mb-5">{{ __('messages.status_visibility') }}</h3>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" name="is_active" id="is_active"
                                    class="sr-only peer"
                                    {{ old('is_active', true) ? 'checked' : '' }}>
                                <div class="w-10 h-6 bg-slate-200 dark:bg-slate-700 rounded-full peer peer-checked:bg-indigo-600 transition-colors duration-200"></div>
                                <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow peer-checked:translate-x-4 transition-transform duration-200"></div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ __('messages.active_product') }}</p>
                                <p class="text-xs text-slate-500">{{ __('messages.visible_in_catalog') }}</p>
                            </div>
                        </label>
                    </div>

                    <!-- Product Image -->
                    <div class="form-card">
                        <h3 class="form-section-title mb-5">{{ __('messages.product_image') }}</h3>
                        <label class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-xl cursor-pointer hover:border-indigo-400 dark:hover:border-indigo-500 hover:bg-indigo-50/50 dark:hover:bg-indigo-500/5 transition-all duration-200 group">
                            <div class="text-center">
                                <svg class="w-8 h-8 text-slate-400 group-hover:text-indigo-500 mx-auto mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="text-xs text-slate-500 group-hover:text-indigo-500 transition-colors">{{ __('messages.click_to_upload') }}</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">{{ __('messages.image_format_size') }}</p>
                            </div>
                            <input type="file" name="image" class="hidden" accept="image/*">
                        </label>
                    </div>

                    <!-- Save Button -->
                    <div class="form-card">
                        <button type="submit" class="btn-premium w-full justify-center py-3 text-base">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            {{ __('messages.save') }}
                        </button>
                        <a href="{{ route('products.index') }}" class="btn-secondary w-full justify-center mt-2">
                            {{ __('messages.cancel') }}
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
