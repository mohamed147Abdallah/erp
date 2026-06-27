<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
            {{ __('messages.add_category') }}
        </h2>
            <a href="{{ route('categories.index') }}" class="text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300 transition-colors">
                &larr; {{ __('messages.back_to_list') }}
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

                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.category_name_star') }}</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="input-premium" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.description') }}</label>
                            <textarea name="description" rows="4" class="input-premium">{{ old('description') }}</textarea>
                        </div>
                        <div class="flex items-center mt-2">
                            <input type="checkbox" name="is_active" id="is_active" class="rounded border-slate-300 text-brand-primary shadow-sm focus:ring-brand-primary dark:bg-slate-800 dark:border-slate-600 h-5 w-5" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label for="is_active" class="ml-2 block text-sm text-slate-700 dark:text-slate-300">
                                {{ __('messages.active_category') }}
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-slate-200 dark:border-slate-700/50">
                        <button type="submit" class="btn-premium">
                            {{ __('messages.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
