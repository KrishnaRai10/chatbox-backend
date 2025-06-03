<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function getUsersByRoomId(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
        ]);

        $users = UserStatus::where('room_id', $validated['room_id'])
            ->with('userProfile')
            ->get()
            ->map(function ($user) {
                $user->display_name = $user->userProfile->display_name ?? $user->username;
                $user->avatar = $user->userProfile->avatar ? Storage::url($user->userProfile->avatar) : null;
                return $user;
            });

        return response()->json($users);
    }
}
