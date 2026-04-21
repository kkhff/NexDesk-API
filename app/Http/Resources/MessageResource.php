<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string) $this->_id,
            'sender_id' => $this->sender_id,
            'sender_name' => $this->sender->name ?? 'unkwown',
            'receiver_id' => $this->receiver_id,
            'receiver_name' => $this->receiver->name ?? 'unknown',
            'message_content' => $this->message_content,
            'date_message' => $this->created_at->format('d M Y H:i'),
        ];
    }
}
