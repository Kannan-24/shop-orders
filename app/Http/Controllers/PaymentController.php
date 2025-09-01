<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    // List all payments
    public function index()
    {
        $payments = Payment::with(['order.customer', 'paymentItems'])->paginate(15);
        return view('payments.index', compact('payments'));
    }
    // Show payment and history
    public function show($id)

    {
        $payment = Payment::with(['order.customer', 'paymentItems'])->findOrFail($id);
        return view('payments.show', compact('payment'));
    }

    public function addPaymentForm($id)
    {
        $payment = Payment::with('order.customer')->findOrFail($id);
        return view('payments.add_payment', compact('payment'));
    }

    // Add a payment (partial or full)
    public function addPayment(Request $request, $id)
    {
        $payment = Payment::with('order')->findOrFail($id);

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|string',
            'details' => 'nullable|string',
            'paid_at' => 'nullable|date',
        ]);

        // Additional validation to prevent overpayment
        $requestedAmount = $request->amount;
        $remainingBalance = $payment->balance;

        if ($requestedAmount > $remainingBalance) {
            return redirect()->back()
                ->withErrors(['amount' => "Payment amount (₹{$requestedAmount}) cannot exceed the remaining balance (₹{$remainingBalance})"])
                ->withInput();
        }

        DB::transaction(function () use ($request, $payment) {
            $paidAmount = $request->amount;
            $previousPaid = $payment->paymentItems()->sum('amount');
            $totalPaid = $previousPaid + $paidAmount;
            $orderTotal = $payment->total_amount;
            $remaining = max(0, $orderTotal - $totalPaid); // Ensure no negative balance

            // Set payment status
            $status = 'pending';
            if ($totalPaid >= $orderTotal) {
                $status = 'completed';
                $remaining = 0; // Ensure balance is exactly 0 when completed
            } elseif ($totalPaid > 0) {
                $status = 'partial';
            }

            // Create payment item
            PaymentItem::create([
                'payment_id' => $payment->id,
                'order_id' => $payment->order->id,
                'amount' => $paidAmount,
                'method' => $request->method,
                'details' => $request->details,
                'paid_at' => $request->paid_at ? $request->paid_at : now(),
            ]);

            // Update payment summary
            $payment->update([
                'balance' => $remaining,
                'status' => $status,
            ]);
        });

        return redirect()->route('payments.show', $payment->id)
            ->with('success', 'Payment recorded successfully!');
    }

    public function editPaymentItem($paymentId, $itemId)
    {
        $payment = Payment::findOrFail($paymentId);
        $item = $payment->paymentItems()->findOrFail($itemId);
        return view('payments.edit_payment_item', compact('payment', 'item'));
    }

    public function updatePaymentItem(Request $request, $paymentId, $itemId)
    {
        $payment = Payment::findOrFail($paymentId);
        $item = $payment->paymentItems()->findOrFail($itemId);

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|string',
            'details' => 'nullable|string',
            'paid_at' => 'required|date',
        ]);

        // Additional validation to prevent overpayment
        $requestedAmount = $request->amount;
        $otherPaymentsTotal = $payment->paymentItems()->where('id', '!=', $itemId)->sum('amount');
        $maxAllowedAmount = $payment->total_amount - $otherPaymentsTotal;

        if ($requestedAmount > $maxAllowedAmount) {
            return redirect()->back()
                ->withErrors(['amount' => "Payment amount (₹{$requestedAmount}) would exceed the order total. Maximum allowed: ₹{$maxAllowedAmount}"])
                ->withInput();
        }

        DB::transaction(function () use ($request, $payment, $item) {
            $item->update([
                'amount' => $request->amount,
                'method' => $request->method,
                'details' => $request->details,
                'paid_at' => $request->paid_at,
            ]);

            // Recalculate payment status and balance
            $totalPaid = $payment->paymentItems()->sum('amount');
            $balance = max(0, $payment->total_amount - $totalPaid);
            $status = $totalPaid >= $payment->total_amount ? 'completed' : ($totalPaid > 0 ? 'partial' : 'pending');

            $payment->update([
                'balance' => $balance,
                'status' => $status
            ]);
        });

        return redirect()->route('payments.show', $payment->id)
            ->with('success', 'Payment item updated successfully!');
    }
}
