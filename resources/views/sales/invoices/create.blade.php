<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-bold text-2xl text-slate-900 dark:text-white tracking-wide">
            {{ __('messages.create_invoice') }}
        </h2>
            <a href="{{ route('sales.invoices.index') }}" class="text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300 transition-colors">
                &larr; {{ __('messages.back_to_invoices') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

                <form action="{{ route('sales.invoices.store') }}" method="POST" id="invoiceForm">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 pb-8 border-b border-slate-700/50">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.invoice_number_star') }}</label>
                            <input type="text" name="invoice_number" value="{{ old('invoice_number', $invoiceNumber) }}" class="input-premium" required readonly>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.customer_star') }}</label>
                            <select name="customer_id" class="input-premium" required>
                                <option value="">{{ __('messages.select_customer') }}</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }} ({{ $customer->company }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.status_star') }}</label>
                            <select name="status" class="input-premium" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>{{ __('messages.draft') }}</option>
                                <option value="sent" {{ old('status') == 'sent' ? 'selected' : '' }}>{{ __('messages.sent') }}</option>
                                <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>{{ __('messages.paid') }}</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.invoice_date_star') }}</label>
                            <input type="date" name="invoice_date" value="{{ old('invoice_date', date('Y-m-d')) }}" class="input-premium" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.due_date') }}</label>
                            <input type="date" name="due_date" value="{{ old('due_date') }}" class="input-premium">
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">{{ __('messages.invoice_items') }}</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse data-table" id="itemsTable">
                                <thead>
                                    <tr class="bg-slate-50 dark:bg-slate-900/30 text-slate-500 dark:text-text-muted text-sm uppercase tracking-wider">
                                        <th class="p-3 font-medium text-left w-1/2">{{ __('messages.product') }}</th>
                                        <th class="p-3 font-medium text-left w-1/6">{{ __('messages.quantity') }}</th>
                                        <th class="p-3 font-medium text-left w-1/6">{{ __('messages.unit_price') }}</th>
                                        <th class="p-3 font-medium text-left w-1/6">{{ __('messages.total') }}</th>
                                        <th class="p-3"></th>
                                    </tr>
                                </thead>
                                <tbody id="itemsBody">
                                    <tr class="item-row border-b border-slate-700/50">
                                        <td class="p-2">
                                            <select name="products[0][id]" class="input-premium product-select" required onchange="calculateRow(this)">
                                                <option value="">{{ __('messages.select_product') }}</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                                        {{ $product->name }} (Stock: {{ $product->stock_quantity }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="p-2">
                                            <input type="number" name="products[0][quantity]" class="input-premium quantity-input" value="1" min="1" required oninput="calculateRow(this)">
                                        </td>
                                        <td class="p-2">
                                            <input type="number" name="products[0][unit_price]" class="input-premium price-input" value="0.00" step="0.01" min="0" required oninput="calculateRow(this)">
                                        </td>
                                        <td class="p-2">
                                            <input type="text" class="input-premium row-total bg-slate-100 dark:bg-slate-800" value="0.00" readonly>
                                        </td>
                                        <td class="p-2 text-center">
                                            <button type="button" class="text-red-500 hover:text-red-700 font-bold" onclick="removeRow(this)">X</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            <button type="button" onclick="addRow()" class="text-brand-primary font-medium text-sm hover:underline">+ {{ __('messages.add_another_product') }}</button>
                        </div>
                    </div>

                    <div class="flex flex-col items-end mb-8 border-t border-slate-700/50 pt-4">
                        <div class="w-64 flex justify-between mb-2">
                            <span class="text-slate-500 dark:text-slate-400">{{ __('messages.subtotal_colon') }}</span>
                            <span class="font-mono text-slate-900 dark:text-white" id="subtotalDisplay">$0.00</span>
                        </div>
                        <div class="w-64 flex justify-between mb-2">
                            <span class="text-slate-500 dark:text-slate-400">{{ __('messages.tax_15') }}</span>
                            <span class="font-mono text-slate-900 dark:text-white" id="taxDisplay">$0.00</span>
                        </div>
                        <div class="w-64 flex justify-between font-bold text-lg">
                            <span class="text-slate-900 dark:text-white">{{ __('messages.total_colon') }}</span>
                            <span class="font-mono text-brand-primary" id="totalDisplay">$0.00</span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">{{ __('messages.notes') }}</label>
                        <textarea name="notes" rows="3" class="input-premium">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-slate-200 dark:border-slate-700/50">
                        <button type="submit" class="btn-premium bg-brand-primary hover:bg-brand-accent text-white font-bold py-2 px-6 rounded-xl shadow-lg transition-all duration-300">
                            {{ __('messages.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let rowCount = 1;

        function addRow() {
            const tbody = document.getElementById('itemsBody');
            const newRow = document.createElement('tr');
            newRow.className = 'item-row border-b border-slate-700/50';
            
            // Getting product options from the first row to duplicate them
            const firstSelect = document.querySelector('.product-select').innerHTML;

            newRow.innerHTML = `
                <td class="p-2">
                    <select name="products[${rowCount}][id]" class="input-premium product-select" required onchange="calculateRow(this)">
                        ${firstSelect}
                    </select>
                </td>
                <td class="p-2">
                    <input type="number" name="products[${rowCount}][quantity]" class="input-premium quantity-input" value="1" min="1" required oninput="calculateRow(this)">
                </td>
                <td class="p-2">
                    <input type="number" name="products[${rowCount}][unit_price]" class="input-premium price-input" value="0.00" step="0.01" min="0" required oninput="calculateRow(this)">
                </td>
                <td class="p-2">
                    <input type="text" class="input-premium row-total bg-slate-100 dark:bg-slate-800" value="0.00" readonly>
                </td>
                <td class="p-2 text-center">
                    <button type="button" class="text-red-500 hover:text-red-700 font-bold" onclick="removeRow(this)">X</button>
                </td>
            `;
            tbody.appendChild(newRow);
            rowCount++;
        }

        function removeRow(btn) {
            const row = btn.closest('tr');
            if (document.querySelectorAll('.item-row').length > 1) {
                row.remove();
                calculateGrandTotal();
            } else {
                alert("You must have at least one item on the invoice.");
            }
        }

        function calculateRow(element) {
            const row = element.closest('tr');
            const select = row.querySelector('.product-select');
            const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
            const priceInput = row.querySelector('.price-input');
            
            // If the element changed was the select, update the price
            if (element.classList.contains('product-select')) {
                const selectedOption = select.options[select.selectedIndex];
                if (selectedOption.value !== "") {
                    priceInput.value = parseFloat(selectedOption.dataset.price || 0).toFixed(2);
                }
            }

            const price = parseFloat(priceInput.value) || 0;
            const total = quantity * price;
            
            row.querySelector('.row-total').value = total.toFixed(2);
            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            let subtotal = 0;
            document.querySelectorAll('.row-total').forEach(input => {
                subtotal += parseFloat(input.value) || 0;
            });

            const tax = subtotal * 0.15;
            const grandTotal = subtotal + tax;

            document.getElementById('subtotalDisplay').innerText = '$' + subtotal.toFixed(2);
            document.getElementById('taxDisplay').innerText = '$' + tax.toFixed(2);
            document.getElementById('totalDisplay').innerText = '$' + grandTotal.toFixed(2);
        }
    </script>
</x-app-layout>
