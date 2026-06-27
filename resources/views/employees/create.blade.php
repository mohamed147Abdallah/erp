<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
            {{ __('messages.add_employee') }}
        </h2>
            <a href="{{ route('employees.index') }}" class="glass-card px-4 py-2 hover:bg-slate-800 transition">
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

                <form action="{{ route('employees.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- First Name -->
                        <div>
                            <label class="block text-text-muted text-sm font-medium mb-2">{{ __('messages.first_name_star') }}</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" class="input-premium" required>
                        </div>
                        
                        <!-- Last Name -->
                        <div>
                            <label class="block text-text-muted text-sm font-medium mb-2">{{ __('messages.last_name_star') }}</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" class="input-premium" required>
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label class="block text-text-muted text-sm font-medium mb-2">{{ __('messages.email_address_star') }}</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="input-premium" required>
                        </div>
                        
                        <!-- Phone -->
                        <div>
                            <label class="block text-text-muted text-sm font-medium mb-2">{{ __('messages.phone_number') }}</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="input-premium">
                        </div>
                        
                        <!-- Department -->
                        <div>
                            <label class="block text-text-muted text-sm font-medium mb-2">{{ __('messages.department_star') }}</label>
                            <input type="text" name="department" value="{{ old('department') }}" class="input-premium" required>
                        </div>
                        
                        <!-- Position -->
                        <div>
                            <label class="block text-text-muted text-sm font-medium mb-2">{{ __('messages.position_star') }}</label>
                            <input type="text" name="position" value="{{ old('position') }}" class="input-premium" required>
                        </div>
                        
                        <!-- Salary -->
                        <div>
                            <label class="block text-text-muted text-sm font-medium mb-2">{{ __('messages.base_salary_star') }}</label>
                            <input type="number" step="0.01" name="salary" value="{{ old('salary') }}" class="input-premium" required>
                        </div>
                        
                        <!-- Hire Date -->
                        <div>
                            <label class="block text-text-muted text-sm font-medium mb-2">{{ __('messages.hire_date_star') }}</label>
                            <input type="date" name="hire_date" value="{{ old('hire_date') }}" class="input-premium" required>
                        </div>
                        
                        <!-- Status -->
                        <div>
                            <label class="block text-text-muted text-sm font-medium mb-2">{{ __('messages.status') }}</label>
                            <select name="status" class="input-premium appearance-none">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>{{ __('messages.active') }}</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>{{ __('messages.inactive') }}</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="btn-premium px-8 py-3 text-lg">
                            {{ __('messages.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
