<x-app-layout>
    <x-slot name="page-title">Payments</x-slot>

    <div class="bg-gradient-to-br from-blue-50 to-gray-100 min-h-screen py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-5xl font-extrabold text-blue-900 tracking-tight">Payments</h1>
            </div>

            <form method="GET" action="{{ route('payments.index') }}" class="mb-8 flex flex-wrap items-center gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search payments..."
                    class="border border-blue-300 bg-white text-gray-800 rounded-xl px-5 py-3 w-full sm:w-80 shadow focus:outline-none focus:ring-2 focus:ring-blue-400">
                <button type="submit"
                    class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-3 rounded-xl shadow font-semibold transition">Search</button>
                @if(request('search'))
                    <a href="{{ route('payments.index') }}" class="text-blue-600 hover:underline font-medium">Clear</a>
                @endif
            </form>

            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-400 text-green-900 px-5 py-3 rounded-xl shadow font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto bg-white rounded-2xl shadow-2xl border border-blue-100">
                <table class="min-w-full divide-y divide-blue-200 text-center">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="px-6 py-4 font-bold text-blue-800 text-center">#</th>
                            <th class="px-6 py-4 font-bold text-blue-800 text-center">Order</th>
                            <th class="px-6 py-4 font-bold text-blue-800 text-center">Customer</th>
                            <th class="px-6 py-4 font-bold text-blue-800 text-center">Total Amount</th>
                            <th class="px-6 py-4 font-bold text-blue-800 text-center">Paid</th>
                            <th class="px-6 py-4 font-bold text-blue-800 text-center">Balance</th>
                            <th class="px-6 py-4 font-bold text-blue-800 text-center">Status</th>
                            <th class="px-6 py-4 font-bold text-blue-800 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-blue-100">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-blue-50 transition-all text-center">
                                <td class="px-6 py-4">{{ $loop->iteration + ($payments->currentPage() - 1) * $payments->perPage() }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('orders.show', $payment->order_id) }}" class="text-blue-700 hover:underline font-bold">#{{ $payment->order_id }}</a>
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-900">
                                    {{ $payment->order->customer->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4">₹{{ number_format($payment->total_amount, 2) }}</td>
                                <td class="px-6 py-4">₹{{ number_format($payment->paymentItems->sum('amount'), 2) }}</td>
                                <td class="px-6 py-4">₹{{ number_format($payment->balance, 2) }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-200 text-yellow-900',
                                            'completed' => 'bg-green-200 text-green-900',
                                            'failed' => 'bg-red-200 text-red-900',
                                        ];
                                        $colorClass = $statusColors[$payment->status] ?? 'bg-gray-200 text-gray-800';
                                    @endphp
                                    <span class="px-4 py-2 rounded-full font-bold {{ $colorClass }} shadow">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap items-center justify-center gap-2">
                                        <a href="{{ route('payments.show', $payment->id) }}"
                                            class="text-sm font-bold text-blue-700 hover:text-blue-900 px-4 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 shadow transition">View</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-6 text-center text-blue-400 font-semibold">No payments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-8 flex justify-center">{{ $payments->links() }}</div>
        </div>
    </div>
</x-app-layout>