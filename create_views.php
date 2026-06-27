<?php

$views = [
    'inventory/movements/index.blade.php' => 'Stock Movements',
    'inventory/adjustments/index.blade.php' => 'Stock Adjustments',
    'sales/invoices/index.blade.php' => 'Sales Invoices',
    'sales/returns.blade.php' => 'Sales Returns',
    'purchases/orders/index.blade.php' => 'Purchase Orders',
    'purchases/returns.blade.php' => 'Purchase Returns',
    'finance/expenses/index.blade.php' => 'Expenses',
    'finance/profit-loss.blade.php' => 'Profit & Loss',
];

$baseDir = __DIR__ . '/resources/views/';

foreach ($views as $path => $title) {
    $fullPath = $baseDir . $path;
    $dir = dirname($fullPath);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $content = <<<HTML
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
            {{ __('{$title}') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card p-12 text-center animate-fade-in-up">
                <div class="text-6xl mb-4">🚀</div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Coming Soon</h3>
                <p class="text-slate-500 dark:text-slate-400">The {$title} module is currently under development.</p>
            </div>
        </div>
    </div>
</x-app-layout>
HTML;

    file_put_contents($fullPath, $content);
    echo "Created: {$path}\n";
}
