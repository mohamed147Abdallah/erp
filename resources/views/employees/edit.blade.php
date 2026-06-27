<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
                {{ __('{{ __('messages.edit_employee') }}: ') }} {{ $employee->first_name }} {{ $employee->last_name }}
            </h2>
            <a href="{{ route('employees.index') }}" class="glass-card px-4 py-2 hover:bg-slate-800 transition">
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

                <form action="{{ route('employees.update', $employee) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- First Name -->
                        <div>
                            <label class="block text-text-muted text-sm font-medium mb-2">First Name <span class="text-red-500">*</span></label>
                            <input type="text" name="first_name" value="{{ old('first_name', $employee->first_name) }}" class="input-premium" required>
                        </div>
                        
                        <!-- Last Name -->
                        <div>
                            <label class="block text-text-muted text-sm font-medium mb-2">Last Name <span class="text-red-500">*</span></label>
                            <input type="text" name="last_name" value="{{ old('last_name', $employee->last_name) }}" class="input-premium" required>
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label class="block text-text-muted text-sm font-medium mb-2">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $employee->email) }}" class="input-premium" required>
                        </div>
                        
                        <!-- Phone -->
                        <div>
                            <label class="block text-text-muted text-sm font-medium mb-2">{{ __('messages.phone_number') }}</label>
                            <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}" class="input-premium">
                        </div>
                        
                        <!-- Department -->
                        <div>
                            <label class="block text-text-muted text-sm font-medium mb-2">Department <span class="text-red-500">*</span></label>
                            <input type="text" name="department" value="{{ old('department', $employee->department) }}" class="input-premium" required>
                        </div>
                        
                        <!-- Position -->
                        <div>
                            <label class="block text-text-muted text-sm font-medium mb-2">Position / Title <span class="text-red-500">*</span></label>
                            <input type="text" name="position" value="{{ old('position', $employee->position) }}" class="input-premium" required>
                        </div>
                        
                        <!-- Salary -->
                        <div>
                            <label class="block text-text-muted text-sm font-medium mb-2">Base Salary <span class="text-red-500">*</span></label>
                            <input type="number" step="0.01" name="salary" value="{{ old('salary', $employee->salary) }}" class="input-premium" required>
                        </div>
                        
                        <!-- Hire Date -->
                        <div>
                            <label class="block text-text-muted text-sm font-medium mb-2">Hire Date <span class="text-red-500">*</span></label>
                            <input type="date" name="hire_date" value="{{ old('hire_date', $employee->hire_date) }}" class="input-premium" required>
                        </div>
                        
                        <!-- Status -->
                        <div>
                            <label class="block text-text-muted text-sm font-medium mb-2">{{ __('messages.status') }}</label>
                            <select name="status" class="input-premium appearance-none">
                                <option value="active" {{ old('status', $employee->status) == 'active' ? 'selected' : '' }}>{{ __('messages.active') }}</option>
                                <option value="inactive" {{ old('status', $employee->status) == 'inactive' ? 'selected' : '' }}>{{ __('messages.inactive') }}</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="btn-premium px-8 py-3 text-lg">
                            Update Employee
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
