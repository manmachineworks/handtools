<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Order; // Assuming you have an Order model
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Coupon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;




class UserController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            // Move session cart items to the database for the logged-in user
            $sessionCart = session()->get('cart', []);
            foreach ($sessionCart as $key => $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $variant = ProductVariant::find($item['variant_id']);
                    Cart::updateOrCreate(
                        [
                            'user_id' => Auth::id(),
                            'product_id' => $item['product_id'],
                            'variant_id' => $item['variant_id']
                        ],
                        [
                            'quantity' => $item['quantity'],
                            'amount' => $this->calculateAmount($item['product_id'], $item['variant_id'], $item['quantity']), // Recalculate amount with discount if applied
                            'coupon_id' => session()->get('coupon_id') // Apply coupon if any
                        ]
                    );
                }
            }
            // Clear the session cart
            session()->forget('cart');
            return redirect()->route('dashboard')->with('success', 'You are now logged in.');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        session()->forget('cart', []);
        session()->forget('coupon_id');
        session()->forget('discount');
        session()->forget('coupon_code');
        session()->forget('coupon_applied');
        return redirect()->route('login')->with('success', 'You have been logged out.');
    }

    public function register()
    {
        return view('register');
    }

    public function registerSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        // Log the user in
        Auth::login($user);

        if (Auth::check()) {
            // Check if user is authenticated
            $sessionCart = session()->get('cart', []);
            foreach ($sessionCart as $key => $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $variant = ProductVariant::find($item['variant_id']);
                    Cart::updateOrCreate(
                        [
                            'user_id' => Auth::id(),
                            'product_id' => $item['product_id'],
                            'variant_id' => $item['variant_id']
                        ],
                        [
                            'quantity' => $item['quantity'],
                            'amount' => $this->calculateAmount($item['product_id'], $item['variant_id'], $item['quantity']), // Recalculate amount with discount if applied
                            'coupon_id' => session()->get('coupon_id') // Apply coupon if any
                        ]
                    );
                }
            }
            // Clear the session cart
            session()->forget('cart');
            return redirect()->route('dashboard')->with('success', 'Registration successful. You are now logged in.');
        } else {
            return redirect()->route('home')->with('error', 'Registration is not successful.');
        }
    }


    public function dashboard()
    {
        // Retrieve the currently authenticated user
        $user = Auth::user();
        $addresses = $user->addresses; // Assuming a one-to-many relationship
        $orders = $user->orders;       // Assuming a one-to-many relationship
        $ordersGroupedByTransaction = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('transaction_id');

        // Pass user data, addresses, and orders to the dashboard view
        return view('dashboard', compact('user', 'addresses', 'ordersGroupedByTransaction'));
    }


    public function checkout(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'pin_code' => 'required|string|max:255',
            'phone' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        // Log in the user
        Auth::login($user);

        // Create the address
        $address = Address::create([
            'user_id' => $user->id,
            'state' => $request->state,
            'country' => $request->country,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'apartment' => $request->apartment,
            'city' => $request->city,
            'pin_code' => $request->pin_code,
            'phone' => $request->phone,
        ]);

        // Move session cart items to the database for the newly logged-in user
        $sessionCart = session()->get('cart', []);
        foreach ($sessionCart as $key => $item) {
            $product = Product::with('images')->find($item['product_id']);
            if ($product) {
                $variant = ProductVariant::find($item['variant_id']);
                Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'],
                    'quantity' => $item['quantity'],
                    'amount' => $this->calculateAmount($item['product_id'], $item['variant_id'], $item['quantity']), // Recalculate amount with discount if applied
                ]);
            }
        }
        // Clear the session cart
        session()->forget('cart');
        // Redirect to the checkout route
        return redirect()->route('checkout.index');
    }

    private function calculateAmount($productId, $variantId, $quantity)
    {
        $product = Product::find($productId);
        $variant = $variantId ? ProductVariant::find($variantId) : null;
        $price = $variant ? $variant->sale_price : $product->sale_price;
        $amount = $price * $quantity;

        // Apply discount if any
        if (session()->has('coupon_id')) {
            $coupon = Coupon::find(session()->get('coupon_id'));
            if ($coupon) {
                $amount = $amount - ($amount * ($coupon->discount_percentage / 100));
            }
        }
        return $amount;
    }


    public function viewOrder($orderId)
    {
        // Fetch the order by ID
        $order = Order::with(['product', 'variant', 'address'])
            ->where('id', $orderId)
            ->where('user_id', Auth::id()) // Ensure the order belongs to the authenticated user
            ->firstOrFail();

        // Pass the order data to a view
        return view('orders.view', compact('order'));
    }

    public function cancelOrder(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to cancel this order.');
        }

        if ($order->order_status == 'canceled') {
            return redirect()->route('dashboard')->with('error', 'This order is already canceled.');
        }

        $order->update(['order_status' => 'canceled']);

        return redirect()->route('dashboard')->with('success', 'Order has been canceled successfully.');
    }



    public function add_address_view()
    {
        return view('address.add_address');
    }

    public function address_edit_view(Request $request, $id)
    {
        $address = Address::find($id);
        return view('address.edit_address', compact('address'));
    }

    public function edit_address(Request $request, $id)
    {
        $user = Auth::user();
        $address = Address::find($id);

        if (!$address || $user->id != $address->user_id) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'country' => 'required|string',
            'address' => 'required|string',
            'apartment' => 'required|string',
            'city' => 'required|string',
            'pin_code' => 'required|string',
      
            'state' => 'required|string',
          
        ]);

        $address->update([
            'country' => $request->country,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'apartment' => $request->apartment,
            'city' => $request->city,
            'pin_code' => $request->pin_code,
            'phone' => $user->phone,
            'state' => $request->state,
        ]);

        return redirect()->route('dashboard')->with('success', 'Address updated successfully.');
    }

    public function add_address(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'country' => 'required|string',
            'address' => 'required|string',
            'apartment' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'pin_code' => 'required|string|max:10',
            
        ]);

        $address = new Address();
        $address->user_id = $user->id;
        $address->first_name = $request->first_name;
        $address->last_name = $request->last_name;
        $address->country = $request->country;
        $address->address = $request->address;
        $address->apartment = $request->apartment;
        $address->city = $request->city;
        $address->pin_code = $request->pin_code;
        $address->phone = $user->phone;
        $address->state = $request->state;
        $address->save();

        return redirect()->back()->with('success', 'Address added successfully.');

    }


    public function add_address_c(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'country' => 'required|string',
            'address' => 'required|string',
            'apartment' => 'nullable|string',
            'city' => 'required|string',
            'pin_code' => 'required|string|max:10',
      
            'state' => 'required|string',
        ]);

        $address = new Address();
        $address->user_id = $user->id;
        $address->first_name = $request->first_name;
        $address->last_name = $request->last_name;
        $address->country = $request->country;
        $address->address = $request->address;
        $address->apartment = $request->apartment;
        $address->city = $request->city;
        $address->pin_code = $request->pin_code;
        $address->phone = $user->phone;

        $address->save();

        return redirect()->route('checkout.index')->with('success', 'Address added successfully.');
    }


    public function showResetRequestForm()
    {
        return view('auth.forgot-password');
    }

    // Handle the password reset request
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();
        $token = Str::random(60);

        // Save the token in the password_resets column
        $user->password_resets = $token;
        $user->save();

        $email = $request->email;

        // Generate the reset link
        $resetLink = url('reset-password/' . $token . '/' . $email);

        // Send email with reset link
        Mail::send('auth.mail_link', ['resetLink' => $resetLink], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Password Reset Request');
        });

        return back()->with('success', 'Password reset link sent!');
    }

    // Show the password reset form
    public function showResetForm(Request $request)
    {
        return view('auth.reset-password', ['token' => $request->token, 'email' => $request->email]);
    }

    // Handle the password reset
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|confirmed',
        ]);

        $user = User::where('email', $request->email)
            ->where('password_resets', $request->token)
            ->first();

        if (!$user) {
            return back()->withErrors(['error' => 'Invalid token or email']);
        }

        $user->password = Hash::make($request->password);
        $user->password_resets = null; // Clear the token
        $user->save();

        return redirect()->route('login')->with('status', 'Password has been reset!');
    }

}
