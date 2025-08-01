<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .page-border {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border: 1px solid #000;
            z-index: -1;
        }

        .page {
            padding: 5px 10px;
            box-sizing: border-box;
            position: relative;
            min-height: 100vh;
        }

        .header-table {
            width: 100%;
            margin-bottom: 10px;
        }

        .logo {
            height: 80px;
            margin-right: 10px;
        }

        .company-details {
            padding-left: 0px;
            font-size: 11px;
            line-height: 1.5;
        }

        .company-details strong {
            font-size: 13px;
            text-transform: uppercase;
            display: block;
            margin-bottom: 2px;
        }

        .section-divider {
            border-top: 1px solid #000;
            margin: 5px 0;
        }

        .customer-section {
            margin: 10px 0 5px 0;
        }

        .customer-invoice-table {
            width: 100%;
            font-size: 11px;
        }

        .customer-details {
            line-height: 1.4;
            font-size: 11px;
            vertical-align: top;
        }

        .invoice-details {
            text-align: left;
            font-size: 11px;
            line-height: 1.4;

            vertical-align: top;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
            font-size: 11px;
        }

        .items-table th {
            text-align: left;
            background: #f8f8f8;
        }

        .totals-table {
            width: 100%;
            margin-top: 8px;
        }

        .totals-table td {
            padding: 6px;
            font-size: 11px;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            position: absolute;
            bottom: 10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            border-top: 1px solid #000;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="page-border"></div>

    <div class="page">
        <!-- Header -->
        <table class="header-table">
            <tr>
                <td style="width: 80px;">
                    <img src="{{ public_path('assets/logo.png') }}" class="logo" alt="Logo">
                </td>
                <td class="company-details">
                    <strong>JP CRUNCH & MUNCH</strong>
                    P-101, Sri Tirumala Sarovar Apartments,<br>
                    Hosur Road, Bommanahalli,<br>
                    B.B.M.P South, Karnataka - 560068
                </td>
            </tr>
        </table>

        <div class="section-divider"></div>

        <!-- Customer and Invoice Info -->
        <table class="customer-invoice-table customer-section">
            <tr>
                <td class="customer-details" style="width: 50%;">
                    <strong>Customer Details</strong><br>
                    {{ $order->customer->name }}<br>
                    {{ $order->customer->phone }}<br>
                    {{ $order->customer->address ?? '-' }}
                </td>
                <td style="width: 20%">
                </td>
                <td class="invoice-details" style="width: 30%;">
                    <strong>Invoice Details</strong><br>
                    <strong>Invoice #:</strong> {{ $order->id }}<br>
                    <strong>Date:</strong> {{ $order->updated_at->format('d-m-Y') }}
                </td>
            </tr>
        </table>

        <div class="section-divider"></div>

        <!-- Items Table -->
        <div class="section-title">Order Items</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->product->description ?? '-' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-right">{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <table class="totals-table">
            <tr>
                <td class="text-right" style="width: 80%; font-weight: bold;">Total:</td>
                <td class="text-right">₹{{ number_format($order->total, 2) }}</td>
            </tr>
        </table>

        <!-- Footer -->
        <div class="footer">
            Printed on {{ now()->format('d-m-Y H:i:s') }} by {{ auth()->user()->name ?? 'System' }}<br>
            Thank you for your order.
        </div>
    </div>
</body>

</html>
