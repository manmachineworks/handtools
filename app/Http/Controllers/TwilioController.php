<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VerificationCode; // Use the VerificationCode model
use Illuminate\Support\Facades\Validator;

class TwilioController extends Controller
{
    private $twilio_sid = 'AC79d1e2e2d173cd07378888f1f2723cfa';
    private $twilio_token = 'e76ae7f6abc0de050fd3c06bb2bfb1b7';
    private $twilio_phone_number = '+12132143720'; // Your Twilio phone number

    // Method to send OTP
    public function sendOTP(Request $request)
    {
        // Validate the phone number
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|size:10', // Adjust validation according to your country
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $phone = '+91' . $request->input('phone'); // Add country code

        // Generate a random 6-digit OTP
        $verificationCode = rand(100000, 999999);

        // Store the verification code in the database
        VerificationCode::updateOrCreate(
            ['phone' => $phone], // Update if phone exists, otherwise create new
            [
                'verification_code' => $verificationCode,
                'verification_code_expires_at' => now()->addMinutes(5), // Expire in 5 minutes
            ]
        );

        // Sending OTP via Twilio SMS API using cURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.twilio.com/2010-04-01/Accounts/' . $this->twilio_sid . '/Messages.json');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query([
            'From' => $this->twilio_phone_number,
            'To' => $phone,
            'Body' => 'Your verification code is ' . $verificationCode
        ]));
        curl_setopt($curl, CURLOPT_USERPWD, $this->twilio_sid . ':' . $this->twilio_token);

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Check for cURL errors or non-200 HTTP status codes
        if ($httpcode !== 201 && !$response) {
            return response()->json(['message' => 'Failed to send OTP.'], 500);
        }

        // Log or check response for further errors, if needed
        return response()->json(['success' => true]);
    }

    // Method to verify OTP
    public function verifyOTP(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|size:10',
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $phone = '+91' . $request->input('phone');
        $otp = $request->input('otp');

        // Retrieve the verification code from the VerificationCode model
        $verification = VerificationCode::where('phone', $phone)
            ->where('verification_code', $otp)
            ->where('verification_code_expires_at', '>', now()) // Check if not expired
            ->first();

        if (!$verification) {
            return response()->json(['message' => 'Invalid or expired OTP'], 400);
        }

        // OTP is correct, you can mark the user as verified or perform your next steps
        return response()->json(['verified' => true]);
    }
}
