<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Title -->
            <div class="mb-8">
                <h1 class="text-3xl font-semibold text-gray-900">Payment Details</h1>
                <p class="text-gray-600 mt-1">View and manage payment information</p>
            </div>

            <div class="bg-white shadow-sm rounded-lg border">
                <!-- Payment Header -->
                <div class="px-6 py-6 border-b">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-lg font-medium text-gray-700">#</span>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold text-gray-900">Order #{{ $payment->order_id }}</h2>
                            <p class="text-gray-500">{{ $payment->order->customer->name ?? 'No Customer' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="px-6 py-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Customer</label>
                                <p class="text-gray-900">{{ $payment->order->customer->name ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Total Amount</label>
                                <p class="text-gray-900 text-lg font-semibold">
                                    ₹{{ number_format($payment->total_amount, 2) }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Paid</label>
                                <p class="text-gray-900 text-lg font-semibold">
                                    ₹{{ number_format($payment->paymentItems->sum('amount'), 2) }}</p>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                                <p class="text-gray-900">{{ $payment->order->customer->phone ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Remaining</label>
                                <p class="text-gray-900 text-lg font-semibold">
                                    ₹{{ number_format($payment->balance, 2) }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                                <p class="text-gray-900">
                                    <span
                                        class="px-2 py-1 text-xs font-medium rounded-full 
                                        @if ($payment->status == 'completed') bg-green-100 text-green-800 
                                        @elseif($payment->status == 'pending') bg-yellow-100 text-yellow-800 
                                        @elseif($payment->status == 'partial') bg-orange-100 text-orange-800 
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Statement -->
                <div class="px-6 py-6 border-t">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Statement</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border rounded-lg">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        #</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Method</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Details</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Paid At</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($payment->paymentItems as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                            ₹{{ number_format($item->amount, 2) }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $item->method }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $item->details }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            {{ $item->paid_at ? \Carbon\Carbon::parse($item->paid_at)->format('M d, Y ') : '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <button class="text-blue-600 hover:text-blue-700 font-medium"
                                                onclick="openPaymentEditModal({{ $payment->id }}, {{ $item->id }}, {{ json_encode($item) }})">Edit</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-8 text-center">
                                            <p class="text-gray-500 mb-4">No payments made yet</p>
                                            <button class="text-blue-600 hover:text-blue-700 font-medium"
                                                onclick="openPaymentAddModal({{ $payment->id }})">
                                                Add Payment
                                            </button>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t flex justify-between items-center">
                    <div class="flex space-x-3">
                        @if ($payment->balance > 0 && $payment->paymentItems->count() > 0)
                            <button
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition"
                                onclick="openPaymentAddModal({{ $payment->id }})">
                                Add Payment
                            </button>
                        @endif
                    </div>
                    <a href="{{ route('orders.show', $payment->order_id) }}"
                        class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                        ← Back to Order
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Payment Modal -->
    <div id="addPaymentModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-lg">
            <h2 class="text-2xl font-bold mb-3 text-gray-800">Add Payment for Order #{{ $payment->order_id }}</h2>
            <div class="flex items-center">
                <span class="text-sm text-gray-600">Order Total:</span>
                <span class="text-sm font-semibold text-gray-900">₹{{ number_format($payment->total_amount, 2) }}</span>
            </div>
            <div class="flex items-center mt-1 mb-3">
                <span class="text-sm text-gray-600">Remaining Balance:</span>
                <span class="text-sm font-semibold text-gray-900">₹{{ number_format($payment->balance, 2) }}</span>
            </div>

            <form id="addPaymentForm" method="POST" action="{{ route('payments.addPayment', $payment->id) }}">
                @csrf
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700 mb-1">Amount</label>
                    <input type="number" min="1" step="0.01" name="amount" required
                        class="w-full px-4 py-2 border rounded" />
                </div>
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700 mb-1">Payment Method</label>
                    <select name="method" required class="w-full px-4 py-2 border rounded">
                        <option value="cash">Cash</option>
                        <option value="card">Card</option>
                        <option value="upi">UPI</option>
                        <option value="bank">Bank</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700 mb-1">Notes <span class="text-gray-500">(Eg:
                            Payment upi Id or Reference)</span></label>
                    <input type="text" name="details" class="w-full px-4 py-2 border rounded" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Paid At</label>
                    <input type="date" name="paid_at" value="{{ date('Y-m-d') }}" required
                        class="w-full px-4 py-2 border rounded" />
                </div>

                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">Add Payment</button>
                <button type="button" onclick="closeModal('addPaymentModal')"
                    class="ml-4 bg-gray-200 text-black px-4 py-2 rounded">Cancel</button>
            </form>
        </div>
    </div>

    <!-- Edit Payment Item Modal -->
    <div id="editPaymentModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-lg">
            <h2 class="text-2xl font-bold mb-3 text-gray-800">Edit Payment Item</h2>
            <div class="flex items-center">
                <span class="text-sm text-gray-600">Order Total:</span>
                <span class="text-sm font-semibold text-gray-900">₹{{ number_format($payment->total_amount, 2) }}</span>
            </div>
            <div class="flex items-center mt-1 mb-3">
                <span class="text-sm text-gray-600">Remaining Balance:</span>
                <span class="text-sm font-semibold text-gray-900">₹{{ number_format($payment->balance, 2) }}</span>
            </div>

            <form id="editPaymentForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700 mb-1">Amount</label>
                    <input type="number" min="1" step="0.01" name="amount" id="editAmount" required
                        class="w-full px-4 py-2 border rounded" />
                </div>
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700 mb-1">Payment Method</label>
                    <select name="method" id="editMethod" required class="w-full px-4 py-2 border rounded">
                        <option value="cash">Cash</option>
                        <option value="card">Card</option>
                        <option value="upi">UPI</option>
                        <option value="bank">Bank</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700 mb-1">Notes <span class="text-gray-500">(Eg:
                            Payment upi Id or Reference)</span></label>
                    <input type="text" name="details" id="editDetails" class="w-full px-4 py-2 border rounded" />
                </div>
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700 mb-1">Paid At</label>
                    <input type="date" name="paid_at" id="editPaidAt" required
                        class="w-full px-4 py-2 border rounded" />
                </div>

                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">Update Payment Item</button>
                <button type="button" onclick="closeModal('editPaymentModal')"
                    class="ml-4 bg-gray-200 text-black px-4 py-2 rounded">Cancel</button>
            </form>
        </div>
    </div>

    <!-- Simple Modal JS -->
    <script>
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function openPaymentAddModal(paymentId) {
            document.getElementById('addPaymentModal').classList.remove('hidden');
        }

        function openPaymentEditModal(paymentId, itemId, itemData) {
            var form = document.getElementById('editPaymentForm');
            form.action = `/payments/${paymentId}/items/${itemId}`;
            document.getElementById('editAmount').value = itemData.amount;
            document.getElementById('editMethod').value = itemData.method;
            document.getElementById('editDetails').value = itemData.details;
            var paidAtValue = itemData.paid_at ? new Date(itemData.paid_at) : new Date();
            var dateStr = paidAtValue.toISOString().slice(0, 10);
            document.getElementById('editPaidAt').value = dateStr;
            document.getElementById('editPaymentModal').classList.remove('hidden');
        }
        document.getElementById('addPaymentModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal('addPaymentModal');
        });
        document.getElementById('editPaymentModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal('editPaymentModal');
        });
    </script>
</x-app-layout>
