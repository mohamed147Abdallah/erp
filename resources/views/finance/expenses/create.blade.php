<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
            {{ __('messages.log_expense') }}
        </h2>
            <a href="{{ route('finance.expenses.index') }}" class="text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300 transition-colors">
                &larr; {{ __('messages.back_to_expenses') }}
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

                <form action="{{ route('finance.expenses.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.category_star') }}</label>
                            <input type="text" name="category" value="{{ old('category') }}" placeholder="{{ __('messages.eg_expense_category') }}" class="input-premium" list="categories" required>
                            <datalist id="categories">
                                <option value="Rent">
                                <option value="Utilities">
                                <option value="Salaries">
                                <option value="Marketing">
                                <option value="Office Supplies">
                                <option value="Maintenance">
                            </datalist>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.amount_star') }}</label>
                            <input type="number" name="amount" value="{{ old('amount') }}" step="0.01" min="0" class="input-premium" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.expense_date_star') }}</label>
                            <input type="date" name="expense_date" value="{{ old('expense_date', date('Y-m-d')) }}" class="input-premium" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.reference_receipt_no') }}</label>
                            <input type="text" name="reference" value="{{ old('reference') }}" class="input-premium">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.description') }}</label>
                            <textarea name="description" rows="3" class="input-premium">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-slate-200 dark:border-slate-700/50">
                        <button type="submit" class="btn-premium bg-brand-primary hover:bg-brand-accent text-white font-bold py-2 px-6 rounded-xl shadow-lg transition-all duration-300">
                            {{ __('messages.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
