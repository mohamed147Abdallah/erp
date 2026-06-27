<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">
            {{ __('messages.dashboard_analytics') }}
        </h2>
        <p class="page-subtitle">{{ __('messages.dashboard_subtitle') }}</p>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 animate-fade-in-up">
                
                <!-- Revenue -->
                <div class="stat-card">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="stat-card-label">{{ __('messages.total_revenue') }}</p>
                            <h3 class="stat-card-value">${{ number_format($totalRevenue, 2) }}</h3>
                            <div class="stat-card-trend {{ $revenueChange >= 0 ? 'up' : 'down' }}" title="Compared to last month">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $revenueChange >= 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}"></path></svg>
                                <span>{{ $revenueChange > 0 ? '+' : '' }}{{ number_format($revenueChange, 1) }}%</span>
                            </div>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- COGS -->
                <div class="stat-card stagger-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="stat-card-label">{{ __('messages.cost_of_goods') }}</p>
                            <h3 class="stat-card-value">${{ number_format($totalCogs, 2) }}</h3>
                            <div class="stat-card-trend {{ $cogsChange >= 0 ? 'up' : 'down' }}" title="Compared to last month">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $cogsChange >= 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}"></path></svg>
                                <span>{{ $cogsChange > 0 ? '+' : '' }}{{ number_format($cogsChange, 1) }}%</span>
                            </div>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center text-amber-600 dark:text-amber-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Expenses -->
                <div class="stat-card stagger-2">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="stat-card-label">{{ __('messages.operating_expenses') }}</p>
                            <h3 class="stat-card-value">${{ number_format($totalExpenses, 2) }}</h3>
                            <div class="stat-card-trend {{ $expensesChange >= 0 ? 'up' : 'down' }}" title="Compared to last month">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $expensesChange >= 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}"></path></svg>
                                <span>{{ $expensesChange > 0 ? '+' : '' }}{{ number_format($expensesChange, 1) }}%</span>
                            </div>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-red-50 dark:bg-red-500/10 flex items-center justify-center text-red-600 dark:text-red-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Net Profit -->
                <div class="stat-card stagger-3">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="stat-card-label">{{ __('messages.net_profit') }}</p>
                            <h3 class="stat-card-value {{ $netProfit >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                                ${{ number_format($netProfit, 2) }}
                            </h3>
                            <div class="stat-card-trend {{ $profitChange >= 0 ? 'up' : 'down' }}" title="Compared to last month">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $profitChange >= 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}"></path></svg>
                                <span>{{ $profitChange > 0 ? '+' : '' }}{{ number_format($profitChange, 1) }}%</span>
                            </div>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts & Lists Row -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Chart Container -->
                <div class="lg:col-span-2 glass-card p-6 animate-fade-in-up stagger-4">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100 uppercase tracking-wider">{{ __('messages.financial_overview') }}</h3>
                        <select class="select-premium !py-1.5 !px-3 !text-xs !w-auto">
                            <option>{{ __('messages.last_6_months') }}</option>
                            <option>{{ __('messages.this_year') }}</option>
                        </select>
                    </div>
                    <div class="relative h-[300px] w-full">
                        <canvas id="financeChart"></canvas>
                    </div>
                </div>

                <!-- Recent Activity / Invoices -->
                <div class="glass-card p-0 overflow-hidden animate-fade-in-up stagger-5 flex flex-col">
                    <div class="p-6 border-b border-slate-200 dark:border-slate-800/60">
                        <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100 uppercase tracking-wider">{{ __('messages.recent_sales') }}</h3>
                    </div>
                    
                    <div class="flex-1 overflow-y-auto">
                        @forelse($recentInvoices as $invoice)
                            <div class="px-6 py-4 flex items-center justify-between border-b border-slate-100 dark:border-slate-800/40 hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-xs shrink-0">
                                        {{ substr($invoice->customer->name ?? 'W', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $invoice->customer->name ?? __('messages.walk_in_customer') }}</p>
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $invoice->invoice_number }} &bull; {{ $invoice->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-slate-900 dark:text-white">${{ number_format($invoice->total_amount, 2) }}</p>
                                    <span class="badge badge-success !text-[0.65rem] !px-2 mt-1">{{ __('messages.paid') }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-slate-500">
                                <p class="text-sm">{{ __('messages.no_recent_sales') }}</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="p-4 border-t border-slate-200 dark:border-slate-800/60 bg-slate-50 dark:bg-slate-900/50">
                        <a href="{{ route('sales.invoices.index') }}" class="btn-secondary w-full">{{ __('messages.view_all_invoices') }}</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('financeChart').getContext('2d');

            const months      = {!! json_encode($months) !!};
            const revenueData = {!! json_encode($revenueData) !!};
            const expenseData = {!! json_encode($expenseData) !!};
            
            const isDark = document.documentElement.classList.contains('dark');

            // Set default font
            Chart.defaults.font.family = "'Inter', system-ui, sans-serif";
            Chart.defaults.color = isDark ? '#94a3b8' : '#64748b';

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: 'Revenue',
                            data: revenueData,
                            backgroundColor: '#6366f1',
                            borderRadius: 4,
                            barPercentage: 0.6,
                            categoryPercentage: 0.8
                        },
                        {
                            label: 'Expenses & COGS',
                            data: expenseData,
                            backgroundColor: isDark ? '#334155' : '#e2e8f0',
                            borderRadius: 4,
                            barPercentage: 0.6,
                            categoryPercentage: 0.8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'end',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 8,
                                padding: 20,
                                font: {
                                    size: 12,
                                    weight: 500
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: isDark ? '#1e293b' : '#ffffff',
                            titleColor: isDark ? '#f1f5f9' : '#0f172a',
                            bodyColor: isDark ? '#cbd5e1' : '#475569',
                            borderColor: isDark ? '#334155' : '#e2e8f0',
                            borderWidth: 1,
                            padding: 12,
                            boxPadding: 6,
                            usePointStyle: true,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.04)',
                                drawBorder: false,
                            },
                            ticks: {
                                padding: 10,
                                font: { size: 11 },
                                callback: function(value) {
                                    return '$' + (value >= 1000 ? (value/1000) + 'k' : value);
                                }
                            },
                            border: { display: false }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                padding: 10,
                                font: { size: 11, weight: 500 }
                            },
                            border: { display: false }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                }
            });
        });
    </script>
</x-app-layout>
