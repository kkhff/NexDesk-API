<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Http\Resources\MessageResource;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'integer|required',
            'message_content' => 'string|required',
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => (int) $request->receiver_id,
            'message_content' => $request->message_content
        ]);

        return (new MessageResource($message))->additional([
            'success' => true,
            'message' => 'Pesan berhasil dikirim',
        ],200);
    }

    public function index(Request $request)
    {
        $friend_id = (int) $request->friend_id;
        $user_id = auth()->id();

        $message = Message::where(function($query) use ($user_id, $friend_id) {
            $query->where('sender_id', $user_id)
                  ->where('receiver_id', $friend_id);
        })->orWhere(function($query) use ($user_id, $friend_id) {
            $query->where('sender_id', $friend_id)
                  ->where('receiver_id', $user_id);
        });

        return MessageResource::collection($message->with(['sender', 'receiver'])->latest()->paginate(20));
    }
}
