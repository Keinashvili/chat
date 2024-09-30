<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $chat_id
 * @property int $sender_id
 * @property string $message
 * @property string $status
*/
class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'chat_id',
        'sender_id',
        'message',
        'status',
    ];

    public function sender(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'sender_id');
    }
}
