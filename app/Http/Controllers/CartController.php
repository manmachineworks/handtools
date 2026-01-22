<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductVariant;

class CartController extends Controller
{
    public function index()
    {
        $cart = [];
        $cartTotal = 0;

        if (Auth::check()) {
            // For authenticated users
            $cart = Cart::where('user_id', Auth::id())
                ->with(['product.images']) // Load product images relationship
                ->get();

            foreach ($cart as $item) {
                // Fetch the variant data using the ProductVariant model
                $variant = ProductVariant::find($item->variant_id);
                $item->variant = $variant;
            }
        } else {
            // For guest users
            $sessionCart = session()->get('cart', []);
            foreach ($sessionCart as $key => $item) {
                $product = Product::with('images')->find($item['product_id']);
                if ($product) {
                    $variant = ProductVariant::find($item['variant_id']);
                    $cart[] = (object) [
                        'id' => $key,
                        'product' => $product,
                        'variant' => $variant,
                        'quantity' => $item['quantity'],
                    ];
                }
            }
        }

        $cartTotal = collect($cart)->sum(function ($item) {
            $price = $item->variant ? $item->variant->sale_price : $item->product->sale_price;
            return $price * $item->quantity;
        });

        if (session()->has('coupon_code')) {
            // Retrieve the coupon code from the session
            $couponCode = session()->get('coupon_code');

            // Find the coupon in the database
            $coupon = Coupon::where('coupon_code', $couponCode)->first();

            if ($coupon) {
                // Calculate the discount based on the current cart total
                $discount = $coupon->discount_percentage / 100 * $cartTotal;

                // Update the discount in the session
                session()->put('discount', $discount);
            }
        }
        // dd($cartTotal);
        return view('cart', compact('cart', 'cartTotal'));
    }



    public function checkout()
    {
        $cart = [];
        $cartTotal = 0;
        $discount = session()->get('discount', 0);  // Retrieve discount from session

        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())
                ->with(['product.images'])
                ->get();

