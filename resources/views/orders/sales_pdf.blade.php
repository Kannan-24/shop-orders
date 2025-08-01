<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sales Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 10px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        .mb-2 {
            margin-bottom: 8px;
        }

        .mb-4 {
            margin-bottom: 16px;
        }

        .mt-4 {
            margin-top: 16px;
        }

        .header-table {
            width: 100%;
            margin-bottom: 0px;
        }

        .logo {
            height: 100px;
            margin-right: 10px;
        }

        .company-details {
            padding-left: 0px;
            font-size: 11px;
            line-height: 1.5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background-color: #f0f0f0;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 10px;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            font-size: 11px;
            text-align: right;
        }

        ul {
            list-style: none;
            padding-left: 0;
            margin: 0;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td style="width: 8%; border: none; text-align: center;">
                <img src="{{ public_path('assets/logo.png') }}" class="logo" alt="Logo">
            </td>
            <td class="company-details" style="width: 60%; border: none;">
                <strong>JP CRUNCH & MUNCH</strong><br>
                P-101, Sri Tirumala Sarovar Apartments,<br>
                Hosur Road, Bommanahalli,<br>
                B.B.MP, Bangalore - 560068<br>
                Karnataka, India<br>
            </td>
        </tr>
    </table>
    
    <!-- Title -->
    <h3 style="text-align: center;">Sales Report</h3>
    <p><strong>Period:</strong> {{ $from->format('d M Y') }} - {{ $to->format('d M Y') }}</p>


    <!-- Orders Table -->
    <div class="section-title">Order-wise Details</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Products</th>
                <th>Total (₹)</th>
            </tr>
        </thead>
        <tbody>
            @php $totalQuantity = 0; @endphp
            @forelse($orders as $order)
                <tr>
                    <td class="text-center">{{$loop->iteration}}</td>
                    <td>{{ $order->created_at->format('d-m-Y') }}</td>
                    <td>{{ $order->customer->name ?? 'Walk-in' }}</td>
                    <td>
                        <ul>
                            @foreach ($order->items as $item)
                                <li>{{ $item->product->name ?? 'N/A' }} — ₹{{ number_format($item->unit_price, 2) }} ×
                                    {{ $item->quantity }} = ₹{{ number_format($item->subtotal, 2) }}</li>
                                @php $totalQuantity += $item->quantity; @endphp
                            @endforeach
                        </ul>
                    </td>
                    <td class="text-right">₹{{ number_format($order->total, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No completed orders found for this range.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Summary -->
    <div class="section-title">Sales Summary</div>
    <table>
        <tr>
            <th>Total Orders</th>
            <td>{{ $orders->count() }}</td>
        </tr>
        <tr>
            <th>Total Products Sold</th>
            <td>{{ $totalQuantity }}</td>
        </tr>
        <tr>
            <th>Total Sales</th>
            <td>₹{{ number_format($total_sales, 2) }}</td>
        </tr>
        <tr>
            <th>Average Order Value</th>
            <td>₹{{ number_format($orders->count() ? $total_sales / $orders->count() : 0, 2) }}</td>
        </tr>
    </table>

    <!-- Product-wise Breakdown -->
    <div class="section-title">Product-wise Statistics</div>
    @php
        $productStats = [];
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $productName = $item->product->name ?? 'Unknown';
                if (!isset($productStats[$productName])) {
                    $productStats[$productName] = ['quantity' => 0, 'total' => 0.0];
                }
                $productStats[$productName]['quantity'] += $item->quantity;
                $productStats[$productName]['total'] += $item->subtotal;
            }
        }
    @endphp

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Total Quantity</th>
                <th>Total Sales (₹)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($productStats as $product => $data)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $product }}</td>
                    <td>{{ $data['quantity'] }}</td>
                    <td class="text-right">₹{{ number_format($data['total'], 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No product data available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        Generated on: {{ now()->format('d-m-Y h:i A') }} |
        Generated by: {{ auth()->user()->name ?? 'System' }}
    </div>

</body>

</html>
