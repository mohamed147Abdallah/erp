<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
            {{ __('messages.profit_and_loss_statement') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="glass-card p-6 mb-8 animate-fade-in-up">
                <form action="{{ route('finance.profit-loss') }}" method="GET" class="flex items-end gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.month') }}</label>
                        <select name="month" class="input-premium py-2">
                            @for($i=1; $i<=12; $i++)
                                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ $month == $i ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.year') }}</label>
                        <select name="year" class="input-premium py-2">
                            @for($i=date('Y'); $i>=date('Y')-5; $i--)
                                <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn-premium !py-2 !px-6 !rounded-xl">{{ __('messages.generate_report') }}</button>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Income Section -->
                <div class="glass-card overflow-hidden animate-fade-in-up" style="animation-delay: 0.1s">
                    <div class="p-6 bg-green-500/10 border-b border-green-500/20">
                        <h3 class="text-xl font-bold text-green-600 dark:text-green-400">{{ __('messages.revenue') }}</h3>
                    </div>
                    <div class="p-6 flex justify-between items-center">
                        <span class="text-slate-600 dark:text-slate-300">{{ __('messages.sales_paid_invoices') }}</span>
                        <span class="text-2xl font-bold text-slate-900 dark:text-white">${{ number_format($revenue, 2) }}</span>
                    </div>
                </div>

                <!-- COGS Section -->
                <div class="glass-card overflow-hidden animate-fade-in-up" style="animation-delay: 0.2s">
                    <div class="p-6 bg-red-500/10 border-b border-red-500/20">
                        <h3 class="text-xl font-bold text-red-600 dark:text-red-400">{{ __('messages.cost_of_goods_sold') }}</h3>
                    </div>
                    <div class="p-6 flex justify-between items-center">
                        <span class="text-slate-600 dark:text-slate-300">{{ __('messages.purchases_received_pos') }}</span>
                        <span class="text-2xl font-bold text-slate-900 dark:text-white">-${{ number_format($cogs, 2) }}</span>
                    </div>
                </div>
                
                <!-- Gross Profit -->
                <div class="md:col-span-2 glass-card overflow-hidden animate-fade-in-up border-2 {{ $grossProfit >= 0 ? 'border-brand-primary/50' : 'border-red-500/50' }}" style="animation-delay: 0.3s">
                    <div class="p-6 flex justify-between items-center bg-slate-50 dark:bg-slate-900/50">
                        <span class="text-lg font-bold text-slate-700 dark:text-slate-300 uppercase tracking-widest">{{ __('messages.gross_profit') }}</span>
                        <span class="text-3xl font-bold {{ $grossProfit >= 0 ? 'text-brand-primary' : 'text-red-500' }}">
                            ${{ number_format($grossProfit, 2) }}
                        </span>
                    </div>
                </div>

                <!-- Operating Expenses -->
                <div class="md:col-span-2 glass-card overflow-hidden animate-fade-in-up" style="animation-delay: 0.4s">
                    <div class="p-6 bg-orange-500/10 border-b border-orange-500/20">
                        <h3 class="text-xl font-bold text-orange-600 dark:text-orange-400">{{ __('messages.operating_expenses') }}</h3>
                    </div>
                    <div class="p-6 flex justify-between items-center border-b border-slate-200 dark:border-slate-700/50">
                        <span class="text-slate-600 dark:text-slate-300">{{ __('messages.total_logged_expenses') }}</span>
                        <span class="text-xl font-bold text-slate-900 dark:text-white">-${{ number_format($expenses, 2) }}</span>
                    </div>
                    <div class="p-4 bg-slate-50 dark:bg-slate-900/30 text-right">
                        <a href="{{ route('finance.expenses.index') }}" class="text-sm text-brand-primary hover:underline">{{ __('messages.view_expense_details') }} &rarr;</a>
                    </div>
                </div>

                <!-- NET PROFIT -->
                <div class="md:col-span-2 glass-card overflow-hidden shadow-2xl shadow-brand-primary/20 animate-fade-in-up transform transition-all hover:scale-[1.01]" style="animation-delay: 0.5s">
                    <div class="p-8 flex flex-col items-center justify-center bg-gradient-to-br from-slate-900 to-slate-800 dark:from-slate-800 dark:to-slate-900 text-white relative overflow-hidden">
                        
                        <!-- decorative background element -->
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-brand-primary/20 rounded-full blur-3xl"></div>
                        <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-brand-accent/20 rounded-full blur-3xl"></div>

                        <span class="text-sm font-bold text-slate-400 uppercase tracking-[0.3em] mb-2 z-10">{{ $netProfit >= 0 ? __('messages.net_profit') : __('messages.net_loss') }}</span>
                        
                        <span class="text-6xl font-black tracking-tight z-10 {{ $netProfit >= 0 ? 'text-green-400' : 'text-red-400' }}">
                            {{ $netProfit >= 0 ? '+' : '' }}${{ number_format($netProfit, 2) }}
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>