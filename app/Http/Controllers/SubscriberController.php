<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Subscriber;

class SubscriberController extends Controller
{

    public function store_subs(Request $request)
    {
        $mail = $request->input('sub_mail');

        $request->validate([
            'sub_mail' => 'required|email|unique:subscriber,email',
        ]);

        $subscriber = new Subscriber();
        $subscriber->email = $mail;
        $subscriber->save();
        return back()->with('success', 'Thank you for subscribing!');
    }
}
