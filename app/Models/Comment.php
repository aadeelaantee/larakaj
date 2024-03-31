<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function avatar($size = 128): string
    {
        $digest = md5(strtolower($this->email));
        return "https://www.gravatar.com/avatar/{$digest}?d=identicon&s={$size}";
    }
}
