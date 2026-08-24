<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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

        // 2. Validate Input Payload
        $validator = Validator::make($request->all(), [
            'name'         => 'required|string|max:150',
            'email'        => 'required|email|max:150',
            'number'       => 'nullable|string|max:50',
            'phone'        => 'nullable|string|max:50',
            'product_name' => 'nullable|string|max:150',
            'message'      => 'required|string|max:6000',
            'attachment'   => 'nullable|array',
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

        $data['ip_address'] = $request->ip();
        $data['submitted_at'] = now()->setTimezone('Asia/Kolkata')->format('Y-m-d h:i:s A');

        // 3. Send Email via Laravel Mailer
        try {
            $recipient = env('MAIL_FROM_ADDRESS', 'info@webwiders.com');
            Mail::to($recipient)->send(new ContactFormMail($data));

            Log::info('Contact form email dispatched successfully to ' . $recipient . ' from ' . $data['email']);

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
