<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class LangCode extends Model
{
    use HasFactory;

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'lang_code', 'name');
    }

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class, 'lang_code', 'name');
    }

    public function stories(): HasMany
    {
        return $this->hasMany(Story::class, 'lang_code', 'name');
    }

    public function comments(): HasManyThrough
    {
        return $this->throughPosts()->hasComments();
    }

    public function ldCategories(): HasMany
    {
        return $this->hasMany(LinkdumpCategory::class, 'lang_code', 'name');
    }

    public function ldLinks(): HasManyThrough
    {
        return $this->throughLdCategories()->hasLinks();
    }
}
