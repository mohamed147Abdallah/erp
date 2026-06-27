<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
            {{ __('messages.roles_management') }}
        </h2>
            <a href="{{ route('admin.roles.create') }}" class="btn-premium">
                + {{ __('messages.create_role') }}
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
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ __('messages.system_roles') }}</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse data-table">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-900/30 text-slate-500 dark:text-text-muted text-sm uppercase tracking-wider">
                                <th class="p-4 font-medium text-left">{{ __('messages.role_name') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.permissions') }}</th>
                                <th class="p-4 font-medium text-right">{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-200 dark:divide-slate-700/50">
                            @forelse($roles as $role)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="p-4 text-slate-900 dark:text-white font-bold text-left">{{ $role->name }}</td>
                                <td class="p-4 text-left">
                                    <div class="flex flex-wrap gap-1">
                                        @forelse($role->permissions as $permission)
                                            <span class="bg-indigo-500/20 text-indigo-400 py-1 px-2 rounded-lg text-[10px] font-medium tracking-wide uppercase">{{ $permission->name }}</span>
                                        @empty
                                            <span class="text-slate-500 text-xs italic">{{ __('messages.no_permissions_assigned') }}</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="p-4 text-right">
                                    <div class="flex gap-2 justify-end">
                                        <a href="{{ route('admin.roles.edit', $role) }}" class="text-blue-500 hover:text-blue-400 transition-colors text-xs font-medium border border-blue-500/30 px-2 py-1 rounded">{{ __('messages.edit') }}</a>
                                        <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('messages.confirm_delete_role') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-400 transition-colors text-xs font-medium border border-red-500/30 px-2 py-1 rounded">{{ __('messages.delete') }}</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-8 text-center text-slate-500 dark:text-text-muted">
                                    {{ __('messages.no_roles_found') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
