<x-app-layout>a
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-6 gap-6 mb-8">
                <div
                    class="bg-gradient-to-r from-blue-500 to-blue-700 text-white shadow-lg rounded-2xl p-6 flex flex-col items-center">
                    <div class="mb-2"><svg class="h-8 w-8" fill="none" stroke="currentColor">
                            <path d="M3 10h18M3 6h18M3 14h18M3 18h18" stroke-width="2" />
                        </svg></div>
                    <div class="text-sm">Total Orders</div>
                    <div class="text-2xl font-bold">{{ $totalOrders ?? 0 }}</div>
                </div>
                <div
                    class="bg-gradient-to-r from-green-400 to-green-600 text-white shadow-lg rounded-2xl p-6 flex flex-col items-center">
                    <div class="mb-2"><svg class="h-8 w-8" fill="none" stroke="currentColor">
                            <circle cx="12" cy="12" r="10" stroke-width="2" />
                            <path d="M12 8v4l3 3" stroke-width="2" />
                        </svg></div>
                    <div class="text-sm">Completed Orders</div>
                    <div class="text-2xl font-bold">{{ $completedOrders ?? 0 }}</div>
                </div>
                <div
                    class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-white shadow-lg rounded-2xl p-6 flex flex-col items-center">
                    <div class="mb-2"><svg class="h-8 w-8" fill="none" stroke="currentColor">
                            <circle cx="12" cy="12" r="10" stroke-width="2" />
                            <path d="M12 8v4l3 3" stroke-width="2" />
                        </svg></div>
                    <div class="text-sm">Pending Payments</div>
                    <div class="text-2xl font-bold">{{ $pendingPayments ?? 0 }}</div>
                </div>
                <div
                    class="bg-gradient-to-r from-purple-400 to-purple-600 text-white shadow-lg rounded-2xl p-6 flex flex-col items-center">
                    <div class="mb-2"><svg class="h-8 w-8" fill="none" stroke="currentColor">
                            <circle cx="12" cy="12" r="10" stroke-width="2" />
                            <path d="M12 8v4l3 3" stroke-width="2" />
                        </svg></div>
                    <div class="text-sm">Total Revenue</div>
                    <div class="text-2xl font-bold">₹{{ number_format($totalRevenue ?? 0, 2) }}</div>
                </div>
                <div
                    class="bg-gradient-to-r from-pink-400 to-pink-600 text-white shadow-lg rounded-2xl p-6 flex flex-col items-center">
                    <div class="mb-2"><svg class="h-8 w-8" fill="none" stroke="currentColor">
                            <circle cx="12" cy="12" r="10" stroke-width="2" />
                            <path d="M12 8v4l3 3" stroke-width="2" />
                        </svg></div>
                    <div class="text-sm">Customers</div>
                    <div class="text-2xl font-bold">{{ $uniqueCustomers ?? 0 }}</div>
                </div>
                <div
                    class="bg-gradient-to-r from-gray-400 to-gray-600 text-white shadow-lg rounded-2xl p-6 flex flex-col items-center">
                    <div class="mb-2"><svg class="h-8 w-8" fill="none" stroke="currentColor">
                            <circle cx="12" cy="12" r="10" stroke-width="2" />
                            <path d="M12 8v4l3 3" stroke-width="2" />
                        </svg></div>
                    <div class="text-sm">Cancelled Orders</div>
                    <div class="text-2xl font-bold">{{ $cancelledOrders ?? 0 }}</div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="text-base font-semibold mb-3">Orders by Status</h3>
                    <canvas id="ordersPie" style="max-height: 300px;"></canvas>
                </div>
                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="text-base font-semibold mb-3">Revenue Over Time</h3>
                    <canvas id="revenueLine" style="max-height: 300px;"></canvas>
                </div>
            </div>

            <!-- Top Selling Products (Today) -->
            <div class="bg-white shadow rounded-2xl p-8 mb-8">
                <h3 class="text-lg font-semibold mb-4">Top Selling Products (Today)</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border text-sm">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b text-center">S.No</th>
                                <th class="px-4 py-2 border-b text-center">Product</th>
                                <th class="px-4 py-2 border-b text-center">Qty Sold</th>
                                <th class="px-4 py-2 border-b text-center">Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts ?? [] as $index => $product)
                                <tr>
                                    <td class="px-4 py-2 border-b text-center">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border-b text-center">{{ $product->name }}</td>
                                    <td class="px-4 py-2 border-b text-center">{{ $product->qty_sold }}</td>
                                    <td class="px-4 py-2 border-b text-center">₹{{ number_format($product->revenue, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-4 py-2 border-b text-center" colspan="4">No sales today.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">Live Product Sales Chart</h3>
                    <canvas id="productSalesBar" style="max-height: 300px;"></canvas>
                </div>
                </div>

                <!-- Top Customers & Recent Payments -->
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-8">
                    <div class="bg-white shadow rounded-2xl p-8">
                        <h3 class="text-lg font-semibold mb-4">Top Customers</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border text-sm">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 border-b text-center">S.No</th>
                                        <th class="px-4 py-2 border-b text-center">Customer</th>
                                        <th class="px-4 py-2 border-b text-center">Orders</th>
                                        <th class="px-4 py-2 border-b text-center">Total Spent</th>
                                        <th class="px-4 py-2 border-b text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topCustomers ?? [] as $index => $customer)
                                        <tr>
                                            <td class="px-4 py-2 border-b text-center">{{ $index + 1 }}</td>
                                            <td class="px-4 py-2 border-b text-center">{{ $customer->name }}</td>
                                            <td class="px-4 py-2 border-b text-center">{{ $customer->orders_count }}</td>
                                            <td class="px-4 py-2 border-b text-center">₹{{ number_format($customer->total_spent, 2) }}
                                            </td>
                                            <td class="px-4 py-2 border-b text-center">
                                                <a href="{{ route('customers.show', $customer->id) }}"
                                                    class="text-blue-700 hover:underline">View</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="px-4 py-2 border-b text-center" colspan="5">No data.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="bg-white shadow rounded-2xl p-8">
                        <h3 class="text-lg font-semibold mb-4">Recent Payments</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border text-sm">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 border-b text-center">S.No</th>
                                        <th class="px-4 py-2 border-b text-center">Order</th>
                                        <th class="px-4 py-2 border-b text-center">Amount</th>
                                        <th class="px-4 py-2 border-b text-center">Status</th>
                                        <th class="px-4 py-2 border-b text-center">Paid At</th>
                                        <th class="px-4 py-2 border-b text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentPayments ?? [] as $index => $payment)
                                        <tr>
                                            <td class="px-4 py-2 border-b text-center">{{ $index + 1 }}</td>
                                            <td class="px-4 py-2 border-b text-center">
                                                <a href="{{ route('orders.show', $payment->order_id) }}"
                                                    class="text-blue-700 hover:underline">#{{ $payment->order_id }}</a>
                                            </td>
                                            <td class="px-4 py-2 border-b text-center">₹{{ number_format($payment->total_amount, 2) }}
                                            </td>
                                            <td class="px-4 py-2 border-b text-center">
                                                <span
                                                    class="inline-block px-2 py-1 rounded text-xs font-semibold
                                                @if ($payment->status === 'completed') bg-green-100 text-green-800
                                                @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800
                                                @else bg-gray-100 text-gray-800 @endif">{{ ucfirst($payment->status) }}</span>
                                            </td>
                                            <td class="px-4 py-2 border-b text-center">
                                                @if ($payment->status === 'pending')
                                                    -
                                                @else
                                                    {{ $payment->updated_at->format('d M Y') }}
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 border-b text-center">
                                                <a href="{{ route('payments.show', $payment->id) }}"
                                                    class="text-blue-700 hover:underline">View</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="px-4 py-2 border-b text-center" colspan="7">No recent payments.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders Table -->
                <div class="bg-white shadow rounded-2xl p-8 mb-8">
                    <h3 class="text-lg font-semibold mb-4">Recent Orders</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border text-sm">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border-b text-center">S.No</th>
                                    <th class="px-4 py-2 border-b text-center">Order ID</th>
                                    <th class="px-4 py-2 border-b text-center">Customer</th>
                                    <th class="px-4 py-2 border-b text-center">Status</th>
                                    <th class="px-4 py-2 border-b text-center">Amount</th>
                                    <th class="px-4 py-2 border-b text-center">Created At</th>
                                    <th class="px-4 py-2 border-b text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders ?? [] as $index => $order)
                                    <tr>
                                        <td class="px-4 py-2 border-b text-center">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2 border-b text-center">#{{ $order->id }}</td>
                                        <td class="px-4 py-2 border-b text-center">{{ $order->customer->name ?? '-' }}</td>
                                        <td class="px-4 py-2 border-b text-center">
                                            <span
                                                class="inline-block px-2 py-1 rounded text-xs font-semibold
                                            @if ($order->status === 'completed') bg-green-100 text-green-800
                                            @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800 @endif">{{ ucfirst($order->status) }}</span>
                                        </td>
                                        <td class="px-4 py-2 border-b text-center">₹{{ number_format($order->total, 2) }}</td>
                                        <td class="px-4 py-2 border-b text-center">{{ $order->created_at->format('d M Y H:i') }}</td>
                                        <td class="px-4 py-2 border-b text-center">
                                        <a href="{{ route('orders.show', $order->id) }}"
                                            class="text-blue-700 hover:underline">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-4 py-2 border-b text-center" colspan="6">No recent orders.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ChartJS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Pie Chart: Orders by Status
        const ordersPie = document.getElementById('ordersPie').getContext('2d');
        new Chart(ordersPie, {
            type: 'pie',
            data: {
                labels: ['Completed', 'Pending', 'Cancelled'],
                datasets: [{
                    data: [
                        {{ $completedOrders ?? 0 }},
                        {{ $pendingOrders ?? 0 }},
                        {{ $cancelledOrders ?? 0 }},
                    ],
                    backgroundColor: [
                        '#34d399', // green
                        '#fbbf24', // yellow
                        '#9ca3af', // gray
                    ],
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });

        // Line Chart: Revenue Over Time
        const revenueLine = document.getElementById('revenueLine').getContext('2d');
        new Chart(revenueLine, {
            type: 'line',
            data: {
                labels: {!! json_encode($revenueLabels ?? []) !!},
                datasets: [{
                    label: 'Revenue',
                    data: {!! json_encode($revenueData ?? []) !!},
                    backgroundColor: 'rgba(99, 102, 241, 0.2)', // indigo
                    borderColor: '#6366f1',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#6366f1',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => '₹' + value
                        }
                    }
                }
            }
        });

        // Bar Chart: Top Selling Products
        const productSalesBar = document.getElementById('productSalesBar').getContext('2d');
        new Chart(productSalesBar, {
            type: 'bar',
            data: {
                labels: {!! json_encode($topProducts->pluck('name')) !!},
                datasets: [{
                    label: 'Qty Sold',
                    data: {!! json_encode($topProducts->pluck('qty_sold')) !!},
                    backgroundColor: '#3b82f6',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-app-layout>
