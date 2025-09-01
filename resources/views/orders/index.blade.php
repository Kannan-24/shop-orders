<x-app-layout>
    <x-slot name="page-title">Orders</x-slot>

    <div class="bg-gray-100 min-h-screen py-0 *:lg:py-12">
        <div class="max-w-7xl mx-auto sm:px-0 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-800">Orders</h1>
                <a href="{{ route('orders.create') }}"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 sm:px-5 py-2 rounded-xl shadow transition-all duration-300 w-full sm:w-auto justify-center">
                    <span class="font-semibold">Create Order</span>
                </a>
            </div>
            <div class="mb-6 flex flex-col sm:flex-row flex-wrap items-center gap-3">
                <form method="GET" action="{{ route('orders.index') }}" class="flex flex-1 flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search orders..."
                        class="border border-gray-300 bg-white text-gray-800 rounded-lg px-4 py-2 w-full sm:w-72 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit"
                        class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg shadow w-full sm:w-auto">Search</button>
                    @if(request('search'))
                        <a href="{{ route('orders.index') }}" class="text-blue-600 hover:underline w-full sm:w-auto text-center">Clear</a>
                    @endif
                </form>
                <button type="button"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow font-semibold w-full sm:w-auto"
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
                            <th class="px-2 sm:px-6 py-3 font-semibold text-gray-700 text-center text-xs sm:text-base">#</th>
                            <th class="px-2 sm:px-6 py-3 font-semibold text-gray-700 text-center text-xs sm:text-base">Order Date</th>
                            <th class="px-2 sm:px-6 py-3 font-semibold text-gray-700 text-center text-xs sm:text-base">Customer Name</th>
                            <th class="px-2 sm:px-6 py-3 font-semibold text-gray-700 text-center text-xs sm:text-base">Phone No</th>
                            <th class="px-2 sm:px-6 py-3 font-semibold text-gray-700 text-center text-xs sm:text-base">Total</th>
                            <th class="px-2 sm:px-6 py-3 font-semibold text-gray-700 text-center text-xs sm:text-base">Status</th>
                            <th class="px-2 sm:px-6 py-3 font-semibold text-gray-700 text-center text-xs sm:text-base">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50 transition-all text-center">
                                <td class="px-2 sm:px-6 py-4 text-xs sm:text-base">{{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</td>
                                <td class="px-2 sm:px-6 py-4 text-xs sm:text-base">{{ $order->order_date ? $order->order_date->format('M d, Y') : $order->created_at->format('M d, Y') }}</td>
                                <td class="px-2 sm:px-6 py-4 font-medium text-gray-900 text-xs sm:text-base">{{ $order->customer?->name }}</td>
                                <td class="px-2 sm:px-6 py-4 text-xs sm:text-base">{{ $order->customer?->phone }}</td>
                                <td class="px-2 sm:px-6 py-4 text-xs sm:text-base">{{ number_format($order->total, 2) }}</td>
                                <td class="px-2 sm:px-6 py-4 text-xs sm:text-base">
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
                                <td class="px-2 sm:px-6 py-4">
                                    <div class="flex flex-wrap items-center justify-center gap-2">
                                        <!-- Change Status -->
                                        <button onclick="openStatusModal({{ $order->id }}, '{{ $order->status }}')"
                                            class="text-purple-600 hover:text-purple-800 hover:bg-purple-50 p-2 rounded-lg transition-all duration-200"
                                            title="Change Status">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </button>
                                        
                                        <!-- Download PDF -->
                                        <a href="{{ route('orders.pdf', $order->id) }}"
                                            class="text-green-600 hover:text-green-800 hover:bg-green-50 p-2 rounded-lg transition-all duration-200"
                                            title="Download PDF">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </a>
                                        
                                        <!-- View -->
                                        <a href="{{ route('orders.show', $order) }}"
                                            class="text-blue-600 hover:text-blue-800 hover:bg-blue-50 p-2 rounded-lg transition-all duration-200"
                                            title="View Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        
                                        <!-- Edit -->
                                        <a href="{{ route('orders.edit', $order) }}"
                                            class="text-yellow-600 hover:text-yellow-800 hover:bg-yellow-50 p-2 rounded-lg transition-all duration-200"
                                            title="Edit Order">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        
                                        <!-- Delete -->
                                        <form action="{{ route('orders.destroy', $order) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this order?')"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded-lg transition-all duration-200"
                                                title="Delete Order">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-2 sm:px-6 py-4 text-center text-gray-500 text-xs sm:text-base">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-center">{{ $orders->links() }}</div>
        </div>
    </div>

    <!-- Change Status Modal -->
    <div id="status-modal" class="fixed inset-0 z-50 bg-black bg-opacity-40 items-center justify-center hidden">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full mx-4 p-6 relative">
            <button type="button" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-xl font-bold"
                onclick="closeStatusModal()">&times;</button>
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Change Order Status</h2>
            <form id="status-form" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label for="status" class="block font-medium text-gray-700 mb-2">Select New Status:</label>
                    <select name="status" id="status-select" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeStatusModal()"
                        class="px-4 py-2 text-gray-600 bg-gray-200 hover:bg-gray-300 rounded-lg font-medium">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">Update Status</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Export Modal -->
    <div id="export-modal" class="fixed inset-0 z-50 bg-black bg-opacity-40 items-center justify-center hidden">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-8 relative">
            <button type="button" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-xl font-bold"
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
                        <input type="date" name="from" id="from" class="border rounded px-2 py-1 w-full">
                    </div>
                    <div>
                        <label for="to" class="block text-gray-700">To:</label>
                        <input type="date" name="to" id="to" class="border rounded px-2 py-1 w-full">
                    </div>
                </div>
                <div class="mt-4 flex justify-end">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-semibold shadow">Export
                        PDF</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Export modal functionality
        document.querySelectorAll('input[name="range"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                document.getElementById('custom-range-fields').style.display =
                    this.value === 'custom' ? 'grid' : 'none';
            });
        });

        // Status modal functionality
        function openStatusModal(orderId, currentStatus) {
            const modal = document.getElementById('status-modal');
            const form = document.getElementById('status-form');
            const statusSelect = document.getElementById('status-select');
            
            // Set form action URL
            form.action = `/orders/${orderId}/status`;
            
            // Set current status as selected
            statusSelect.value = currentStatus;
            
            // Show modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeStatusModal() {
            const modal = document.getElementById('status-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Close modal when clicking outside
        document.getElementById('status-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeStatusModal();
            }
        });

        document.getElementById('export-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                document.getElementById('export-modal').classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
