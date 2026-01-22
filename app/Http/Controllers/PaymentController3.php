<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Mail\PaymentSuccessMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class PaymentController3 extends Controller
{

    public function createOrder(Request $request)
    {
        $merchantTransactionId = uniqid('txn_'); // Generate a unique transaction ID
        $callbackUrl = 'https://www.mafraindia.com/payment-status/' . $merchantTransactionId;
        $user = Auth::user();
        $cartItems = [];

        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())
                ->with(['product.images'])
                ->get()
                ->toArray();
        } else {
            $cartItems = session()->get('cart', []);
        }

        if (empty($cartItems)) {
            return back()->withErrors('Your cart is empty.');
        }

        $request->validate([
            'address_id' => 'required|exists:addresses,id'
        ]);

        $addressId = $request->input('address_id');

        $orderIds = [];
        $totalAmount = 0;

        foreach ($cartItems as $item) {
            $product = Product::find($item['product_id']);
            $variant = isset($item['variant_id']) ? ProductVariant::find($item['variant_id']) : null;

            $price = $variant ? $variant->sale_price : $product->sale_price;
            $amount = $price * $item['quantity'];

            // Create order in the database
            $order = Order::create([
                'user_id' => $user->id,
                'product_id' => $item['product_id'],
                'variant_id' => $item['variant_id'] ?? null,
                'address_id' => $addressId,
                'order_id' => uniqid('order_'),
                'transaction_id' => $merchantTransactionId, // Use generated transaction ID
                'amount' => $amount,
                'status' => 'pending',
                'payment_method' => 'test_gateway', // Placeholder for payment method
                'quantity' => $item['quantity'],
            ]);

            $orderIds[] = $order->id;
            $totalAmount += $amount;

            // Remove item from the cart after order is created
            Cart::where('user_id', $user->id)
                ->where('product_id', $item['product_id'])
                ->where('variant_id', $item['variant_id'] ?? null)
                ->delete();
        }

        session()->forget('discount');
        session()->forget('coupon_code');
        session()->forget('coupon_applied');

        // Instead of calling the payment gateway, directly simulate a success response
        return $this->checkPaymentStatus($merchantTransactionId); // Call the same function used to verify payment
    }

    public function checkPaymentStatus($merchantTransactionId)
    {
        if (!$merchantTransactionId) {
            return response()->json(['error' => 'Merchant Transaction ID is required'], 400);
        }

        // Simulate a successful payment without an external API call

        $orders = Order::where('transaction_id', $merchantTransactionId)->get();
        if ($orders) {
           

            foreach ($orders as $order) {
                // Update the order status to 'success'
                $order->status = 'success';
                $order->save();

                // Get the user associated with the order
                $user = User::find($order->user_id);

                // Update product stock
                $product = Product::find($order->product_id);
                $productVariant = null;

                if ($order->variant_id !== 'null') {
                    $productVariant = ProductVariant::find($order->variant_id);
                }

                // Check if product exists and update stock and dimensions
                if ($product) {
                    // Reduce the stock by the quantity
                    $product->stock -= $order->quantity;
                    $product->save();

                    // Calculate dimensions and weight based on quantity and save them in the order
                    $order->length = $product->length;
                    $order->breadth = $product->breadth;
                    $order->height = $product->height * $order->quantity;
                    $order->weight = $product->weight * $order->quantity;
                }

                // Check if product variant exists and update stock
                if ($productVariant) {
                    $productVariant->stock -= $order->quantity;
                    $productVariant->save();

                    $order->length = $productVariant->length;
                    $order->breadth = $productVariant->breadth;
                    $order->height = $productVariant->height * $order->quantity;
                    $order->weight = $productVariant->weight * $order->quantity;
                }

                // Save the updated order dimensions and weight
                $order->save();

                // Send email notification to the user
                $data = Mail::to($user->email)->send(new PaymentSuccessMail($order));

                // dd($data);
            }

            // Redirect to the success route
            return redirect()->route('payment.success', ['merchantTransactionId' => $merchantTransactionId]);
        } else {
            // Handle failure scenario
            return redirect()->route('payment.failure')->with('error', 'Order not found or payment failed.');
        }
    }

}
