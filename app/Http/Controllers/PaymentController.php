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
use App\Models\Coupon;

class PaymentController extends Controller
{
    private $hostUrl = 'https://api.phonepe.com/apis/hermes/pg/v1/pay';


    // private $hostUrl =  'https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay'; 

    private $merchantId = 'M220IDNFQI8ZC'; // Replace with your actual merchantId
    private $apiKey = '61a25546-8d1d-4d05-9372-9d2fa6192387'; // Replace with your actual API key
    private $saltIndex = '1'; // Replace with your actual salt index

    // private $merchantId = 'PGTESTPAYUAT'; // Replace with your actual merchantId
    // private $apiKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399'; // Replace with your actual API key

   
     public function createCodOrder(Request $request)
    {
        $merchantTransactionId = uniqid('txn_');
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
            $couponCode = session()->get('coupon_code');
            $coupon = Coupon::where('coupon_code', $couponCode)->first();
            $amount = $price * $item['quantity'];
            
            $couponCode = session()->get('coupon_code');
            $coupon = Coupon::where('coupon_code', $couponCode)->first();
            $amount = $price * $item['quantity'];

                    if (session()->get('coupon_applied', false) && $coupon) {
                // Calculate the discount based on the product price if coupon exists
                $discount = ($coupon->discount_percentage / 100) * $price;
                $amount = ($price - $discount) * $item['quantity'];
            }

            $order = Order::create([
                'user_id' => $user->id,
                'product_id' => $item['product_id'],
                'variant_id' => $item['variant_id'] ?? null,
                'address_id' => $addressId,
                'order_id' => uniqid('order_'),
                'transaction_id' => $merchantTransactionId,
                'amount' => $amount,
                'status' => 'pending',
                'payment_method' => 'cod',
                'quantity' => $item['quantity'],
            ]);

            $orderIds[] = $order->id;
            $totalAmount += $amount;

            Cart::where('user_id', $user->id)
                ->where('product_id', $item['product_id'])
                ->where('variant_id', $item['variant_id'] ?? null)
                ->delete();
        }

        session()->forget('discount');
        session()->forget('coupon_code');
        session()->forget('coupon_applied');

        // Redirect to the success route
        return redirect()->route('payoncod-status', ['merchantTransactionId' => $merchantTransactionId]);
        
    }



 public function paymentcodstatus($merchantTransactionId)
    {
        if (!$merchantTransactionId) {
            return response()->json(['error' => 'Merchant Transaction ID is required'], 400);
        }else {

     
            // Find all orders using the transaction ID
            $orders = Order::where('transaction_id', $merchantTransactionId)->get();

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
                Mail::to($user->email)->send(new PaymentSuccessMail($order));
                
            }

           // Redirect to the success route
             return redirect()->route('payment-success', ['merchantTransactionId' => $merchantTransactionId]);
        }
    }


    public function checkPaymentStatus($merchantTransactionId)
    {
        if (!$merchantTransactionId) {
            return response()->json(['error' => 'Merchant Transaction ID is required'], 400);
        }

        $saltKey = $this->apiKey; // Use your API key as saltKey
        $saltIndex = $this->saltIndex; // Use your actual salt index

        $payload = "/pg/v1/status/{$this->merchantId}/{$merchantTransactionId}" . $saltKey;
        $sha256 = hash("sha256", $payload);
        $final_x_verify = $sha256 . "###" . $saltIndex;

        $url = "https://api.phonepe.com/apis/hermes/pg/v1/status/{$this->merchantId}/{$merchantTransactionId}";

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "X-VERIFY: " . $final_x_verify,
                "X-MERCHANT-ID: " . $this->merchantId,
                "accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);



        $res = json_decode($response);

        // dd($res);
        // dd($res->success);
        // dd($res->data->merchantTransactionId);
        if (isset($res->success) && $res->success === true) {
            // Find all orders using the transaction ID
            $orders = Order::where('transaction_id', $res->data->merchantTransactionId)->get();

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
                Mail::to($user->email)->send(new PaymentSuccessMail($order));
                
            }

            // Redirect to the success route
            return redirect()->route('payment.success', ['merchantTransactionId' => $res->data->merchantTransactionId]);
        } else {
            // Redirect to the failure route with an error message
            return redirect()->route('payment.failure')->with('error', "API Error: " . ($res->message ?? 'Unknown error'));
        }
    }
}
