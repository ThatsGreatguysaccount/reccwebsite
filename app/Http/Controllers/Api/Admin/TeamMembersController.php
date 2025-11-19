<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Models\TeamMember;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMembersController extends ApiController
{
    /**
     * Get all team members
     */
    public function index(): JsonResponse
    {
        try {
            $teamMembers = TeamMember::orderBy('order')->orderBy('created_at')->get();
            
            return $this->success([
                'team_members' => $teamMembers->map(function ($member) {
                    return [
                        'id' => $member->id,
                        'name' => $member->name,
                        'designation' => $member->designation,
                        'email' => $member->email,
                        'photo' => $member->photo_url,
                        'order' => $member->order,
                        'is_active' => $member->is_active,
                        'created_at' => $member->created_at,
                        'updated_at' => $member->updated_at,
                    ];
                }),
            ], 'Team members retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve team members: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Create a new team member
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'designation' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'order' => 'nullable|integer|min:0',
                'is_active' => 'nullable|boolean',
            ]);

            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $this->processAndStorePhoto($request->file('photo'));
            }

            $teamMember = TeamMember::create([
                'name' => $validated['name'],
                'designation' => $validated['designation'],
                'email' => $validated['email'] ?? null,
                'photo' => $photoPath,
                'order' => $validated['order'] ?? 0,
                'is_active' => $validated['is_active'] ?? true,
            ]);

            return $this->success([
                'team_member' => [
                    'id' => $teamMember->id,
                    'name' => $teamMember->name,
                    'designation' => $teamMember->designation,
                    'email' => $teamMember->email,
                    'photo' => $teamMember->photo_url,
                    'order' => $teamMember->order,
                    'is_active' => $teamMember->is_active,
                ],
            ], 'Team member created successfully', 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error('Validation failed', 422, $e->errors());
        } catch (\Exception $e) {
            return $this->error('Failed to create team member: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update a team member
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $teamMember = TeamMember::findOrFail($id);

            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'designation' => 'sometimes|required|string|max:255',
                'email' => 'nullable|email|max:255',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'order' => 'nullable|integer|min:0',
                'is_active' => 'nullable|boolean',
            ]);

            // Handle photo upload
            if ($request->hasFile('photo')) {
                // Delete old photo if exists
                if ($teamMember->photo && Storage::disk('public')->exists($teamMember->photo)) {
                    Storage::disk('public')->delete($teamMember->photo);
                }
                $validated['photo'] = $this->processAndStorePhoto($request->file('photo'));
            }

            $teamMember->update($validated);

            return $this->success([
                'team_member' => [
                    'id' => $teamMember->id,
                    'name' => $teamMember->name,
                    'designation' => $teamMember->designation,
                    'email' => $teamMember->email,
                    'photo' => $teamMember->photo_url,
                    'order' => $teamMember->order,
                    'is_active' => $teamMember->is_active,
                ],
            ], 'Team member updated successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->error('Team member not found', 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error('Validation failed', 422, $e->errors());
        } catch (\Exception $e) {
            return $this->error('Failed to update team member: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Delete a team member
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $teamMember = TeamMember::findOrFail($id);

            // Delete photo if exists
            if ($teamMember->photo && Storage::disk('public')->exists($teamMember->photo)) {
                Storage::disk('public')->delete($teamMember->photo);
            }

            $teamMember->delete();

            return $this->success(null, 'Team member deleted successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->error('Team member not found', 404);
        } catch (\Exception $e) {
            return $this->error('Failed to delete team member: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Process and store photo with automatic resizing
     * Resizes to 350x450px (portrait format) with center cropping
     * Optimizes file size and ensures consistent dimensions
     */
    private function processAndStorePhoto($file): string
    {
        // Check if GD extension is available
        if (!extension_loaded('gd')) {
            // Fallback: store original if GD is not available
            // Note: Enable GD extension in php.ini for automatic resizing
            // Uncomment: extension=gd in C:\xampp\php\php.ini
            \Log::warning('GD extension not available, storing original image. Enable GD in php.ini for automatic resizing.');
            return $file->store('team-members', 'public');
        }

        $targetWidth = 350;
        $targetHeight = 450;
        $quality = 85; // JPEG quality (0-100)

        // Get image info
        $imageInfo = getimagesize($file->getRealPath());
        if (!$imageInfo) {
            throw new \Exception('Invalid image file');
        }

        [$originalWidth, $originalHeight, $imageType] = $imageInfo;

        // Create image resource based on type
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $sourceImage = imagecreatefromjpeg($file->getRealPath());
                break;
            case IMAGETYPE_PNG:
                $sourceImage = imagecreatefrompng($file->getRealPath());
                break;
            case IMAGETYPE_GIF:
                $sourceImage = imagecreatefromgif($file->getRealPath());
                break;
            default:
                throw new \Exception('Unsupported image type');
        }

        if (!$sourceImage) {
            throw new \Exception('Failed to create image resource');
        }

        // Calculate dimensions for center cropping (portrait format: 350x450 = 7:9 ratio)
        $targetAspectRatio = $targetWidth / $targetHeight; // 350/450 = 0.777...
        $originalAspectRatio = $originalWidth / $originalHeight;
        
        // Calculate crop size to match target aspect ratio from center
        if ($originalAspectRatio > $targetAspectRatio) {
            // Original is wider than target: crop width to match target ratio
            $cropHeight = $originalHeight;
            $cropWidth = (int) ($cropHeight * $targetAspectRatio);
            $cropX = (int) (($originalWidth - $cropWidth) / 2);
            $cropY = 0;
        } else {
            // Original is taller than target: crop height to match target ratio
            $cropWidth = $originalWidth;
            $cropHeight = (int) ($cropWidth / $targetAspectRatio);
            $cropX = 0;
            $cropY = (int) (($originalHeight - $cropHeight) / 2);
        }

        // Create new portrait image
        $newImage = imagecreatetruecolor($targetWidth, $targetHeight);
        
        // White background for all images (better for team photos)
        $white = imagecolorallocate($newImage, 255, 255, 255);
        imagefill($newImage, 0, 0, $white);

        // Resize and copy image with center crop
        imagecopyresampled(
            $newImage,
            $sourceImage,
            0,
            0,
            $cropX,
            $cropY,
            $targetWidth,
            $targetHeight,
            $cropWidth,
            $cropHeight
        );

        // Generate unique filename
        $filename = uniqid('team_', true) . '.jpg';
        $path = 'team-members/' . $filename;
        $fullPath = storage_path('app/public/' . $path);

        // Ensure directory exists
        $directory = dirname($fullPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Save as JPEG (smaller file size)
        imagejpeg($newImage, $fullPath, $quality);

        // Clean up memory
        imagedestroy($sourceImage);
        imagedestroy($newImage);

        return $path;
    }
}

