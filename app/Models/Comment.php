<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = [
        'name',
        'email',
        'body',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
