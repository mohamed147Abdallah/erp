<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
            {{ __('messages.data_import_hub') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-500/20 border border-green-500 text-green-400 px-4 py-3 rounded-xl relative" role="alert">
                    <strong class="font-bold">{{ __('messages.success') }}</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            @if($errors->any())
                <div class="mb-6 bg-red-500/20 border border-red-500 text-red-400 px-4 py-3 rounded-xl relative" role="alert">
                    <strong class="font-bold">{{ __('messages.error') }}</strong>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="glass-card p-8 animate-fade-in-up">
                <p class="text-slate-500 dark:text-slate-400 mb-8 text-center text-lg">{{ __('messages.mass_import_description') }}</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 border-b border-slate-200 dark:border-slate-700/50 pb-8">
                    <div class="bg-slate-50 dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-700/50 flex flex-col items-center text-center hover:border-brand-primary transition-colors group">
                        <div class="w-12 h-12 bg-blue-500/10 text-blue-500 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <h4 class="font-bold text-slate-900 dark:text-white mb-2">{{ __('messages.products') }}</h4>
                        <div class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto">
                            <a href="{{ route('imports.template', 'products') }}" class="text-sm text-brand-primary hover:underline">{{ __('messages.download_csv') }}</a>
                            <a href="{{ route('data-import.export') }}" class="text-sm text-brand-primary hover:underline ml-2 border-l pl-2 border-slate-300">{{ __('messages.export_excel') }}</a>
                        </div>
                    </div>
                    
                    <div class="bg-slate-50 dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-700/50 flex flex-col items-center text-center hover:border-brand-primary transition-colors group">
                        <div class="w-12 h-12 bg-green-500/10 text-green-500 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h4 class="font-bold text-slate-900 dark:text-white mb-2">{{ __('messages.customers') }}</h4>
                        <a href="{{ route('imports.template', 'customers') }}" class="text-sm text-brand-primary hover:underline">{{ __('messages.download_template') }}</a>
                    </div>

                    <div class="bg-slate-50 dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-700/50 flex flex-col items-center text-center hover:border-brand-primary transition-colors group">
                        <div class="w-12 h-12 bg-orange-500/10 text-orange-500 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h4 class="font-bold text-slate-900 dark:text-white mb-2">{{ __('messages.suppliers') }}</h4>
                        <a href="{{ route('imports.template', 'suppliers') }}" class="text-sm text-brand-primary hover:underline">{{ __('messages.download_template') }}</a>
                    </div>
                </div>

                <form action="{{ route('imports.process') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.select_data_type') }}</label>
                        <select name="import_type" class="input-premium" required>
                            <option value="">{{ __('messages.select_what_to_import') }}</option>
                            <option value="products">{{ __('messages.products_inventory') }}</option>
                            <option value="customers">{{ __('messages.customers') }}</option>
                            <option value="suppliers">{{ __('messages.suppliers') }}</option>
                        </select>
                    </div>

                    <div class="mb-8">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.upload_file') }}</label>
                        <div class="flex items-center justify-center w-full">
                            <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 dark:bg-slate-800/50 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors dark:border-slate-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-10 h-10 mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <p class="mb-2 text-sm text-slate-500 dark:text-slate-400"><span class="font-semibold">{{ __('messages.click_to_upload') }}</span> {{ __('messages.drag_and_drop') }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('messages.file_constraints') }}</p>
                                </div>
                                <input type="file" name="import_file" class="hidden" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required />
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-slate-200 dark:border-slate-700/50">
                        <button type="submit" class="btn-premium bg-brand-primary hover:bg-brand-accent text-white font-bold py-2 px-8 rounded-xl shadow-lg transition-all duration-300">
                            {{ __('messages.process_import') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
