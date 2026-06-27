<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
            {{ __('messages.system_settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card p-8 animate-fade-in-up">
                
                @if(session('success'))
                    <div class="mb-6 bg-green-500/20 border border-green-500 text-green-400 px-4 py-3 rounded-xl relative" role="alert">
                        <strong class="font-bold">{{ __('messages.success') }}</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <form action="{{ route('settings.store') }}" method="POST">
                    @csrf
                    
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4 border-b border-slate-200 dark:border-slate-700/50 pb-2">{{ __('messages.general_settings') }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.company_name') }}</label>
                            <input type="text" name="company_name" value="{{ $settings['company_name'] ?? 'My ERP Company' }}" class="input-premium">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.contact_email') }}</label>
                            <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? 'contact@company.com' }}" class="input-premium">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.phone_number') }}</label>
                            <input type="text" name="phone_number" value="{{ $settings['phone_number'] ?? '' }}" class="input-premium">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.address') }}</label>
                            <input type="text" name="address" value="{{ $settings['address'] ?? '' }}" class="input-premium">
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4 border-b border-slate-200 dark:border-slate-700/50 pb-2">{{ __('messages.financial_settings') }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.default_currency') }}</label>
                            <select name="currency" class="input-premium">
                                <option value="USD" {{ ($settings['currency'] ?? 'USD') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                <option value="EUR" {{ ($settings['currency'] ?? '') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                <option value="GBP" {{ ($settings['currency'] ?? '') == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                                <option value="SAR" {{ ($settings['currency'] ?? '') == 'SAR' ? 'selected' : '' }}>SAR (ر.س)</option>
                                <option value="EGP" {{ ($settings['currency'] ?? '') == 'EGP' ? 'selected' : '' }}>EGP (ج.م)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.default_tax_rate') }}</label>
                            <input type="number" name="tax_rate" value="{{ $settings['tax_rate'] ?? '15' }}" step="0.01" min="0" class="input-premium">
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-slate-200 dark:border-slate-700/50">
                        <button type="submit" class="btn-premium bg-brand-primary hover:bg-brand-accent text-white font-bold py-2 px-6 rounded-xl shadow-lg transition-all duration-300">
                            {{ __('messages.save_settings') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
