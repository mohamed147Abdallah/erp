<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
                {{ __('{{ __('messages.edit_supplier') }}: ') }} {{ $supplier->name }}
            </h2>
            <a href="{{ route('suppliers.index') }}" class="text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300 transition-colors">
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

                <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Company Name *</label>
                            <input type="text" name="name" value="{{ old('name', $supplier->name) }}" class="input-premium" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.contact_person') }}</label>
                            <input type="text" name="contact_person" value="{{ old('contact_person', $supplier->contact_person) }}" class="input-premium">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.email_address') }}</label>
                            <input type="email" name="email" value="{{ old('email', $supplier->email) }}" class="input-premium">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.phone_number') }}</label>
                            <input type="text" name="phone" value="{{ old('phone', $supplier->phone) }}" class="input-premium">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.address') }}</label>
                            <textarea name="address" rows="3" class="input-premium">{{ old('address', $supplier->address) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.city') }}</label>
                            <input type="text" name="city" value="{{ old('city', $supplier->city) }}" class="input-premium">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.country') }}</label>
                            <input type="text" name="country" value="{{ old('country', $supplier->country) }}" class="input-premium">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.status_star') }}</label>
                            <select name="status" class="input-premium" required>
                                <option value="active" {{ old('status', $supplier->status) == 'active' ? 'selected' : '' }}>{{ __('messages.active') }}</option>
                                <option value="inactive" {{ old('status', $supplier->status) == 'inactive' ? 'selected' : '' }}>{{ __('messages.inactive') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-slate-200 dark:border-slate-700/50">
                        <button type="submit" class="btn-premium">
                            Update Supplier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
