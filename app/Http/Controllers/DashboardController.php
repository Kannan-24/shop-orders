<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        // KPIs
        $totalOrders = Order::count();
        $completedOrders = Order::where('status', 'completed')->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();
        $pendingPayments = Payment::where('status', 'pending')->count();
        $totalRevenue = Payment::where('status', 'completed')->sum('total_amount');
        $uniqueCustomers = Customer::count();

        // Top customers by amount spent
        $topCustomers = Customer::select('customers.*');
        // Top customers by amount spent
        $topCustomers = Customer::select('customers.*')
            ->selectRaw('COUNT(orders.id) as orders_count')
            ->selectRaw('COALESCE(SUM(orders.total),0) as total_spent')
            ->leftJoin('orders', 'orders.customer_id', '=', 'customers.id')
            ->groupBy(
                'customers.id',
                'customers.name',
                'customers.email',
                'customers.phone',
                'customers.address',
                'customers.created_at',
                'customers.updated_at'
            )
            ->orderByDesc('total_spent')
            ->limit(5)
            ->get();
        $recentPayments = Payment::with('order.customer')
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get();

        // Revenue over last 7 days
        $revenueLabels = [];
        $revenueData = [];
        $dateMap = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $revenueLabels[] = date('d M', strtotime($date));
            $dateMap[$date] = 0;
        }
        $revenues = Payment::where('status', 'completed')
            ->where('updated_at', '>=', now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(updated_at) as date, SUM(total_amount) as sum')
            ->groupBy('date')
            ->pluck('sum', 'date')
            ->toArray();
        foreach ($revenues as $date => $sum) {
            $dateMap[$date] = $sum;
        }
        $revenueData = array_values($dateMap);

        // Recent orders
        $recentOrders = Order::with('customer')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        // Top selling products today
        $topProducts = Product::select('products.id', 'products.name')
            ->selectRaw('SUM(order_items.quantity) as qty_sold')
            ->selectRaw('SUM(order_items.subtotal) as revenue')
            ->join('order_items', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereDate('orders.created_at', now()->toDateString())
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('qty_sold')
            ->limit(5)
            ->get();

        // For real-time stats, you can also get all-time or weekly stats similarly.

        return view('dashboard', [
            'totalOrders'     => $totalOrders,
            'completedOrders' => $completedOrders,
            'pendingOrders'   => $pendingOrders,
            'cancelledOrders' => $cancelledOrders,
            'pendingPayments' => $pendingPayments,
            'totalRevenue'    => $totalRevenue,
            'uniqueCustomers' => $uniqueCustomers,
            'topCustomers'    => $topCustomers,
            'recentPayments'  => $recentPayments,
            'revenueLabels'   => $revenueLabels,
            'revenueData'     => $revenueData,
            'recentOrders'    => $recentOrders,
            'topProducts'     => $topProducts,
        ]);
    }
}
