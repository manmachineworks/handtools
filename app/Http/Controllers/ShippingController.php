<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\ProductVariant;



class ShippingController extends Controller
{
    public function handleShipping($transactionId)
    {
        // Fetch all orders related to this transaction
        $orders = Order::with(['user', 'product', 'variant', 'address'])
            ->where('transaction_id', $transactionId)
            ->get();

        // dd($orders);

        if ($orders->isEmpty()) {
            return response()->json(['error' => 'No orders found for this transaction'], 404);
        }

        // Prepare data for Shiprocket API request for all orders in a single shipment
        $shippingData = $this->prepareShippingData($orders);

        // dd($shippingData);
        // Call the Shiprocket API to create the shipment
        $response = $this->createShiprocketShipment($shippingData);
        // dd($response);
        $responseBody = json_decode($response->getBody(), true);
        // dd($responseBody);
        // Log response or handle accordingly
        $shippingResponses = [];
        if ($response->successful()) {
            // Update shipping status in all orders after the API call
            foreach ($orders as $order) {
                $order->shipping_status = 'created';
                $order->save();

                $shippingResponses[] = [
                    'order_id' => $order->id,
                    'status' => 'Shipment created successfully',
                ];
            }
        } else {
            Log::error('Shiprocket API error: ' . $response->body());
            foreach ($orders as $order) {
                $shippingResponses[] = [
                    'order_id' => $order->id,
                    'status' => 'Failed to create shipment',
                    'error' => $response->body(),
                ];
            }
        }

        // Prepare data for the Google Analytics purchase event
        $purchaseData = $this->preparePurchaseEventData($orders);

        // Store transaction ID in session
        session()->put('processed_transaction_id', $transactionId);


        // Return the response with details for all shipments
        return view('payment.success', compact('shippingResponses', 'purchaseData'))->with('success', 'Shipment process completed.');
    }


    protected function preparePurchaseEventData($orders)
    {
        $items = [];
        $totalValue = 0;
        $tax = 0;
        $shipping = 0; // You may calculate this dynamically based on your shipping logic

        foreach ($orders as $order) {
            $product = $order->product;
            $variant = $order->variant;

            // Calculate the total value of all items
            $itemPrice = $variant ? $variant->sale_price : $product->sale_price;
            $totalValue += $itemPrice * $order->quantity;

            // Add each item to the items array for the purchase event
            $items[] = [
                'item_id' => $product->id,
                'item_name' => $product->product_name,
                'price' => $itemPrice,
                'quantity' => $order->quantity,
                'item_variant' => $variant ? $variant->id : null,
                'discount' => 0 // You can handle discount logic here if applicable
            ];
        }

        return [
            'transaction_id' => $orders->first()->transaction_id,
            'value' => $totalValue,
            'tax' => $tax,
            'shipping' => $shipping,
            'currency' => 'INR', // Adjust based on your currency
            'items' => $items
        ];
    }

