<x-app-layout>
    <x-slot name="page-title">Orders</x-slot>

    <div class="bg-gray-100 min-h-screen py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-4xl font-bold text-gray-800">Orders</h1>
                <a href="{{ route('orders.create') }}"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-xl shadow transition-all duration-300">
                    <span class="font-semibold">Create Order</span>
                </a>
            </div>
            <div class="mb-6 flex flex-wrap items-center gap-3">
                <form method="GET" action="{{ route('orders.index') }}" class="flex flex-wrap items-center gap-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search orders..."
                        class="border border-gray-300 bg-white text-gray-800 rounded-lg px-4 py-2 w-full sm:w-72 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit"
                        class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg shadow">Search</button>
                    @if (request('search'))
                        <a href="{{ route('orders.index') }}" class="text-blue-600 hover:underline">Clear</a>
                    @endif
                </form>
                <!-- Export Button -->
                <button type="button"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow font-semibold"
                    onclick="document.getElementById('export-modal').classList.remove('hidden')">
                    <i class="fas fa-file-pdf"></i> Export Sales PDF
                </button>
            </div>

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
                            <th class="px-6 py-3 font-semibold text-gray-700 text-center">Customer Name</th>
                            <th class="px-6 py-3 font-semibold text-gray-700 text-center">Phone No </th>
                            <th class="px-6 py-3 font-semibold text-gray-700 text-center">Total</th>
                            <th class="px-6 py-3 font-semibold text-gray-700 text-center">Status</th>
                            <th class="px-6 py-3 font-semibold text-gray-700 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50 transition-all text-center">
                                <td class="px-6 py-4">
                                    {{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $order->customer?->name }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $order->customer?->phone }}</td>
                                <td class="px-6 py-4">{{ number_format($order->total, 2) }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'completed' => 'bg-green-100 text-green-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                        ];
                                        $colorClass = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-3 py-1 rounded-full font-semibold {{ $colorClass }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap items-center justify-center gap-2">
                                        <a href="{{ route('orders.pdf', $order->id) }}"
                                            class="text-sm font-semibold text-green-600 hover:text-green-800 px-3 py-1 rounded">Download
                                            PDF</a>
                                        <a href="{{ route('orders.show', $order) }}"
                                            class="text-sm font-semibold text-blue-600 hover:text-blue-800 px-3 py-1 rounded">View</a>
                                        <a href="{{ route('orders.edit', $order) }}"
                                            class="text-sm font-semibold text-yellow-600 hover:text-yellow-800 px-3 py-1 rounded">Edit</a>
                                        <form action="{{ route('orders.destroy', $order) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this order?')"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-sm font-semibold text-red-600 hover:text-red-800 px-3 py-1 rounded">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-center">{{ $orders->links() }}</div>
        </div>
    </div>

    <!-- Export Modal -->
    <div id="export-modal"
        class="fixed inset-0 z-50 bg-black bg-opacity-40 flex items-center justify-center hidden">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-8 relative">
            <button type="button"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-xl font-bold"
                onclick="document.getElementById('export-modal').classList.add('hidden')">&times;</button>
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">Export Sales PDF</h2>
            <form method="GET" action="{{ route('orders.exportSalesPdf') }}" target="_blank" class="space-y-4">
                <div>
                    <label class="font-semibold text-gray-700 mb-2 block">Select Range:</label>
                    <div class="grid grid-cols-2 gap-2">
                        <label><input type="radio" name="range" value="today" checked> Today</label>
                        <label><input type="radio" name="range" value="7"> Last 7 Days</label>
                        <label><input type="radio" name="range" value="15"> Last 15 Days</label>
                        <label><input type="radio" name="range" value="30"> Last 30 Days</label>
                        <label><input type="radio" name="range" value="6months"> Last 6 Months</label>
                        <label><input type="radio" name="range" value="custom"> Custom Range</label>
                    </div>
                </div>
                <div id="custom-range-fields" class="grid grid-cols-2 gap-2 mt-2" style="display:none;">
                    <div>
                        <label for="from" class="block text-gray-700">From:</label>
                        <input type="date" name="from" id="from"
                            class="border rounded px-2 py-1 w-full">
                    </div>
                    <div>
                        <label for="to" class="block text-gray-700">To:</label>
                        <input type="date" name="to" id="to"
                            class="border rounded px-2 py-1 w-full">
                    </div>
                </div>
                <div class="mt-4 flex justify-end">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-semibold shadow">Export PDF</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('input[name="range"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                document.getElementById('custom-range-fields').style.display =
                    this.value === 'custom' ? 'grid' : 'none';
            });
        });
    </script>
</x-app-layout>