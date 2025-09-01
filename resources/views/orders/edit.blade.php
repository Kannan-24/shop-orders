<x-app-layout>
    <x-slot name="page-title">Edit Order</x-slot>
    <div class="py-0 lg:py-12">
        <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6">
            <!-- Page Title -->
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Edit Order #{{ $order->id }}</h1>
                <p class="text-gray-600 mt-1">Update order details below</p>
            </div>

            <div class="bg-white shadow-sm rounded-lg border">
                <!-- Header -->
                <div class="px-2 sm:px-4 py-4 border-b">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-lg font-medium text-gray-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 7v4a1 1 0 001 1h3m10-5v4a1 1 0 01-1 1h-3m-4 4h4m-2 0v4m0 0a9 9 0 100-18 9 9 0 000 18z" />
                                </svg>
                            </span>
                        </div>
                        <div class="ml-3">
                            <h2 class="text-lg font-semibold text-gray-900">Edit Order</h2>
                            <p class="text-gray-500">Modify the order information below</p>
                        </div>
                    </div>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="px-2 sm:px-4 py-3 border-b bg-red-50">
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
                    <div class="px-2 sm:px-4 py-4 flex justify-center">
                        <div class="w-full sm:w-3/4 md:w-1/2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label for="customer_id" class="block text-sm font-medium text-gray-500 mb-1">
                                        Customer <span class="text-red-500">*</span>
                                    </label>
                                    <select name="customer_id" id="customer_id" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                                    <label for="order_date" class="block text-sm font-medium text-gray-500 mb-1">
                                        Order Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="order_date" id="order_date" required
                                        value="{{ old('order_date', $order->order_date ? $order->order_date->format('Y-m-d') : date('Y-m-d')) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-500 mb-1">
                                        Status <span class="text-red-500">*</span>
                                    </label>
                                    <select name="status" id="status" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                    <div class="px-2 sm:px-4 py-4">
                        <h3 class="text-lg font-semibold mb-3 text-gray-800">Order Items</h3>
                        <div class="overflow-x-auto mb-6">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm"
                                id="order-items-table">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 border-b font-semibold text-gray-700 text-left">Product</th>
                                        <th class="px-4 py-2 border-b font-semibold text-gray-700 text-right">Price</th>
                                        <th class="px-4 py-2 border-b font-semibold text-gray-700 text-center">Qty</th>
                                        <th class="px-4 py-2 border-b font-semibold text-gray-700 text-center">Unit Value</th>
                                        <th class="px-4 py-2 border-b font-semibold text-gray-700 text-center">Unit Type</th>
                                        <th class="px-4 py-2 border-b font-semibold text-gray-700 text-right">Subtotal</th>
                                        <th class="px-4 py-2 border-b font-semibold text-gray-700 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $idx => $item)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-4 py-2 border-b align-middle">
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
                                            <td class="px-4 py-2 border-b text-right align-middle">
                                                <input type="number" step="0.01" min="0"
                                                    name="items[{{ $idx }}][unit_price]"
                                                    value="{{ $item->unit_price }}" required
                                                    class="w-20 px-2 py-1 border border-gray-300 rounded text-right item-price focus:ring-2 focus:ring-blue-500">
                                            </td>
                                            <td class="px-4 py-2 border-b text-center align-middle">
                                                <input type="number" step="0.01" min="0.01"
                                                    name="items[{{ $idx }}][quantity]"
                                                    value="{{ $item->quantity }}" required
                                                    class="w-20 px-2 py-1 border border-gray-300 rounded text-right item-qty focus:ring-2 focus:ring-blue-500">
                                            </td>
                                            <td class="px-4 py-2 border-b text-center align-middle">
                                                <input type="number" step="0.01" min="0"
                                                    name="items[{{ $idx }}][unit_value]"
                                                    value="{{ $item->product->unit_value ?? '' }}" required
                                                    class="w-16 px-2 py-1 border border-gray-100 rounded text-center item-unit-value bg-gray-100" readonly>
                                            </td>
                                            <td class="px-4 py-2 border-b text-center align-middle">
                                                <input type="text"
                                                    name="items[{{ $idx }}][unit_type]"
                                                    value="{{ $item->product->unit_type ?? '' }}" required
                                                    class="w-20 px-2 py-1 border border-gray-100 rounded text-center item-unit-type bg-gray-100" readonly>
                                            </td>
                                            <td class="px-4 py-2 border-b text-right align-middle">
                                                ₹<span class="item-subtotal font-semibold text-gray-800">0.00</span>
                                            </td>
                                            <td class="px-4 py-2 border-b text-center align-middle">
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
                                        <td colspan="6" class="px-4 py-2 text-right font-bold text-gray-700">Total</td>
                                        <td class="px-4 py-2 text-right font-bold text-gray-900">₹<span id="order-total">0.00</span></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <button type="button" id="add-item-btn"
                                class="mt-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow font-semibold transition">
                                Add Item
                            </button>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="px-2 sm:px-4 py-3 bg-gray-50 border-t flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0">
                        <div class="flex space-x-2 w-full sm:w-auto">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-sm font-medium transition w-full sm:w-auto">
                                Update Order
                            </button>
                        </div>
                        <a href="{{ route('orders.index') }}"
                            class="text-gray-500 hover:text-gray-700 text-sm font-medium w-full sm:w-auto text-center">
                            ← Back to Orders
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // ... (keep your JS as is)
    </script>
</x-app-layout>