    private function prepareShippingData($orders)
    {
        $totalWeight = 0;
        $totalLength = 0;
        $totalBreadth = 0;
        $totalHeight = 0;

        $orderItems = [];
        $individualProductDimensions = []; // To store dimensions of each product for debugging

        foreach ($orders as $order) {
            // Default to product details in case there is no variant
            $productName = $order->product->product_name;
            $skuCode = $order->product->sku_code;
            $productUnitPrice = $order->product->sale_price;
            // dd($productUnitPrice);

            // Check if the order has a variant
            if ($order->variant_id !== null) {
                $productVariant = ProductVariant::find($order->variant_id);

                if ($productVariant) {
                    $productName = $productVariant->varaint_name; // Use variant name
                    $skuCode = $productVariant->sku_code; // Use variant SKU code
                }
            }

            // Add each order item to the array
            $orderItems[] = [
                "name" => $productName,
                "sku" => $skuCode,
                "units" => $order->quantity,
                "selling_price" => $productUnitPrice,
                "hsn" => "" // Example HSN code, can be dynamic
            ];


            // dd($orderItems); // Uncomment to see each item added in the loop

            // Calculate the total weight (product weight * quantity)
            $totalWeight += $order->weight;

            // Multiply dimensions by the quantity to get the total dimensions
            $length = $order->length;
            $breadth = $order->breadth;
            $height = $order->height;

            // Sum up the total dimensions
            $totalLength += $length;
            $totalBreadth += $breadth;
            $totalHeight += $height;

            // Add the dimensions for each product for debugging
            $individualProductDimensions[] = [
                'quantity' => $order->quantity,
                'length' => $order->length,
                'breadth' => $order->breadth,
                'height' => $order->height,
                'weight' => $order->weight,
                'calculated_length' => $length,
                'calculated_breadth' => $breadth,
                'calculated_height' => $height,
                'calculated_weight' => $totalWeight,
            ];

            // dd($individualProductDimensions); // Uncomment to see the dimensions during the loop
        }

        // Debug to check if the values are calculated correctly
        // dd([
        //     'orderItems' => $orderItems,
        //     'totalWeight' => $totalWeight,
        //     'totalLength' => $totalLength,
        //     'totalBreadth' => $totalBreadth,
        //     'totalHeight' => $totalHeight,
        //     'individualProductDimensions' => $individualProductDimensions, // Added for debugging
        // ]);


        // Prepare the shipment data to be sent to Shiprocket API
        return [
            "order_id" => $orders->first()->transaction_id, // Common transaction ID
            "order_date" => now()->format('Y-m-d H:i'), // Set the order date
            "pickup_location" => "warehouse", // Set pickup location
            "channel_id" => "Custom", // Can be blank or set custom channel id
            "comment" => "seller: Mafra India",
            "billing_customer_name" => $orders->first()->user->name, // Customer name
            "billing_last_name" => "", // If available
            "billing_address" => $orders->first()->address->address, // Billing address (assuming it's the same)
            "billing_address_2" => $orders->first()->address->apartment,
            "billing_city" => $orders->first()->address->city,
            "billing_pincode" => $orders->first()->address->pin_code,
            "billing_state" => $orders->first()->address->state,
            "billing_country" => "India", // Adjust as needed
            "billing_email" => $orders->first()->user->email,
            "billing_phone" => $orders->first()->user->phone,
            "shipping_is_billing" => true,
            "shipping_customer_name" => "",
            "shipping_last_name" => "",
            "shipping_address" => "",
            "shipping_address_2" => "",
            "shipping_city" => "",
            "shipping_pincode" => "",
            "shipping_country" => "",
            "shipping_state" => $orders->first()->address->state,
            "shipping_email" => "",
            "shipping_phone" => "",
            "order_items" => $orderItems, // Multiple items from different orders
            "payment_method" => "Prepaid", // Or COD if needed
            "shipping_charges" => 0,
            "giftwrap_charges" => 0,
            "transaction_charges" => 0,
            "total_discount" => 0,
            "sub_total" => $orders->sum('amount'), // Total amount for all orders
            "length" => $totalLength, // Sum of length for all products based on quantity
            "breadth" => $totalBreadth, // Sum of breadth for all products based on quantity
            "height" => $totalHeight, // Sum of height for all products based on quantity
            "weight" => $totalWeight // Total weight
        ];
    }

    private function createShiprocketShipment($data)
    {
        // API endpoint for creating a Shiprocket order
        $url = 'https://apiv2.shiprocket.in/v1/external/orders/create/adhoc';

        $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOjUxMjIyNzUsInNvdXJjZSI6InNyLWF1dGgtaW50IiwiZXhwIjoxNzQxMTUwOTI4LCJqdGkiOiJMazlORFV0Q0hFMXJLT3p3IiwiaWF0IjoxNzQwMjg2OTI4LCJpc3MiOiJodHRwczovL3NyLWF1dGguc2hpcHJvY2tldC5pbi9hdXRob3JpemUvdXNlciIsIm5iZiI6MTc0MDI4NjkyOCwiY2lkIjo0ODI5NTMzLCJ0YyI6MzYwLCJ2ZXJib3NlIjpmYWxzZSwidmVuZG9yX2lkIjowLCJ2ZW5kb3JfY29kZSI6IiJ9.ls33TZgLTynLvKNus8NL2Xe97GuPrsYkQy2j9Hy8Ge0";

        

        // Send the request to Shiprocket API
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->post($url, $data);

        return $response;
    }
}
