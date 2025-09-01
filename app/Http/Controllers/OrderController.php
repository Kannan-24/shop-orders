<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Category;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('customer', 'user', 'items.product', 'payment.paymentItems')
                      ->orderBy('order_date', 'desc')
                      ->orderBy('created_at', 'desc');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('customer', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(20);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();

        return view('orders.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'user_id' => Auth::id(),
                'status' => 'pending',
                'order_date' => $request->order_date,
                'total' => 0,
            ]);
            $total = 0;
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $quantity = $item['quantity'];
                $unit_price = $product->base_price;
                $subtotal = $unit_price * $quantity;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unit_price,
                    'subtotal' => $subtotal,
                ]);
                $total += $subtotal;
            }
            $order->update(['total' => $total]);
        });

        return redirect()->route('orders.index')->with('success', 'Order created!');
    }

    public function show($id)
    {
        $order = Order::with('items.product', 'payment.paymentItems', 'customer', 'user')->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function edit($id)
    {
        $order = Order::with('items.product', 'payment')->findOrFail($id);
        $customers = Customer::all();
        $products = Product::all();
        return view('orders.edit', compact('order', 'customers', 'products'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::with('items', 'payment')->findOrFail($id);

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'status' => 'required|in:pending,completed,cancelled',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.unit_value' => 'nullable|numeric',
            'items.*.unit_type' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $order) {
            $order->update([
                'customer_id' => $request->customer_id,
                'order_date' => $request->order_date,
                'status' => $request->status,
            ]);

            $existingItemIds = $order->items->pluck('id')->toArray();
            $submittedItemIds = [];
            $total = 0;

            foreach ($request->items as $idx => $itemData) {
                $itemId = $itemData['id'] ?? null;
                $product = Product::findOrFail($itemData['product_id']);

                $unit_price = $itemData['unit_price'];
                $quantity = $itemData['quantity'];
                $subtotal = $unit_price * $quantity;

                if ($itemId) {
                    $orderItem = OrderItem::find($itemId);
                    if ($orderItem) {
                        $orderItem->update([
                            'product_id' => $product->id,
                            'quantity' => $quantity,
                            'unit_price' => $unit_price,
                            'unit_value' => $itemData['unit_value'] ?? $product->unit_value,
                            'unit_type' => $itemData['unit_type'] ?? $product->unit_type,
                            'subtotal' => $subtotal,
                        ]);
                        $submittedItemIds[] = $orderItem->id;
                    }
                } else {
                    $newItem = OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price' => $unit_price,
                        'unit_value' => $itemData['unit_value'] ?? $product->unit_value,
                        'unit_type' => $itemData['unit_type'] ?? $product->unit_type,
                        'subtotal' => $subtotal,
                    ]);
                    $submittedItemIds[] = $newItem->id;
                }
                $total += $subtotal;
            }

            $itemsToDelete = array_diff($existingItemIds, $submittedItemIds);
            if (count($itemsToDelete)) {
                OrderItem::whereIn('id', $itemsToDelete)->delete();
            }

            $order->update(['total' => $total]);

            if ($order->status === 'completed' && !$order->payment) {
                Payment::create([
                    'order_id'     => $order->id,
                    'total_amount' => $order->total,
                    'balance'      => $order->total,
                    'status'       => 'pending',
                ]);
            }
        });

        return redirect()->route('orders.show', $order->id)->with('success', 'Order updated!');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted!');
    }

    public function downloadPdf($id)
    {
        $order = Order::with('items.product', 'customer')->findOrFail($id);

        $pdf = Pdf::loadView('orders.pdf', compact('order'))
            ->setPaper('a5', 'portrait');

        return $pdf->download("order_{$order->id}.pdf");
    }

    // SALES EXPORT BY RANGE
    public function exportSalesPdf(Request $request)
    {
        $range = $request->input('range');
        $from = $request->input('from');
        $to = $request->input('to');

        if ($range === 'today') {
            $from = now()->startOfDay();
            $to = now()->endOfDay();
        } elseif ($range === '7') {
            $from = now()->subDays(7)->startOfDay();
            $to = now()->endOfDay();
        } elseif ($range === '15') {
            $from = now()->subDays(15)->startOfDay();
            $to = now()->endOfDay();
        } elseif ($range === '30') {
            $from = now()->subDays(30)->startOfDay();
            $to = now()->endOfDay();
        } elseif ($range === '6months') {
            $from = now()->subMonths(6)->startOfDay();
            $to = now()->endOfDay();
        } elseif ($range === 'custom' && $from && $to) {
            $from = \Carbon\Carbon::parse($from)->startOfDay();
            $to = \Carbon\Carbon::parse($to)->endOfDay();
        } else {
            $from = now()->subDays(30)->startOfDay();
            $to = now()->endOfDay();
        }

        $orders = Order::with(['customer', 'items.product'])
            ->whereBetween('created_at', [$from, $to])
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();

        $total_sales = $orders->sum('total');

        $pdf = Pdf::loadView('orders.sales_pdf', compact('orders', 'from', 'to', 'total_sales'))
            ->setPaper('a4', 'landscape');

        $filename = 'sales_report_' . $from->format('Ymd') . '_to_' . $to->format('Ymd') . '.pdf';
        return $pdf->download($filename);
    }
    
}
