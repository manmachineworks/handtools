<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Blog;
use App\Models\Commt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;


class CommtController extends Controller
{
    public function store(StoreCommentRequest $request, Blog $blog)
    {
        // Simple profanity/URL gate (tweak rules as desired)
        $text = $request->message;
        $hasManyLinks = Str::of($text)->matchAll('/https?:\/\//i')->count() > 3;

        $status =  'pending'; // or keep all pending
        
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'g-recaptcha-response' => 'required',
    
        ]);

        Commt::create([
            'blog_id'    => $blog->id,
            'name'       => $request->name,
            'email'       => $request->email,
            'message'    => $text,
            'status'     => $status,
            'ip'         => $request->ip(),
            'user_agent' => (string) substr($request->userAgent() ?? '', 0, 255),
        ]);
        
        
         $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret' => env('RECAPTCHA_SECRET_KEY'), // from .env
        'response' => $request->input('g-recaptcha-response'),
        'remoteip' => $request->ip(),
    ]);

    if (!$response->json('success')) {
        return back()->withErrors(['captcha' => 'reCAPTCHA verification failed.'])->withInput();
    }

        return back()->with(
            'success',
            $status === 'approved'
                ? 'Comment posted!'
                : 'Thanks! Your comment is awaiting moderation.'
        );
    }
}
