<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
            {{ __('messages.employees_hr') }}
        </h2>
            <a href="{{ route('employees.create') }}" class="btn-premium">
                + {{ __('messages.add_employee') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-500/20 border border-green-500 text-green-400 px-4 py-3 rounded-xl relative" role="alert">
                    <strong class="font-bold">{{ __('messages.success') }}</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="glass-card overflow-hidden animate-fade-in-up">
                <div class="p-4 sm:p-6 border-b border-slate-200 dark:border-slate-700/50 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ __('messages.employee_list') }}</h3>
                    
                    <div class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto">
                        <input type="text" placeholder="{{ __('messages.search') }}" class="input-premium w-full sm:w-64 !py-2 !px-3 !text-sm">
                        <button class="btn-premium !py-2 !px-4 !rounded-xl">{{ __('messages.search_btn') }}</button>
                        <a href="{{ route('employees.create') }}" class="btn-premium !py-2 !px-4 !rounded-xl !bg-indigo-600 hover:!bg-indigo-700 !border-none flex justify-center items-center gap-1 shadow-md shadow-indigo-500/20 w-full sm:w-auto">
                            + {{ __('messages.add_employee') }}
                        </a>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse data-table">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-900/30 text-slate-500 dark:text-text-muted text-sm uppercase tracking-wider">
                                <th class="p-4 font-medium text-left">{{ __('messages.id') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.name') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.department') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.position') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.status') }}</th>
                                <th class="p-4 font-medium text-right">{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-200 dark:divide-slate-700/50">
                            @forelse($employees as $employee)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="p-4 text-slate-500 dark:text-text-muted text-left">#{{ $employee->id }}</td>
                                <td class="p-4 text-slate-900 dark:text-white font-medium text-left">
                                    {{ $employee->first_name }} {{ $employee->last_name }}
                                    <div class="text-xs text-slate-500 dark:text-text-muted mt-1">{{ $employee->email }}</div>
                                </td>
                                <td class="p-4 text-slate-500 dark:text-text-muted text-left">{{ $employee->department }}</td>
                                <td class="p-4 text-slate-500 dark:text-text-muted text-left">{{ $employee->position }}</td>
                                <td class="p-4 text-left">
                                    @if($employee->status == 'active')
                                        <span class="bg-green-500/20 text-green-400 py-1 px-3 rounded-full text-xs font-medium">{{ __('messages.active') }}</span>
                                    @else
                                        <span class="bg-red-500/20 text-red-400 py-1 px-3 rounded-full text-xs font-medium">{{ __('messages.inactive') }}</span>
                                    @endif
                                </td>
                                <td class="p-4 text-right">
                                    <div class="flex gap-2 justify-end">
                                        <a href="{{ route('employees.edit', $employee) }}" class="text-brand-primary hover:text-brand-accent transition-colors">{{ __('messages.edit') }}</a>
                                        <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('messages.confirm_delete_employee') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-500 transition-colors">{{ __('messages.delete') }}</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-500 dark:text-text-muted">
                                    {{ __('messages.no_employees_found') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="p-4 border-t border-slate-700/50">
                    {{ $employees->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
