<x-app-layout>
    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6">
            <!-- Page Title -->
            <div class="mb-4 sm:mb-6">
                <h1 class="text-2xl sm:text-3xl font-semibold text-gray-900">Order Details</h1>
                <p class="text-gray-600 mt-1 text-sm sm:text-base">View and manage order information</p>
            </div>

            <div class="bg-white shadow-sm rounded-lg border">
                <!-- Order Header -->
                <div class="px-2 sm:px-4 py-2 sm:py-4 border-b">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-base sm:text-lg font-medium text-gray-700">#{{ $order->id }}</span>
                        </div>
                        <div>
                            <h2 class="text-lg sm:text-xl font-semibold text-gray-900">Order #{{ $order->id }}</h2>
                            <p class="text-gray-500 text-sm sm:text-base">Status: {{ ucfirst($order->status) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Order Information -->
                <div class="px-2 sm:px-4 py-2 sm:py-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <label class="w-32 text-xs sm:text-sm font-medium text-gray-500 mb-1">Customer</label>
                                <p class="text-gray-900 text-sm sm:text-base ml-2">{{ $order->customer->name ?? '-' }}
                                </p>
                            </div>
                            <div class="flex items-center">
                                <label class="w-32 text-xs sm:text-sm font-medium text-gray-500 mb-1">Customer
                                    Phone</label>
                                <p class="text-gray-900 text-sm sm:text-base ml-2">{{ $order->customer->phone ?? '-' }}
                                </p>
                            </div>
                            <div class="flex items-center">
                                <label class="w-32 text-xs sm:text-sm font-medium text-gray-500 mb-1">Handled By</label>
                                <p class="text-gray-900 text-sm sm:text-base ml-2">{{ $order->user->name ?? '-' }}</p>
                            </div>
                            <div class="flex items-center">
                                <label class="w-32 text-xs sm:text-sm font-medium text-gray-500 mb-1">Order Date</label>
                                <p class="text-gray-900 text-sm sm:text-base ml-2">
                                    {{ $order->order_date ? $order->order_date->format('M d, Y') : $order->created_at->format('M d, Y') }}
                                </p>
                            </div>
                            <div class="flex items-center">
                                <label class="w-32 text-xs sm:text-sm font-medium text-gray-500 mb-1">Order
                                    Status</label>
                                <p class="text-gray-900 text-sm sm:text-base ml-2">
                                    <span
                                        class="@if ($order->status === 'completed') text-green-600 @elseif($order->status === 'pending') text-yellow-600 @else text-red-600 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </p>
                            </div>

                        </div>

                        <div class="space-y-4 md:mt-0">
                            <div class="flex items-center">
                                <label class="w-32 text-xs sm:text-sm font-medium text-gray-500 mb-1">Total</label>
                                <p class="text-gray-900 text-sm sm:text-base font-semibold ml-2">
                                    ₹{{ number_format($order->total, 2) }}</p>
                            </div>
                            <div class="flex items-center">
                                <label class="w-32 text-xs sm:text-sm font-medium text-gray-500 mb-1">Paid
                                    Amount</label>
                                <p class="text-gray-900 text-sm sm:text-base font-semibold ml-2">
                                    ₹{{ number_format($order->payment?->paymentItems->sum('amount') ?? 0, 2) }}
                                </p>
                            </div>
                            <div class="flex items-center">
                                <label class="w-32 text-xs sm:text-sm font-medium text-gray-500 mb-1">Remaining
                                    Amount</label>
                                <p class="text-gray-900 text-sm sm:text-base ml-2">
                                    ₹{{ number_format($order->payment->balance ?? 0, 2) }}</p>
                            </div>
                            <div class="flex items-center">
                                <label class="w-32 text-xs sm:text-sm font-medium text-gray-500 mb-1">Payment
                                    Status</label>
                                <p class="text-gray-900 text-sm sm:text-base ml-2">
                                    @if ($order->payment)
                                        <a href="{{ route('payments.show', $order->payment) }}"
                                            class="@if ($order->payment->status === 'completed') text-green-600 @elseif($order->payment->status === 'pending') text-yellow-600 @else text-red-600 @endif hover:text-blue-600">
                                            {{ ucfirst($order->payment->status ?? '-') }}
                                        </a>
                                    @else
                                        <span class="text-gray-400">Not yet Order Completed</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="px-2 sm:px-4 py-2 sm:py-4">
                    <h4 class="text-base sm:text-lg font-semibold mb-2 sm:mb-4">Order Items</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border text-xs sm:text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-2 sm:px-4 py-2 text-left font-medium text-gray-500 uppercase">S.No
                                    </th>
                                    <th class="px-2 sm:px-4 py-2 text-left font-medium text-gray-500 uppercase">Product
                                    </th>
                                    <th class="px-2 sm:px-4 py-2 text-left font-medium text-gray-500 uppercase">
                                        Quantity/Weight</th>
                                    <th class="px-2 sm:px-4 py-2 text-left font-medium text-gray-500 uppercase">Unit
                                        Price</th>
                                    <th class="px-2 sm:px-4 py-2 text-left font-medium text-gray-500 uppercase">Subtotal
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td class="px-2 sm:px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="px-2 sm:px-4 py-2">{{ $item->product->name ?? '-' }}</td>
                                        <td class="px-2 sm:px-4 py-2">
                                            {{ $item->quantity }}
                                            @if ($item->product->unit_type !== 'piece')
                                                {{ $item->product->unit_type }}
                                            @endif
                                        </td>
                                        <td class="px-2 sm:px-4 py-2">₹{{ number_format($item->unit_price, 2) }}</td>
                                        <td class="px-2 sm:px-4 py-2">₹{{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="px-2 sm:px-4 py-2 text-right font-semibold">Total</td>
                                    <td class="px-2 sm:px-4 py-2 font-semibold">
                                        ₹{{ number_format($order->items->sum('subtotal'), 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Actions -->
                <div
                    class="px-2 sm:px-4 py-2 sm:py-3 bg-gray-50 border-t flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-2 sm:space-y-0">
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3 w-full sm:w-auto">
                        <a href="{{ route('orders.edit', $order) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition text-center">
                            Edit Order
                        </a>
                        <form action="{{ route('orders.destroy', $order) }}" method="POST" class="inline"
                            onsubmit="return confirm('Are you sure you want to delete this order?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-md text-sm font-medium transition text-center w-full sm:w-auto">
                                Delete
                            </button>
                        </form>
                    </div>
                    <a href="{{ route('orders.index') }}"
                        class="text-gray-500 hover:text-gray-700 text-sm font-medium mt-2 sm:mt-0">
                        ← Back to Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
