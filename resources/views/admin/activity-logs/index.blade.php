<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
            {{ __('messages.system_activity_logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card overflow-hidden animate-fade-in-up">
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse data-table">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-700">
                                <th class="p-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('messages.time') }}</th>
                                <th class="p-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('messages.user') }}</th>
                                <th class="p-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('messages.action') }}</th>
                                <th class="p-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('messages.subject') }}</th>
                                <th class="p-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('messages.details') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                            @forelse($activities as $activity)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                    <td class="p-4 text-sm text-slate-500">
                                        {{ $activity->created_at->format('M d, Y H:i:s') }}
                                        <div class="text-xs text-slate-400">{{ $activity->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="p-4 text-sm font-medium text-slate-900 dark:text-white">
                                        {{ $activity->causer ? $activity->causer->name : 'System' }}
                                    </td>
                                    <td class="p-4">
                                        @php
                                            $badgeClass = match($activity->event) {
                                                'created' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                                'updated' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                                'deleted' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                                default => 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300'
                                            };
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $badgeClass }}">
                                            {{ ucfirst($activity->event) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-sm text-slate-500">
                                        {{ class_basename($activity->subject_type) }} #{{ $activity->subject_id }}
                                    </td>
                                    <td class="p-4 text-sm text-slate-500 max-w-xs truncate">
                                        @if($activity->properties->count() > 0)
                                            <button onclick="alert('{{ addslashes(json_encode($activity->properties, JSON_PRETTY_PRINT)) }}')" class="text-brand-primary hover:underline text-xs">
                                                {{ __('messages.view_changes') }}
                                            </button>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-slate-500">
                                        {{ __('messages.no_activity_logs') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($activities->hasPages())
                    <div class="p-4 border-t border-slate-200 dark:border-slate-700">
                        {{ $activities->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
