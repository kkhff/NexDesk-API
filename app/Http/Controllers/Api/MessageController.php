<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Http\Resources\MessageResource;
use App\Events\MessageSent;

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
            'message_content' => $request->message_content,
            'read_at' => null,
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

    public function update(Request $request, string $id)
    {
        $message = Message::findOrFail($id);

        if ($message->created_at->lt(now()->subMinutes(60))) {
            return response()->json([
                'message' => 'Sudah lebih 60 menit'
            ],403);
        }

        if ($message->sender_id !== auth()->id()) {
            return response()->json([
            'message' => 'Anda tidak berhak!!',
            ],403);
        }

        $request->validate([
            'message_content' => 'string|required',
        ]);

        $message->update([
            'message_content' => $request->message_content,
        ]);

        $message->refresh();

        return (new MessageResource($message))->additional([
            'success' => true,
            'message' => 'pesan berhasil di perbarui',
        ],200);
    }

    public function destroy(string $id)
    {
        $message = Message::findOrFail($id);

        if ($message->sender_id !== auth()->id()) {
            return response()->json([
            'message' => 'Anda tidak berhak!!',
            ],403);
        }

        $message->delete();

        return response()->json([
            'success' => true,
            'message' => 'pesan berhasil di hapus'
        ]);
    }

    public function markAsRead(Request $request)
    {
        $friend_id = (int) $request->friend_id;
        $user_id = auth()->id();

        $messageCount = Message::where('sender_id', $friend_id)
                   ->where('receiver_id', $user_id)
                   ->whereNull('read_at')
                   ->update([
                       'read_at' => now()
                   ]);


        return response()->json([
                'success' => true,
                'message' => 'Pesan telah dibaca',
                'total_updated' => $messageCount    ,
        ]);
    }
}
