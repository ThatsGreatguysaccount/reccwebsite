<?php

namespace App\Http\Controllers\Api;

use App\Models\Setting;
use Illuminate\Http\JsonResponse;

class PublicSettingsController extends ApiController
{
    /**
     * Get public company settings for landing page
     */
    public function index(): JsonResponse
    {
        try {
            // Get all company-related settings
            $settingsKeys = [
                'company_name',
                'company_email',
                'company_phone',
                'company_number',
                'company_address',
                'company_address_map_url',
                'company_website',
                'company_working_hours',
                'company_logo',
                'company_logo_white',
                'company_favicon',
            ];

            $settings = Setting::whereIn('key', $settingsKeys)
                ->pluck('value', 'key')
                ->toArray();

            // Return settings with defaults if not set
            return $this->success([
                'company_name' => $settings['company_name'] ?? '',
                'company_email' => $settings['company_email'] ?? '',
                'company_phone' => $settings['company_phone'] ?? '',
                'company_number' => $settings['company_number'] ?? $settings['company_phone'] ?? '',
                'company_address' => $settings['company_address'] ?? '',
                'company_address_map_url' => $settings['company_address_map_url'] ?? '',
                'company_website' => $settings['company_website'] ?? '',
                'company_working_hours' => $settings['company_working_hours'] ?? '10:00 AM - 10:00 PM',
                'company_logo' => $settings['company_logo'] ?? '',
                'company_logo_white' => $settings['company_logo_white'] ?? '',
                'company_favicon' => $settings['company_favicon'] ?? '',
            ], 'Settings retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve settings: ' . $e->getMessage(), 500);
        }
    }
}

