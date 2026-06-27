<aside class="w-full h-full flex flex-col shrink-0 bg-white dark:bg-[#0c0f1a] border-r border-slate-200/80 dark:border-slate-800/60 transition-colors duration-300">

    <!-- Logo Area -->
    <div class="h-16 flex items-center px-5 border-b border-slate-200/80 dark:border-slate-800/60 shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/30 group-hover:shadow-indigo-500/50 transition-all duration-300">
                <svg class="w-4.5 h-4.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div>
                <span class="text-base font-extrabold tracking-tight text-slate-900 dark:text-white">NEXUS</span><span class="text-base font-extrabold text-indigo-600 dark:text-indigo-400">.ERP</span>
            </div>
        </a>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 overflow-y-auto py-4 px-3 space-y-0.5">

        {{-- Helper macro for sidebar group buttons --}}
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            {{ __('messages.dashboard') }}
        </a>

        <!-- Section Label -->
        <p class="px-3 pt-4 pb-1 text-[10px] font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-600">{{ __('messages.operations') }}</p>

        <!-- CRM -->
        <div x-data="{ open: {{ request()->routeIs('customers.*') || request()->routeIs('suppliers.*') ? 'true' : 'false' }} }">
            <button type="button" @click.prevent="open = !open"
                class="sidebar-link w-full justify-between {{ request()->routeIs('customers.*') || request()->routeIs('suppliers.*') ? 'active' : '' }}">
                <span class="flex items-center gap-3">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    {{ __('messages.crm') }}
                </span>
                <svg :class="{'rotate-180': open}" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-cloak x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" class="mt-0.5 space-y-0.5">
                <a href="{{ route('customers.index') }}" class="sidebar-sublink {{ request()->routeIs('customers.*') ? 'active-sub' : '' }}">{{ __('messages.customers') }}</a>
                <a href="{{ route('suppliers.index') }}" class="sidebar-sublink {{ request()->routeIs('suppliers.*') ? 'active-sub' : '' }}">{{ __('messages.suppliers') }}</a>
            </div>
        </div>

        <!-- Catalog -->
        <div x-data="{ open: {{ request()->routeIs('categories.*') || request()->routeIs('products.*') ? 'true' : 'false' }} }">
            <button type="button" @click.prevent="open = !open"
                class="sidebar-link w-full justify-between {{ request()->routeIs('categories.*') || request()->routeIs('products.*') ? 'active' : '' }}">
                <span class="flex items-center gap-3">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    {{ __('messages.catalog') }}
                </span>
                <svg :class="{'rotate-180': open}" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-cloak x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" class="mt-0.5 space-y-0.5">
                <a href="{{ route('categories.index') }}" class="sidebar-sublink {{ request()->routeIs('categories.*') ? 'active-sub' : '' }}">{{ __('messages.categories') }}</a>
                <a href="{{ route('products.index') }}" class="sidebar-sublink {{ request()->routeIs('products.*') ? 'active-sub' : '' }}">{{ __('messages.products') }}</a>
            </div>
        </div>

        <!-- Inventory -->
        <div x-data="{ open: {{ request()->routeIs('inventory.*') ? 'true' : 'false' }} }">
            <button type="button" @click.prevent="open = !open"
                class="sidebar-link w-full justify-between {{ request()->routeIs('inventory.*') ? 'active' : '' }}">
                <span class="flex items-center gap-3">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    {{ __('messages.inventory') }}
                </span>
                <svg :class="{'rotate-180': open}" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-cloak x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" class="mt-0.5 space-y-0.5">
                <a href="{{ route('inventory.overview') }}" class="sidebar-sublink {{ request()->routeIs('inventory.overview') ? 'active-sub' : '' }}">{{ __('messages.overview') }}</a>
                <a href="{{ route('inventory.movements.index') }}" class="sidebar-sublink {{ request()->routeIs('inventory.movements.*') ? 'active-sub' : '' }}">{{ __('messages.stock_movements') }}</a>
                <a href="{{ route('inventory.adjustments.index') }}" class="sidebar-sublink {{ request()->routeIs('inventory.adjustments.*') ? 'active-sub' : '' }}">{{ __('messages.adjustments') }}</a>
            </div>
        </div>

        <!-- Sales -->
        <div x-data="{ open: {{ request()->routeIs('sales.*') ? 'true' : 'false' }} }">
            <button type="button" @click.prevent="open = !open"
                class="sidebar-link w-full justify-between {{ request()->routeIs('sales.*') ? 'active' : '' }}">
                <span class="flex items-center gap-3">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    {{ __('messages.sales') }}
                </span>
                <svg :class="{'rotate-180': open}" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-cloak x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" class="mt-0.5 space-y-0.5">
                <a href="{{ route('sales.invoices.index') }}" class="sidebar-sublink {{ request()->routeIs('sales.invoices.*') ? 'active-sub' : '' }}">{{ __('messages.invoices') }}</a>
                <a href="{{ route('sales.returns') }}" class="sidebar-sublink {{ request()->routeIs('sales.returns') ? 'active-sub' : '' }}">{{ __('messages.returns') }}</a>
            </div>
        </div>

        <!-- Purchases -->
        <div x-data="{ open: {{ request()->routeIs('purchases.*') ? 'true' : 'false' }} }">
            <button type="button" @click.prevent="open = !open"
                class="sidebar-link w-full justify-between {{ request()->routeIs('purchases.*') ? 'active' : '' }}">
                <span class="flex items-center gap-3">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    {{ __('messages.purchases') }}
                </span>
                <svg :class="{'rotate-180': open}" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-cloak x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" class="mt-0.5 space-y-0.5">
                <a href="{{ route('purchases.orders.index') }}" class="sidebar-sublink {{ request()->routeIs('purchases.orders.*') ? 'active-sub' : '' }}">{{ __('messages.purchase_orders') }}</a>
                <a href="{{ route('purchases.returns') }}" class="sidebar-sublink {{ request()->routeIs('purchases.returns') ? 'active-sub' : '' }}">{{ __('messages.returns') }}</a>
            </div>
        </div>

        <!-- Finance -->
        <div x-data="{ open: {{ request()->routeIs('finance.*') ? 'true' : 'false' }} }">
            <button type="button" @click.prevent="open = !open"
                class="sidebar-link w-full justify-between {{ request()->routeIs('finance.*') ? 'active' : '' }}">
                <span class="flex items-center gap-3">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ __('messages.finance') }}
                </span>
                <svg :class="{'rotate-180': open}" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-cloak x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" class="mt-0.5 space-y-0.5">
                <a href="{{ route('finance.expenses.index') }}" class="sidebar-sublink {{ request()->routeIs('finance.expenses.*') ? 'active-sub' : '' }}">{{ __('messages.expenses') }}</a>
                <a href="{{ route('finance.profit-loss') }}" class="sidebar-sublink {{ request()->routeIs('finance.profit-loss') ? 'active-sub' : '' }}">{{ __('messages.profit_loss') }}</a>
            </div>
        </div>

        <!-- Section Label -->
        <p class="px-3 pt-5 pb-1 text-[10px] font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-600">{{ __('messages.tools') }}</p>

        <!-- Data Import -->
        <a href="{{ route('imports.index') }}" class="sidebar-link {{ request()->routeIs('imports.*') || request()->routeIs('data-import.*') ? 'active' : '' }}">
            <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
            {{ __('messages.data_import') }}
        </a>

        <!-- HR / Employees -->
        <a href="{{ route('employees.index') }}" class="sidebar-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
            <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            {{ __('messages.employees_hr') }}
        </a>

        <!-- Section Label -->
        <p class="px-3 pt-5 pb-1 text-[10px] font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-600">{{ __('messages.admin') }}</p>

        <!-- Administration -->
        <div x-data="{ open: {{ request()->routeIs('admin.*') ? 'true' : 'false' }} }">
            <button type="button" @click.prevent="open = !open"
                class="sidebar-link w-full justify-between {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                <span class="flex items-center gap-3">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    {{ __('messages.administration') }}
                </span>
                <svg :class="{'rotate-180': open}" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div x-cloak x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" class="mt-0.5 space-y-0.5">
                <a href="{{ route('admin.users.index') }}" class="sidebar-sublink {{ request()->routeIs('admin.users.*') ? 'active-sub' : '' }}">{{ __('messages.users') }}</a>
                <a href="{{ route('admin.roles.index') }}" class="sidebar-sublink {{ request()->routeIs('admin.roles.*') ? 'active-sub' : '' }}">{{ __('messages.roles') }}</a>
                <a href="{{ route('admin.permissions.index') }}" class="sidebar-sublink {{ request()->routeIs('admin.permissions.*') ? 'active-sub' : '' }}">{{ __('messages.permissions') }}</a>
                <a href="{{ route('admin.activity-logs.index') }}" class="sidebar-sublink {{ request()->routeIs('admin.activity-logs.*') ? 'active-sub' : '' }}">{{ __('messages.activity_logs') }}</a>
            </div>
        </div>

        <!-- Settings -->
        <a href="{{ route('settings.index') }}" class="sidebar-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
            <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            {{ __('messages.settings') }}
        </a>

    </div>

    <!-- Sidebar Footer -->
    <div class="shrink-0 p-3 border-t border-slate-200/80 dark:border-slate-800/60">
        <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-colors cursor-pointer">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-white text-xs font-bold shrink-0">
                {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-slate-800 dark:text-white truncate">{{ Auth::user()->name ?? 'User' }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-500 truncate">{{ Auth::user()->email ?? '' }}</p>
            </div>
        </div>
    </div>

</aside>
