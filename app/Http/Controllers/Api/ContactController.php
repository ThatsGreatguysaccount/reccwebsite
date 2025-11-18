<?php

namespace App\Http\Controllers\Api;

use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ContactController extends ApiController
{
    /**
     * Get company contact information
     */
    public function info(): JsonResponse
    {
        try {
            $settings = Setting::whereIn('key', [
                'company_email',
                'company_phone',
                'company_address',
            ])->pluck('value', 'key');

            return $this->success([
                'email' => $settings['company_email'] ?? 'support@example.com',
                'phone' => $settings['company_phone'] ?? '+1 (555) 123-4567',
                'address' => $settings['company_address'] ?? '123 Main Street, City, State 12345',
            ], 'Contact information retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to load contact information: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Submit contact form
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
            ]);

            $user = $request->user();

            $message = ContactMessage::create([
                'user_id' => $user->id,
                'name' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'status' => 'new',
            ]);

            return $this->success([
                'id' => $message->id,
            ], 'Message sent successfully', 201);
        } catch (ValidationException $e) {
            return $this->error('Validation failed', 422, $e->errors());
        } catch (\Exception $e) {
            return $this->error('Failed to send message: ' . $e->getMessage(), 500);
        }
    }
}

