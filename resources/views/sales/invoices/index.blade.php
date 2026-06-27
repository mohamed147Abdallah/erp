<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
            {{ __('messages.sales_invoices') }}
        </h2>
            <a href="{{ route('sales.invoices.create') }}" class="btn-premium">
                + {{ __('messages.create_invoice') }}
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
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ __('messages.recent_invoices') }}</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse data-table">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-900/30 text-slate-500 dark:text-text-muted text-sm uppercase tracking-wider">
                                <th class="p-4 font-medium text-left">{{ __('messages.invoice_no') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.date') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.customer') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.total_amount') }}</th>
                                <th class="p-4 font-medium text-left">{{ __('messages.status') }}</th>
                                <th class="p-4 font-medium text-right">{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-200 dark:divide-slate-700/50">
                            @forelse($invoices as $invoice)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="p-4 text-slate-900 dark:text-white font-mono text-left">{{ $invoice->invoice_number }}</td>
                                <td class="p-4 text-slate-500 dark:text-text-muted text-left">{{ $invoice->invoice_date->format('M d, Y') }}</td>
                                <td class="p-4 text-slate-900 dark:text-white font-medium text-left">{{ $invoice->customer->name ?? 'Unknown' }}</td>
                                <td class="p-4 text-left font-bold text-slate-900 dark:text-white">${{ number_format($invoice->total_amount, 2) }}</td>
                                <td class="p-4 text-left">
                                    @if($invoice->status == 'paid')
                                        <span class="bg-green-500/20 text-green-400 py-1 px-3 rounded-full text-xs font-medium uppercase">{{ $invoice->status }}</span>
                                    @elseif($invoice->status == 'overdue')
                                        <span class="bg-red-500/20 text-red-400 py-1 px-3 rounded-full text-xs font-medium uppercase">{{ $invoice->status }}</span>
                                    @else
                                        <span class="bg-slate-500/20 text-slate-400 py-1 px-3 rounded-full text-xs font-medium uppercase">{{ $invoice->status }}</span>
                                    @endif
                                </td>
                                <td class="p-4 text-right">
                                    <div class="flex gap-2 justify-end">
                                        <a href="{{ route('sales.invoices.pdf', $invoice) }}" class="text-indigo-500 hover:text-indigo-400 transition-colors text-xs font-medium border border-indigo-500/30 px-2 py-1 rounded flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            PDF
                                        </a>
                                        <a href="{{ route('sales.invoices.edit', $invoice) }}" class="text-blue-500 hover:text-blue-400 transition-colors text-xs font-medium border border-blue-500/30 px-2 py-1 rounded">{{ __('messages.edit') }}</a>
                                        <form action="{{ route('sales.invoices.destroy', $invoice) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('messages.confirm_delete_invoice') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-400 transition-colors text-xs font-medium border border-red-500/30 px-2 py-1 rounded">{{ __('messages.delete') }}</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-500 dark:text-text-muted">
                                    {{ __('messages.no_invoices_created') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="p-4 border-t border-slate-700/50">
                    {{ $invoices->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>