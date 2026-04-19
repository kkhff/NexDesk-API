<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

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
            'receiver_id' => $request->receiver_id,
            'message_content' => $request->message_content
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dikirim',
            'data' => $message,
        ],200);
    }

    public function index(Request $request)
    {
        $message = Message::where(function($query) use ($request) {
            $query->where('sender_id', auth()->id())
                  ->where('receiver_id', $request->teman_id);
        })->orWhere(function($query) use ($request) {
            $query->where('sender_id', $request->teman_id)
                  ->where('receiver_id', auth()->id());
        })->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $message,
        ]);
    }
}
