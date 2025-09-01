<x-app-layout>
    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6">
            <!-- Page Title -->
            <div class="mb-4 sm:mb-6">
                <h1 class="text-2xl sm:text-3xl font-semibold text-gray-900">Payment Details</h1>
                <p class="text-gray-600 mt-1 text-sm sm:text-base">View and manage payment information</p>
            </div>

            <div class="bg-white shadow-sm rounded-lg border">
                <!-- Payment Header -->
                <div class="px-2 sm:px-4 py-2 sm:py-4 border-b">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-base sm:text-lg font-medium text-gray-700">#</span>
                        </div>
                        <div class="mt-2 sm:mt-0 sm:ml-4">
                            <h2 class="text-lg sm:text-xl font-semibold text-gray-900">Order #{{ $payment->order_id }}
                            </h2>
                            <p class="text-gray-500 text-sm sm:text-base">
                                {{ $payment->order->customer->name ?? 'No Customer' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="px-2 sm:px-4 py-2 sm:py-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <div class="space-y-3 sm:space-y-4">
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-500 mb-1">Customer</label>
                                <p class="text-gray-900 text-sm sm:text-base">
                                    {{ $payment->order->customer->name ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-500 mb-1">Total
                                    Amount</label>
                                <p class="text-gray-900 text-sm sm:text-base font-semibold">
                                    ₹{{ number_format($payment->total_amount, 2) }}</p>
                            </div>
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-500 mb-1">Paid</label>
                                <p class="text-gray-900 text-sm sm:text-base font-semibold">
                                    ₹{{ number_format($payment->paymentItems->sum('amount'), 2) }}</p>
                            </div>
                        </div>
                        <div class="space-y-3 sm:space-y-4 md:mt-0">
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-500 mb-1">Phone
                                    Number</label>
                                <p class="text-gray-900 text-sm sm:text-base">
                                    {{ $payment->order->customer->phone ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-500 mb-1">Remaining</label>
                                <p class="text-gray-900 text-sm sm:text-base font-semibold">
                                    ₹{{ number_format($payment->balance, 2) }}</p>
                            </div>
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-500 mb-1">Status</label>
                                <p class="text-gray-900 text-sm sm:text-base">
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
                <div class="px-2 sm:px-4 py-2 sm:py-4 border-t">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2 sm:mb-4">Payment Statement</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border rounded-lg text-xs sm:text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-2 sm:px-4 py-2 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider">
                                        #</th>
                                    <th
                                        class="px-2 sm:px-4 py-2 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider">
                                        Amount</th>
                                    <th
                                        class="px-2 sm:px-4 py-2 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider">
                                        Method</th>
                                    <th
                                        class="px-2 sm:px-4 py-2 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider">
                                        Details</th>
                                    <th
                                        class="px-2 sm:px-4 py-2 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider">
                                        Paid At</th>
                                    <th
                                        class="px-2 sm:px-4 py-2 sm:py-3 text-left font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($payment->paymentItems as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-2 sm:px-4 py-2 sm:py-3 text-gray-900">{{ $loop->iteration }}</td>
                                        <td class="px-2 sm:px-4 py-2 sm:py-3 font-medium text-gray-900">
                                            ₹{{ number_format($item->amount, 2) }}</td>
                                        <td class="px-2 sm:px-4 py-2 sm:py-3 text-gray-900">{{ $item->method }}</td>
                                        <td class="px-2 sm:px-4 py-2 sm:py-3 text-gray-900">{{ $item->details }}</td>
                                        <td class="px-2 sm:px-4 py-2 sm:py-3 text-gray-900">
                                            {{ $item->paid_at ? \Carbon\Carbon::parse($item->paid_at)->format('M d, Y ') : '-' }}
                                        </td>
                                        <td class="px-2 sm:px-4 py-2 sm:py-3">
                                            <button class="text-blue-600 hover:text-blue-700 font-medium"
                                                onclick="openPaymentEditModal({{ $payment->id }}, {{ $item->id }}, {{ json_encode($item) }})">Edit</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-2 sm:px-4 py-6 sm:py-8 text-center">
                                            <p class="text-gray-500 mb-2 sm:mb-4">No payments made yet</p>
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
                <div
                    class="px-2 sm:px-4 py-2 sm:py-3 bg-gray-50 border-t flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-2 sm:space-y-0">
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3 w-full sm:w-auto">
                        @if ($payment->balance > 0)
                            <button
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition text-center"
                                onclick="openPaymentAddModal({{ $payment->id }})">
                                Add Payment
                            </button>
                        @endif
                    </div>
                    <a href="{{ route('orders.show', $payment->order_id) }}"
                        class="text-gray-500 hover:text-gray-700 text-sm font-medium mt-2 sm:mt-0">
                        ← Back to Order
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Payment Modal -->
    <div id="addPaymentModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-lg shadow-xl p-4 sm:p-8 w-full max-w-lg mx-2 sm:mx-0">
            <h2 class="text-xl sm:text-2xl font-bold mb-3 text-gray-800">Add Payment for Order
                #{{ $payment->order_id }}</h2>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-md p-3 mb-4">
                    <ul class="list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 rounded-md p-3 mb-4">
                    <p class="text-sm text-green-600">{{ session('success') }}</p>
                </div>
            @endif

            <div class="flex flex-col sm:flex-row sm:items-center gap-1">
                <span class="text-sm text-gray-600">Order Total:</span>
                <span
                    class="text-sm font-semibold text-gray-900">₹{{ number_format($payment->total_amount, 2) }}</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center gap-1 mt-1 mb-3">
                <span class="text-sm text-gray-600">Remaining Balance:</span>
                <span class="text-sm font-semibold text-gray-900">₹{{ number_format($payment->balance, 2) }}</span>
            </div>

            <form id="addPaymentForm" method="POST" action="{{ route('payments.addPayment', $payment->id) }}">
                @csrf
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700 mb-1">Amount</label>
                    <input type="number" min="0.01" step="0.01" name="amount" id="paymentAmount" required
                        max="{{ $payment->balance }}" class="w-full px-4 py-2 border rounded"
                        placeholder="Maximum: ₹{{ number_format($payment->balance, 2) }}" />
                    <small class="text-gray-500">Maximum amount you can add:
                        ₹{{ number_format($payment->balance, 2) }}</small>
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

                <div class="flex flex-col sm:flex-row gap-2">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded w-full sm:w-auto">Add
                        Payment</button>
                    <button type="button" onclick="closeModal('addPaymentModal')"
                        class="bg-gray-200 text-black px-4 py-2 rounded w-full sm:w-auto">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Payment Item Modal -->
    <div id="editPaymentModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-lg shadow-xl p-4 sm:p-8 w-full max-w-lg mx-2 sm:mx-0">
            <h2 class="text-xl sm:text-2xl font-bold mb-3 text-gray-800">Edit Payment Item</h2>
            <div class="flex flex-col sm:flex-row sm:items-center gap-1">
                <span class="text-sm text-gray-600">Order Total:</span>
                <span
                    class="text-sm font-semibold text-gray-900">₹{{ number_format($payment->total_amount, 2) }}</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center gap-1 mt-1 mb-3">
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

                <div class="flex flex-col sm:flex-row gap-2">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded w-full sm:w-auto">Update
                        Payment Item</button>
                    <button type="button" onclick="closeModal('editPaymentModal')"
                        class="bg-gray-200 text-black px-4 py-2 rounded w-full sm:w-auto">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Simple Modal JS -->
    <script>
        const remainingBalance = {{ $payment->balance }};

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function openPaymentAddModal(paymentId) {
            document.getElementById('addPaymentModal').classList.remove('hidden');
            // Reset form
            document.getElementById('addPaymentForm').reset();
            // Set default date
            document.querySelector('input[name="paid_at"]').value = new Date().toISOString().slice(0, 10);
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

        // Add payment form validation
        document.getElementById('addPaymentForm').addEventListener('submit', function(e) {
            const amountInput = document.getElementById('paymentAmount');
            const amount = parseFloat(amountInput.value);

            if (amount > remainingBalance) {
                e.preventDefault();
                alert(
                    `Payment amount (₹${amount.toFixed(2)}) cannot exceed the remaining balance (₹${remainingBalance.toFixed(2)})`);
                amountInput.focus();
                return false;
            }

            if (amount <= 0) {
                e.preventDefault();
                alert('Payment amount must be greater than zero');
                amountInput.focus();
                return false;
            }
        });

        // Real-time validation for amount input
        document.getElementById('paymentAmount').addEventListener('input', function() {
            const amount = parseFloat(this.value);
            const submitButton = document.querySelector('#addPaymentForm button[type="submit"]');

            if (amount > remainingBalance) {
                this.setCustomValidity(`Amount cannot exceed ₹${remainingBalance.toFixed(2)}`);
                submitButton.disabled = true;
                submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            } else if (amount <= 0) {
                this.setCustomValidity('Amount must be greater than zero');
                submitButton.disabled = true;
                submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                this.setCustomValidity('');
                submitButton.disabled = false;
                submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        });

        document.getElementById('addPaymentModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal('addPaymentModal');
        });
        document.getElementById('editPaymentModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal('editPaymentModal');
        });
    </script>
</x-app-layout>
