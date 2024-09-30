<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read int $id
 * @property string $name
 * @property string $type
*/
class Chat extends Model
{
    protected $table = 'chats';

    protected $fillable = [
        'name',
        'type',
    ];

    public function message(): HasMany
    {
        return $this->hasMany(Message::class, 'chat_id', 'id',);
    }

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