            foreach ($cart as $item) {
                $variant = ProductVariant::find($item->variant_id);
                $item->variant = $variant;
            }
        } else {
            $sessionCart = session()->get('cart', []);
            foreach ($sessionCart as $key => $item) {
                $product = Product::with('images')->find($item['product_id']);
                if ($product) {
                    $variant = ProductVariant::find($item['variant_id']);
                    $cart[] = (object) [
                        'id' => $key,
                        'product' => $product,
                        'variant' => $variant,
                        'quantity' => $item['quantity'],
                    ];
                }
            }
        }
        $cartTotal = collect($cart)->sum(function ($item) {
            $price = $item->variant ? $item->variant->sale_price : $item->product->sale_price;
            return $price * $item->quantity;
        });

        $cartTotal -= $discount;  // Apply discount to cart total

        return view('checkout', compact('cart', 'cartTotal', 'discount'));
    }



    // CheckoutController.php

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $couponCode = $request->input('coupon_code');
        $coupon = Coupon::where('coupon_code', $couponCode)->first();

        if ($coupon) {
            $cartTotal = $this->calculateCartTotal();
            $discount = $coupon->discount_percentage / 100 * $cartTotal;

            // Store discount and coupon code in session
            session()->put('discount', $discount);
            session()->put('coupon_code', $couponCode);
            session()->put('coupon_applied', true); // Set flag

            return redirect()->back()->with('success', 'Coupon applied successfully!');
        } else {
            return redirect()->back()->with('error', 'Invalid coupon code.');
        }
    }


    private function calculateCartTotal()
    {
        $cartTotal = 0;

        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->with(['product.images'])->get();
            foreach ($cart as $item) {
                $variant = ProductVariant::find($item->variant_id);
                $price = $variant ? $variant->sale_price : $item->product->sale_price;
                $cartTotal += $price * $item->quantity;
            }
        } else {
            $sessionCart = session()->get('cart', []);
            // dd($sessionCart);
            foreach ($sessionCart as $item) {
                // dd($item['product_id']);
                $product = Product::find($item['product_id']);
                // dd($product);
                $variant = ProductVariant::find($item['variant_id']);
                $price = $variant ? $variant->sale_price : $product->sale_price;
                $cartTotal += $price * $item['quantity'];
            }
        }

        return $cartTotal;
    }


    public function add($id)
    {
        $product = Product::findOrFail($id);
        $variantId = request('variant_id') ? request('variant_id') : null;
        $quantity = request('quantity', 1);

        if ($product->mrp < 400 && $quantity < 3) {
            $quantity = 3;
        }

        // Check product stock
        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'We are short on stock for the selected product.');
        }

        // Check variant stock if a variant is selected
        if ($variantId) {
            $variant = ProductVariant::findOrFail($variantId);
            if ($variant->stock < $quantity) {
                return redirect()->back()->with('error', 'We are short on stock for the selected variant.');
            }
        }
        // dd($variantId);
        if (Auth::check()) {
            Cart::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'product_id' => $id,
                    'variant_id' => $variantId
                ],
                [
                    'quantity' => $quantity,
                ]
            );
        } else {
            $cart = session()->get('cart', []);
            $cartKey = "{$id}_{$variantId}";

            if (isset($cart[$cartKey])) {
                $cart[$cartKey]['quantity'] += $quantity;
            } else {
                $cart[$cartKey] = [
                    'product_id' => $id,
                    'variant_id' => $variantId,
                    'quantity' => $quantity,
                ];
            }

            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!')
        ->with('product', $product)
            ->with('variant', isset($variant) ? $variant : null)
            ->with('quantity', $quantity)
            ->with('cart_event', true); // Add cart event trigger
    }




    public function delete($id)
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->where('id', $id)->delete();
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
        }

        // Recalculate discount if there are no items in the cart
        return redirect()->route('cart.index');
    }


    public function updateQuantity(Request $request)
    {
        $quantity = $request->input('quantity');
        $id = $request->input('id');

        $cartItem = Cart::where('user_id', Auth::id())->where('id', $id)->first();
        $p_id = $request->input('product_id');;
        // dd($id);
        $product = Product::where('id', $p_id)->first();
        $stock = $product->stock;

        // dd($stock);
        // dd($quantity);

        if (Auth::check()) {
            if ($quantity > $product->stock) {
                return redirect()->back()->with('error', 'We are short on   for the selected variant for your given quantity. We currently have ' . $stock . ' units available for the given product.');

             }elseif ($quantity !== 0) {
                $cartItem->quantity = $quantity;
                $cartItem->save();
             }else {
                $cartItem->delete();
            }
        } else {
            if ($quantity > $product->stock) {
                return redirect()->back()->with('error', 'We are short on stock for the selected variant for your given quantity. We currently have ' . $stock . ' units available for the given product.');

            }elseif ($quantity !== 0) {
                $cart = session()->get('cart',[ ]);
                $cart[$id]['quantity'] = $quantity;
                session()->put('cart', $cart);

            } else {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
        }
        // foreach ($items as $item) {
        //     $id = $item['id'];
        //     $quantity = $item['quantity'];

        //     if (Auth::check()) {
        //         // For authenticated users
        //         $cartItem = Cart::where('user_id', Auth::id())->where('id', $id)->first();
        //         if ($cartItem) {
        //             // Validate quantity
        //             if ($quantity > 0) {
        //                 $cartItem->quantity = $quantity;
        //                 $cartItem->save();
        //             } else {
        //                 // Handle case where quantity is zero or negative, e.g., remove item
        //                 $cartItem->delete();
        //             }
        //         }
        //     } else {
        //         // For guest users
        //         $cart = session()->get('cart', []);
        //         if (isset($cart[$id])) {
        //             // Validate quantity
        //             if ($quantity > 0) {
        //                 // Update the quantity of the cart item
        //                 $cart[$id]['quantity'] = $quantity;
        //                 session()->put('cart', $cart);
        //             } else {
        //                 // Handle case where quantity is zero or negative, e.g., remove item
        //                 unset($cart[$id]);
        //                 session()->put('cart', $cart);
        //             }
        //         }
        //     }
        // }

        return redirect()->route('cart.index');
    }

    public function headerCart()
    {
        $cart = [];
        $cartTotal = 0;
        $cartCount = 0;
        $discountedTotal = 0;

        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())
                ->with(['product.images', 'variant']) // Also load variant
                ->get();

            foreach ($cart as $item) {
                $price = $item->variant ? $item->variant->sale_price : $item->product->sale_price;
                $item->amount = $price * $item->quantity; // Set amount
            }
        } else {
            // For guest users
            $sessionCart = session()->get('cart', []);
            foreach ($sessionCart as $key => $item) {
                $product = Product::with('images')->find($item['product_id']);
                if ($product) {
                    $variant = ProductVariant::find($item['variant_id']);
                    $cart[] = (object) [
                        'id' => $key,
                        'product' => $product,
                        'variant' => $variant,
                        'quantity' => $item['quantity'],
                        'amount' => $item['amount'] ?? ($variant ? $variant->sale_price : $product->sale_price) * $item['quantity'],
                    ];
                }
            }
        }

        $cartTotal = collect($cart)->sum('amount');
        $cartCount = count($cart);

        if (session()->has('coupon_code')) {
            $coupon = Coupon::where('coupon_code', session()->get('coupon_code'))->first();
            if ($coupon) {
                $discountPercentage = $coupon->discount_percentage;
                foreach ($cart as $item) {
                    $price = $item->variant ? $item->variant->sale_price : $item->product->sale_price;
                    $discountedPrice = $price * (1 - $discountPercentage / 100);
                    $item->discounted_price = $discountedPrice;
                    $discountedTotal += $discountedPrice * $item->quantity;
                }
            }
        } else {
            $discountedTotal = $cartTotal; // No discount applied
        }

        return [
            'cart' => $cart,
            'cartTotal' => $cartTotal,
            'discountedTotal' => $discountedTotal,
            'cartCount' => $cartCount
        ];
    }

}
