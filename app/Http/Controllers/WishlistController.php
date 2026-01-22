<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\ProductVariant;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = [];

        if (Auth::check()) {
            // For authenticated users
            $wishlist = Wishlist::where('user_id', Auth::id())
                ->with(['product.images']) // Load product images relationship
                ->get();

            foreach ($wishlist as $item) {
                // Fetch the variant data using the ProductVariant model
                $variant = ProductVariant::find($item->variant_id);
                $item->variant = $variant;
            }
        } else {
            // For guest users
            $sessionWishlist = session()->get('wishlist', []);
            foreach ($sessionWishlist as $key => $item) {
                $product = Product::with('images')->find($item['product_id']);
                if ($product) {
                    $variant = ProductVariant::find($item['variant_id']);
                    $wishlist[] = (object) [
                        'id' => $key,
                        'product' => $product,
                        'variant' => $variant
                    ];
                }
            }
        }

        return view('wishlist', compact('wishlist'));
    }

    public function add($id)
    {
        $product = Product::findOrFail($id);
        $variantId = request('variant_id') ? request('variant_id') : null;

        if (Auth::check()) {
            Wishlist::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'product_id' => $id,
                    'variant_id' => $variantId
                ],
                [
                    'variant' => $variantId ? ProductVariant::find($variantId)->name : null,
                ]
            );
        } else {
            $wishlist = session()->get('wishlist', []);
            $wishlistKey = "{$id}_{$variantId}";

            if (!isset($wishlist[$wishlistKey])) {
                $wishlist[$wishlistKey] = [
                    'product_id' => $id,
                    'variant_id' => $variantId
                ];
            }

            session()->put('wishlist', $wishlist);
        }

        return redirect()->route('wishlist.index');
    }

    public function delete($id)
    {
        if (Auth::check()) {
            Wishlist::where('user_id', Auth::id())->where('id', $id)->delete();
        } else {
            $wishlist = session()->get('wishlist', []);
            if (isset($wishlist[$id])) {
                unset($wishlist[$id]);
                session()->put('wishlist', $wishlist);
            }
        }

        return redirect()->route('wishlist.index');
    }

    public function headerWishlist()
    {
        $wishlist = [];
        $wishlistCount = 0;

        if (Auth::check()) {
            // For authenticated users
            $wishlist = Wishlist::where('user_id', Auth::id())
                ->with(['product.images']) // Load product images relationship
                ->get();

            foreach ($wishlist as $item) {
                // Fetch the variant data using the ProductVariant model
                $variant = ProductVariant::find($item->variant_id);
                $item->variant = $variant;
            }
        } else {
            // For guest users
            $sessionWishlist = session()->get('wishlist', []);
            foreach ($sessionWishlist as $key => $item) {
                $product = Product::with('images')->find($item['product_id']);
                if ($product) {
                    $variant = ProductVariant::find($item['variant_id']);
                    $wishlist[] = (object) [
                        'id' => $key,
                        'product' => $product,
                        'variant' => $variant
                    ];
                }
            }
        }

        $wishlistCount = count($wishlist);

        return [
            'wishlist' => $wishlist,
            'wishlistCount' => $wishlistCount
        ];
    }
}
