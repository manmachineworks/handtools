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

class PaymentController extends Controller
{
    // private $hostUrl = 'https://api.phonepe.com/apis/hermes/pg/v1/pay';


    private $hostUrl =  'https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay';

    // private $merchantId = 'M220IDNFQI8ZC'; // Replace with your actual merchantId
    // private $apiKey = '61a25546-8d1d-4d05-9372-9d2fa6192387'; // Replace with your actual API key
    private $saltIndex = '1'; // Replace with your actual salt index

    private $merchantId = 'PGTESTPAYUAT'; // Replace with your actual merchantId
    private $apiKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399'; // Replace with your actual API key

    public function createOrder(Request $request)
    {
        $merchantTransactionId = uniqid('txn_');
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

            $order = Order::create([
                'user_id' => $user->id,
                'product_id' => $item['product_id'],
                'variant_id' => $item['variant_id'] ?? null,
                'address_id' => $addressId,
                'order_id' => uniqid('order_'),
                'transaction_id' => $merchantTransactionId,
                'amount' => $amount,
                'status' => 'pending',
                'payment_method' => 'phonepe',
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


        $totalAmountInPaisa = $totalAmount * 100; // Convert to paisa

        $paymentData = [
            'merchantId' => $this->merchantId,
            'merchantTransactionId' => $merchantTransactionId,
            'merchantUserId' => $user ? $user->id : 'guest',
            'amount' => $totalAmountInPaisa,
            'redirectUrl' => $callbackUrl,
            'redirectMode' => 'REDIRECT',
            'callbackUrl' => $callbackUrl,
            'merchantOrderId' => $orderIds ? end($orderIds) : uniqid('order_'),
            'mobileNumber' => $user->mobile ?? '9999999999',
            'message' => 'Payment for Product/Service',
            'email' => $user->email ?? 'info@mafra.com',
            'paymentInstrument' => [
                'type' => 'PAY_PAGE',
            ]
        ];

        $jsonencode = json_encode($paymentData);
        $payloadMain = base64_encode($jsonencode);
        $payload = $payloadMain . "/pg/v1/pay" . $this->apiKey;
        $sha256 = hash("sha256", $payload);
        $final_x_header = $sha256 . '###' . $this->saltIndex;
        $requestPayload = json_encode(['request' => $payloadMain]);

        // Retry logic
        $retryCount = 0;
        $maxRetries = 3;
        $retryDelay = 2; // Initial delay in seconds

        while ($retryCount < $maxRetries) {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $this->hostUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $requestPayload,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "X-VERIFY: " . $final_x_header,
                    "accept: application/json"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            // dd($response);

            curl_close($curl);

            if ($err) {
                Log::error("cURL Error: " . $err);
                return response()->json(['error' => "cURL Error: " . $err], 500);
            }

            $res = json_decode($response);

            Log::info('API Response: ', (array) $res);

            if (isset($res->success) && $res->success === true) {
                $payUrl = $res->data->instrumentResponse->redirectInfo->url;
                return redirect($payUrl);
            } elseif (isset($res->code) && $res->code === 'TOO_MANY_REQUESTS') {
                $retryCount++;
                if ($retryCount < $maxRetries) {
                    sleep($retryDelay); // Wait before retrying
                    $retryDelay *= 2; // Exponential backoff
                } else {
                    return response()->json(['error' => 'Rate limit exceeded. Please try again later.'], 429);
                }
            } else {
                return response()->json(['error' => "API Error: " . ($res->message ?? 'Unknown error')], 500);
            }
        }

        return response()->json(['error' => 'Payment failed after multiple attempts.'], 500);
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
            // Find the order using the transaction ID
            $order = Order::where('transaction_id', $res->data->merchantTransactionId)->first();

            if ($order) {
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

                // Check if product exists and update stock
                // if ($product) {
                //     $product->stock -= $order->quantity;
                //     $product->save();
                // }

                // Check if product exists and update stock
                if ($product) {
                    $product->stock -= $order->quantity;
                    $product->save();

                    // Calculate the total length, breadth, height, and weight based on the quantity
                    $order->length = $product->length * $order->quantity;
                    $order->breadth = $product->breadth * $order->quantity;
                    $order->height = $product->height * $order->quantity;
                    $order->weight = $product->weight * $order->quantity;
                }

                // Check if product variant exists and update stock
                if ($productVariant) {
                    $productVariant->stock -= $order->quantity;
                    $productVariant->save();
                }

                $order->save();

                // Send email notification
                Mail::to($user->email)->send(new PaymentSuccessMail($order));

                // Redirect to the success route
                return redirect()->route('payment.success', ['orderId' => $order->id]);
            }
        } else {
            // Redirect to the failure route with an error message
            return redirect()->route('payment.failure')->with('error', "API Error: " . ($res->message ?? 'Unknown error'));
        }
    }
}
