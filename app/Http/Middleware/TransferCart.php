<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class TransferCart
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $sessionCart = session()->get('cart', []);

            foreach ($sessionCart as $item) {
                $variantId = $item['variant_id'] ?? null; // Use variant_id from the session

                $cartItem = Cart::where('user_id', Auth::id())
                    ->where('product_id', $item['product_id'])
                    ->where('variant_id', $variantId)
                    ->first();

                if ($cartItem) {
                    $cartItem->quantity += $item['quantity'];
                    $cartItem->save();
                } else {
                    Cart::create([
                        'user_id' => Auth::id(),
                        'product_id' => $item['product_id'],
                        'variant_id' => $variantId, // Use variant_id here
                        'quantity' => $item['quantity'],
                    ]);
                }
            }

            session()->forget('cart');
        }

        return $next($request);
    }

}
