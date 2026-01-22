<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;

class PaymentController extends Controller
{
    private $hostUrl = 'https://api.phonepe.com/apis/hermes/pg/v1/pay';
    private $callbackUrl = 'https://www.demoMerchant.com/callback'; // Replace with your actual callback URL
    private $merchantId = 'M220IDNFQI8ZC'; // Replace with your actual merchantId
    private $apiKey = '61a25546-8d1d-4d05-9372-9d2fa6192387'; // Replace with your actual API key
    private $saltIndex = '1'; // Replace with your actual salt index

    public function createOrder(Request $request)
    {
        $callbackUrl = 'https://www.mafraindia.com/dashboard';
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
                'order_id' => uniqid('order_'),
                'transaction_id' => '',
                'amount' => $amount,
                'status' => 'pending',
                'payment_method' => 'phonepe',
            ]);

            $orderIds[] = $order->id;
            $totalAmount += $amount;
        }

        $totalAmountInPaisa = $totalAmount * 100; // Convert to paisa

        $paymentData = [
            'merchantId' => $this->merchantId,
            'merchantTransactionId' => uniqid('txn_'),
            'merchantUserId' => $user ? $user->id : 'guest',
            'amount' => $totalAmountInPaisa,
            'redirectUrl' => $callbackUrl,
            'redirectMode' => 'REDIRECT',
            'callbackUrl' => $callbackUrl,
            'merchantOrderId' => $orderIds ? end($orderIds) : uniqid('order_'),
            'mobileNumber' => $user->mobile ?? '9999999999',
            'message' => 'Payment for Product/Service',
            'email' => $user->email ?? 'info@tutorialswebsite.com',
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
}
