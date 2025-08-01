<x-app-layout>
    <x-slot name="page-title">Payments</x-slot>

    <div class="bg-gray-100 min-h-screen py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-4xl font-bold text-gray-800">Payments</h1>
            </div>

            <form method="GET" action="{{ route('payments.index') }}" class="mb-6 flex flex-wrap items-center gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search payments..."
                    class="border border-gray-300 bg-white text-gray-800 rounded-lg px-4 py-2 w-full sm:w-72 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit"
                    class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg shadow">Search</button>
                @if(request('search'))
                    <a href="{{ route('payments.index') }}" class="text-blue-600 hover:underline">Clear</a>
                @endif
            </form>

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-2 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
                <table class="min-w-full divide-y divide-gray-300 text-center">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-gray-700 text-center">#</th>
                            <th class="px-6 py-3 font-semibold text-gray-700 text-center">Order</th>
                            <th class="px-6 py-3 font-semibold text-gray-700 text-center">Customer</th>
                            <th class="px-6 py-3 font-semibold text-gray-700 text-center">Total Amount</th>
                            <th class="px-6 py-3 font-semibold text-gray-700 text-center">Paid</th>
                            <th class="px-6 py-3 font-semibold text-gray-700 text-center">Balance</th>
                            <th class="px-6 py-3 font-semibold text-gray-700 text-center">Status</th>
                            <th class="px-6 py-3 font-semibold text-gray-700 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-gray-50 transition-all text-center">
                                <td class="px-6 py-4">{{ $loop->iteration + ($payments->currentPage() - 1) * $payments->perPage() }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('orders.show', $payment->order_id) }}" class="text-blue-700 hover:underline font-semibold">#{{ $payment->order_id }}</a>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $payment->order->customer->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4">₹{{ number_format($payment->total_amount, 2) }}</td>
                                <td class="px-6 py-4">₹{{ number_format($payment->paymentItems->sum('amount'), 2) }}</td>
                                <td class="px-6 py-4">₹{{ number_format($payment->balance, 2) }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'completed' => 'bg-green-100 text-green-800',
                                            'failed' => 'bg-red-100 text-red-800',
                                        ];
                                        $colorClass = $statusColors[$payment->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-3 py-1 rounded-full font-semibold {{ $colorClass }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap items-center justify-center gap-2">
                                        <a href="{{ route('payments.show', $payment->id) }}"
                                            class="text-sm font-semibold text-blue-600 hover:text-blue-800 px-3 py-1 rounded">View</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500">No payments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-center">{{ $payments->links() }}</div>
        </div>
    </div>
</x-app-layout>