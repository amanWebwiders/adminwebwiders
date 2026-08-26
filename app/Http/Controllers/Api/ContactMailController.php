<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ContactMailController extends Controller
{
    /**
     * Handle incoming contact form email requests.
     */
    public function sendMail(Request $request)
    {
        // 1. Verify Secret API Key
        $apiKey = $request->header('X-API-KEY');
        $expectedKey = env('CONTACT_FORM_SECRET_KEY', 'webwiders_secure_api_token_2026_x9z');

        if (!$apiKey || !hash_equals($expectedKey, $apiKey)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access: Invalid or missing API key.'
            ], 401);
        }

        // 1.1 Dynamic HMAC Signature & Nonce Replay Verification (if headers provided)
        $timestamp = $request->header('X-Timestamp');
        $nonce     = $request->header('X-Nonce');
        $signature = $request->header('X-Signature');
        $rawBody   = $request->getContent();

        if ($signature && $timestamp && $nonce) {
            // Check Timestamp (must be within 120 seconds)
            if (abs(time() - (int)$timestamp) > 120) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized: Request expired.'
                ], 401);
            }

            // Replay Attack Block (Nonce check)
            if (Cache::has('nonce:' . $nonce)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized: Replay attack detected.'
                ], 401);
            }
            Cache::put('nonce:' . $nonce, true, 180); // 3 minutes cache

            // Dynamic HMAC Verification
            $expectedSignature = hash_hmac('sha256', $timestamp . '.' . $nonce . '.' . $rawBody, $expectedKey);
            if (!hash_equals($expectedSignature, (string)$signature)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized: Signature mismatch.'
                ], 401);
            }
        }

        // 2. Validate Input Payload
        $validator = Validator::make($request->all(), [
            'name'         => 'required|string|max:150',
            'email'        => 'required|email|max:150',
            'number'       => 'nullable|string|max:50',
            'phone'        => 'nullable|string|max:50',
            'product_name' => 'nullable|string|max:150',
            'message'      => 'required|string|max:6000',
            'attachment'   => 'nullable|array',
            'user_ip'      => 'nullable|string|max:50',
            'client_ip'    => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error.',
                'errors'  => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        
        // Ensure name is parsed properly
        if (!isset($data['name']) || empty(trim($data['name']))) {
            $data['name'] = trim(($request->input('first_name', '') . ' ' . $request->input('last_name', '')));
        }
        
        if (empty($data['name'])) {
            $data['name'] = 'Website Visitor';
        }

        // Capture Real Client IP (Fixes 192.185.129.5 server IP recording)
        $realClientIp = $request->input('user_ip') 
            ?? $request->input('client_ip') 
            ?? $request->header('X-CF-Connecting-IP') 
            ?? $request->header('X-Real-IP') 
            ?? $request->ip();

        $data['ip_address']   = $realClientIp;
        $data['submitted_at'] = now()->setTimezone('Asia/Kolkata')->format('Y-m-d h:i:s A');

        // 3. Send Email via Laravel Mailer
        try {
            $recipient = env('MAIL_FROM_ADDRESS', 'info@webwiders.com');
            Mail::to($recipient)->send(new ContactFormMail($data));

            Log::info('Contact form email dispatched successfully to ' . $recipient . ' from ' . $data['email'] . ' (IP: ' . $realClientIp . ')');

            return response()->json([
                'success' => true,
                'message' => 'Contact email sent successfully.'
            ], 200);

        } catch (\Throwable $e) {
            Log::error('Failed sending contact email: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Email sending failed: ' . $e->getMessage()
            ], 500);
        }
    }
}