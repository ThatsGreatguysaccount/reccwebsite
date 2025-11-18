<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends ApiController
{
    /**
     * Get all settings
     */
    public function index(): JsonResponse
    {
        try {
            $settings = Setting::all()->pluck('value', 'key')->toArray();
            
            return $this->success([
                ...$settings
            ], 'Settings retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve settings: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update settings
     */
    public function update(Request $request): JsonResponse
    {
        try {
            // Normalize empty strings to null for proper validation
            $input = $request->all();
            foreach ($input as $key => $value) {
                if ($value === '') {
                    $input[$key] = null;
                }
            }
            $request->merge($input);

            $validated = $request->validate([
                'company_name' => 'nullable|string|max:255',
                'company_email' => 'nullable|string|email|max:255',
                'company_phone' => 'nullable|string|max:255',
                'company_number' => 'nullable|string|max:255',
                'company_address' => 'nullable|string|max:500',
                'company_address_map_url' => 'nullable|string|url|max:500',
                'company_website' => 'nullable|string|url|max:255',
                'company_working_hours' => 'nullable|string|max:255',
                'tidio_link' => 'nullable|string|max:500',
            ]);

            // Filter out empty values and null values - only save fields that have actual content
            $settingsToSave = array_filter($validated, function ($value) {
                return $value !== null && $value !== '';
            });

            // Save each setting
            foreach ($settingsToSave as $key => $value) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value, 'type' => 'string']
                );
            }

            return $this->success([], 'Settings updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error('Validation failed', 422, $e->errors());
        } catch (\Exception $e) {
            return $this->error('Failed to update settings: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update SMTP settings
     */
    public function updateSMTP(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'smtp_enabled' => 'sometimes|boolean',
                'smtp_host' => 'sometimes|string|max:255',
                'smtp_port' => 'sometimes|integer|min:1|max:65535',
                'smtp_encryption' => 'sometimes|in:tls,ssl',
                'smtp_username' => 'sometimes|string|max:255',
                'smtp_password' => 'sometimes|string|max:255',
                'smtp_from_email' => 'sometimes|string|email|max:255',
                'smtp_from_name' => 'sometimes|string|max:255',
            ]);

            foreach ($validated as $key => $value) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    [
                        'value' => is_bool($value) ? ($value ? '1' : '0') : $value,
                        'type' => is_bool($value) ? 'boolean' : 'string'
                    ]
                );
            }

            return $this->success([], 'SMTP settings updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error('Validation failed', 422, $e->errors());
        } catch (\Exception $e) {
            return $this->error('Failed to update SMTP settings: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Upload logo
     */
    public function uploadLogo(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'logo_type' => 'required|in:logo,logo_white,favicon',
                'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            $logoType = $validated['logo_type'];
            $file = $request->file('logo');
            
            // Generate unique filename
            $filename = 'company_' . $logoType . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Store in public/landing/img/logo directory
            $path = $file->move(public_path('landing/img/logo'), $filename);
            $relativePath = '/landing/img/logo/' . $filename;
            
            // Save to database
            $settingKey = 'company_' . $logoType;
            Setting::updateOrCreate(
                ['key' => $settingKey],
                ['value' => $relativePath, 'type' => 'string']
            );

            return $this->success([
                'logo_url' => $relativePath,
                'logo_key' => $settingKey,
            ], 'Logo uploaded successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error('Validation failed', 422, $e->errors());
        } catch (\Exception $e) {
            return $this->error('Failed to upload logo: ' . $e->getMessage(), 500);
        }
    }
}

