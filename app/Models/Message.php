<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Connection;
use MongoDB\Laravel\Eloquent\HybridRelations;
use App\Models\User;

#[Fillable(['sender_id','receiver_id', 'message_content'])]
#[Connection('mongodb')]
class Message extends Model
{
    use HybridRelations;

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }


}
