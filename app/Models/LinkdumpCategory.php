<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Linkdump;

class LinkdumpCategory extends Model
{
    use HasFactory;

    public function links(): HasMany
    {
        return $this->hasMany(Linkdump::class);
    }
}
