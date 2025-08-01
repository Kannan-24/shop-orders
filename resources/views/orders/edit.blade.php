<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-900 leading-tight">Edit Order #{{ $order->id }}</h2>
        <p class="text-gray-600 mt-1">Update order details below</p>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg border">
                <!-- Header -->
                <div class="px-6 py-6 border-b">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-lg font-medium text-gray-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 7v4a1 1 0 001 1h3m10-5v4a1 1 0 01-1 1h-3m-4 4h4m-2 0v4m0 0a9 9 0 100-18 9 9 0 000 18z" />
                                </svg>
                            </span>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold text-gray-900">Edit Order</h2>
                            <p class="text-gray-500">Modify the order information below</p>
                        </div>
                    </div>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="px-6 py-4 border-b bg-red-50">
                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Order Form -->
                <form method="POST" action="{{ route('orders.update', $order->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="px-6 py-6 flex justify-center">
                        <div class="gap-8 w-full md:w-2/3">
                            <div class="space-y-6">
                                <div>
                                    <label for="customer_id" class="block text-sm font-medium text-gray-500 mb-1">
                                        Customer <span class="text-red-500">*</span>
                                    </label>
                                    <select name="customer_id" id="customer_id" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Select customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                @if ($order->customer_id == $customer->id) selected @endif>
                                                {{ $customer->name }} ({{ $customer->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-500 mb-1">
                                        Status <span class="text-red-500">*</span>
                                    </label>
                                    <select name="status" id="status" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @foreach (['pending', 'completed', 'cancelled'] as $status)
                                            <option value="{{ $status }}"
                                                @if ($order->status == $status) selected @endif>{{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items Table -->
                    <div class="px-6 py-6">
                        <h3 class="text-lg font-semibold mb-3 text-gray-800">Order Items</h3>
                        <div class="overflow-x-auto mb-6">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm"
                                id="order-items-table">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 border-b font-semibold text-gray-700 text-left">Product</th>
                                        <th class="px-6 py-3 border-b font-semibold text-gray-700 text-right">Price</th>
                                        <th class="px-6 py-3 border-b font-semibold text-gray-700 text-center">Qty</th>
                                        <th class="px-6 py-3 border-b font-semibold text-gray-700 text-center">Unit Value</th>
                                        <th class="px-6 py-3 border-b font-semibold text-gray-700 text-center">Unit Type</th>
                                        <th class="px-6 py-3 border-b font-semibold text-gray-700 text-right">Subtotal</th>
                                        <th class="px-6 py-3 border-b font-semibold text-gray-700 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $idx => $item)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 border-b align-middle">
                                                <select name="items[{{ $idx }}][product_id]" required
                                                    class="product-select border border-gray-300 rounded px-2 py-1 w-full focus:ring-2 focus:ring-blue-500">
                                                    <option value="">Select product</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}"
                                                            data-base-price="{{ $product->base_price }}"
                                                            data-default-quantity="{{ $product->default_quantity ?? 1 }}"
                                                            data-unit-type="{{ $product->unit_type }}"
                                                            data-unit-value="{{ $product->unit_value }}"
                                                            @if ($item->product_id == $product->id) selected @endif>
                                                            {{ $product->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-6 py-4 border-b text-right align-middle">
                                                <input type="number" step="0.01" min="0"
                                                    name="items[{{ $idx }}][unit_price]"
                                                    value="{{ $item->unit_price }}" required
                                                    class="w-24 px-2 py-1 border border-gray-300 rounded text-right item-price focus:ring-2 focus:ring-blue-500">
                                            </td>
                                            <td class="px-6 py-4 border-b text-center align-middle">
                                                <input type="number" step="0.01" min="0.01"
                                                    name="items[{{ $idx }}][quantity]"
                                                    value="{{ $item->quantity }}" required
                                                    class="w-24 px-2 py-1 border border-gray-300 rounded text-right item-qty focus:ring-2 focus:ring-blue-500">
                                            </td>
                                            <td class="px-6 py-4 border-b text-center align-middle">
                                                <input type="number" step="0.01" min="0"
                                                    name="items[{{ $idx }}][unit_value]"
                                                    value="{{ $item->product->unit_value ?? '' }}" required
                                                    class="w-20 px-2 py-1 border border-gray-100 rounded text-center item-unit-value bg-gray-100" readonly>
                                            </td>
                                            <td class="px-6 py-4 border-b text-center align-middle">
                                                <input type="text"
                                                    name="items[{{ $idx }}][unit_type]"
                                                    value="{{ $item->product->unit_type ?? '' }}" required
                                                    class="w-24 px-2 py-1 border border-gray-100 rounded text-center item-unit-type bg-gray-100" readonly>
                                            </td>
                                            <td class="px-6 py-4 border-b text-right align-middle">
                                                ₹<span class="item-subtotal font-semibold text-gray-800">0.00</span>
                                            </td>
                                            <td class="px-6 py-4 border-b text-center align-middle">
                                                <button type="button"
                                                    class="delete-row-btn text-red-600 hover:text-red-800 font-bold px-3 py-1 rounded transition"
                                                    onclick="removeRow(this)">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-right font-bold text-gray-700">Total</td>
                                        <td class="px-6 py-4 text-right font-bold text-gray-900">₹<span id="order-total">0.00</span></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <button type="button" id="add-item-btn"
                                class="mt-4 bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded shadow font-semibold transition">+
                                Add Item</button>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="px-6 py-4 bg-gray-50 border-t flex justify-between items-center">
                        <div class="flex space-x-3">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                                Update Order
                            </button>
                        </div>
                        <a href="{{ route('orders.index') }}"
                            class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                            ← Back to Orders
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const products = @json($products);

        function updateSubtotal(tr) {
            const price = parseFloat(tr.querySelector('.item-price').value) || 0;
            const qty = parseFloat(tr.querySelector('.item-qty').value) || 0;
            const subtotal = price * qty;
            tr.querySelector('.item-subtotal').innerText = subtotal.toFixed(2);
        }

        function updateAllTotals() {
            let total = 0;
            document.querySelectorAll('#order-items-table tbody tr').forEach(tr => {
                updateSubtotal(tr);
                total += parseFloat(tr.querySelector('.item-subtotal').innerText) || 0;
            });
            document.getElementById('order-total').innerText = total.toFixed(2);
        }

        document.getElementById('add-item-btn').addEventListener('click', function() {
            const tbody = document.querySelector('#order-items-table tbody');
            const rowCount = tbody.children.length;
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="px-6 py-4 border-b align-middle">
                    <select name="items[${rowCount}][product_id]" required class="product-select border border-gray-300 rounded px-2 py-1 w-full focus:ring-2 focus:ring-blue-500">
                        <option value="">Select product</option>
                        ${products.map(p => `<option value="${p.id}" data-base-price="${p.base_price}" data-default-quantity="${p.default_quantity ?? 1}" data-unit-type="${p.unit_type}" data-unit-value="${p.unit_value}">${p.name}</option>`).join('')}
                    </select>
                </td>
                <td class="px-6 py-4 border-b text-right align-middle">
                    <input type="number" step="0.01" min="0" name="items[${rowCount}][unit_price]" value="0" required class="w-24 px-2 py-1 border border-gray-300 rounded text-right item-price focus:ring-2 focus:ring-blue-500">
                </td>
                <td class="px-6 py-4 border-b text-center align-middle">
                    <input type="number" step="0.01" min="0.01" name="items[${rowCount}][quantity]" value="1" required class="w-24 px-2 py-1 border border-gray-300 rounded text-right item-qty focus:ring-2 focus:ring-blue-500">
                </td>
                <td class="px-6 py-4 border-b text-center align-middle">
                    <input type="number" step="0.01" min="0" name="items[${rowCount}][unit_value]" value="" required class="w-20 px-2 py-1 border border-gray-100 rounded text-center item-unit-value bg-gray-100" readonly>
                </td>
                <td class="px-6 py-4 border-b text-center align-middle">
                    <input type="text" name="items[${rowCount}][unit_type]" value="" required class="w-24 px-2 py-1 border border-gray-100 rounded text-center item-unit-type bg-gray-100" readonly>
                </td>
                <td class="px-6 py-4 border-b text-right align-middle">
                    ₹<span class="item-subtotal font-semibold text-gray-800">0.00</span>
                </td>
                <td class="px-6 py-4 border-b text-center align-middle">
                    <button type="button" class="delete-row-btn text-red-600 hover:text-red-800 font-bold px-3 py-1 rounded transition" onclick="removeRow(this)">Delete</button>
                </td>
            `;
            tbody.appendChild(tr);
            attachRowListeners(tr);
            updateAllTotals();
        });

        window.removeRow = function(btn) {
            btn.closest('tr').remove();
            updateAllTotals();
        };

        function attachRowListeners(tr) {
            tr.querySelector('.product-select').addEventListener('change', function(e) {
                const selected = e.target.selectedOptions[0];
                const basePrice = selected.getAttribute('data-base-price');
                const defaultQty = selected.getAttribute('data-default-quantity');
                const unitType = selected.getAttribute('data-unit-type');
                const unitValue = selected.getAttribute('data-unit-value');
                if (basePrice !== null && basePrice !== "") {
                    tr.querySelector('.item-price').value = parseFloat(basePrice).toFixed(2);
                }
                if (defaultQty !== null && defaultQty !== "") {
                    tr.querySelector('.item-qty').value = parseFloat(defaultQty);
                }
                // Auto-fill and lock unit_value/unit_type
                if (unitType !== null) {
                    tr.querySelector('.item-unit-type').value = unitType;
                }
                if (unitValue !== null && unitValue !== "" && unitValue !== "null") {
                    tr.querySelector('.item-unit-value').value = unitValue;
                } else {
                    tr.querySelector('.item-unit-value').value = "";
                }
                updateSubtotal(tr);
                updateAllTotals();
            });
            tr.querySelector('.item-price').addEventListener('input', () => {
                updateSubtotal(tr);
                updateAllTotals();
            });
            tr.querySelector('.item-qty').addEventListener('input', () => {
                updateSubtotal(tr);
                updateAllTotals();
            });
        }

        document.querySelectorAll('#order-items-table tbody tr').forEach(tr => {
            attachRowListeners(tr);
        });

        updateAllTotals();
    </script>
</x-app-layout>