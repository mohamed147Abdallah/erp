<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
                {{ __('{{ __('messages.edit_user') }}') }}: {{ $user->name }}
            </h2>
            <a href="{{ route('admin.users.index') }}" class="text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300 transition-colors">
                &larr; {{ __('messages.back_to_users') }}
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

                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.name_star') }}</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="input-premium" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.email_address_star') }}</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="input-premium" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.assign_roles_star') }}</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 bg-slate-50 dark:bg-slate-900/30 p-4 rounded-xl border border-slate-200 dark:border-slate-700/50">
                                @forelse($roles as $role)
                                    <label class="flex items-center space-x-3 cursor-pointer">
                                        <input type="checkbox" name="roles[]" value="{{ $role->name }}" 
                                            {{ in_array($role->name, $userRoles) ? 'checked' : '' }}
                                            class="form-checkbox h-5 w-5 text-brand-primary rounded border-slate-300 focus:ring-brand-primary dark:border-slate-600 dark:bg-slate-800">
                                        <span class="text-slate-700 dark:text-slate-300 font-medium">{{ $role->name }}</span>
                                    </label>
                                @empty
                                    <p class="text-slate-500 dark:text-slate-400 text-sm col-span-full">No roles available. Please create roles first.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-slate-200 dark:border-slate-700/50">
                        <button type="submit" class="btn-premium bg-brand-primary hover:bg-brand-accent text-white font-bold py-2 px-6 rounded-xl shadow-lg transition-all duration-300">
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
