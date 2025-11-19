<?php

namespace App\Http\Controllers\Api;

use App\Models\TeamMember;
use Illuminate\Http\JsonResponse;

class PublicTeamMembersController extends ApiController
{
    /**
     * Get all active team members for public display
     */
    public function index(): JsonResponse
    {
        try {
            $teamMembers = TeamMember::where('is_active', true)
                ->orderBy('order')
                ->orderBy('created_at')
                ->get();
            
            return $this->success([
                'team_members' => $teamMembers->map(function ($member) {
                    return [
                        'id' => $member->id,
                        'name' => $member->name,
                        'designation' => $member->designation,
                        'email' => $member->email,
                        'photo' => $member->photo_url,
                    ];
                }),
            ], 'Team members retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve team members: ' . $e->getMessage(), 500);
        }
    }
}

