<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageEvent;
use App\Events\TypingEvent;
use App\Events\UserStatusEvent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Models\UserStatus;
use App\Services\EmotionDetector;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function getMessages(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
        ]);

        $messages = Message::where('room_id', $validated['room_id'])
            ->with('userProfile')
            ->latest()
            ->take(50)
            ->get()
            ->map(function ($message) {
                if (in_array($message->type, ['photo', 'voice'])) {
                    $message->content = Storage::url($message->content);
                }
                $message->display_name = $message->userProfile->display_name ?? $message->userProfile->username;
                return $message;
            });

        return response()->json($messages);
    }
    public function sendMessage(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'message' => 'nullable|string|max:1000',
            'file' => 'nullable|file|mimes:jpg,jpeg,png|max:10240', // 10MB max for photos
            'type'=> 'nullable|string|in:text,voice,photo,emoji',
        ]);
    $emotion = EmotionDetector::detect($validated['message'] ?? '');
        // Ensure at least one of message or file is provided
        if (!$request->has('message') && !$request->hasFile('file')) {
            return response()->json(['error' => 'Message or file is required'], 422);
        }

        $type = 'text';
        $content = $validated['message'] ?? '';

        // Determine message type
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $type = 'photo';
            $content = $file->store('chat_files', 'public');
            $content = Storage::url($content);
        } elseif ($this->isEmoji($validated['message'])) {
            $type = 'emoji';
        }

        Message::create([
            'user_id' => $validated['user_id'],
            'room_id' => $validated['room_id'],
            'type' => $type,
            'content' => $content,
            'emotion' => $emotion,
        ]);

        event(new ChatMessageEvent(
            $validated['user_id'],
            $validated['room_id'],
            $type,
            $content,
            $emotion
        ));

        $this->updateUserStatus($validated['user_id'], $validated['room_id'], 'online');

        return response()->json(['message'=>"Message sent successfully"], 200);
    }

public function typing(Request $request): JsonResponse
{
$validated = $request->validate([
    'user_id' => 'required|exists:users,id',
    'room_id' => 'required|exists:rooms,id',
]);
$user=User::find($validated['user_id']);


event(new TypingEvent($validated['user_id'], $validated['room_id'],$user->avatar));

    return response()->json(['message' => 'Typing broadcasted']);
}

       private function updateUserStatus(string $user_id, string $room_id, string $status): void
    {
        UserStatus::updateOrCreate(
            ['user_id' => $user_id, 'room_id' => $room_id],
            ['status' => $status, 'last_active_at' => now()]
        );

        event(new UserStatusEvent($user_id, $room_id, $status));
    }

    private function isEmoji(string $message): bool
    {
        // Simple regex to detect emoji (covers common Unicode emojis)
        return preg_match('/[\x{1F300}-\x{1F9FF}]/u', $message) === 1;
    }
}
