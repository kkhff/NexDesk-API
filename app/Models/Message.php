<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Connection;

#[Fillable(['sender_id','receiver_id', 'message_content'])]
#[Connection('mongodb')]
class Message extends Model
{

}
