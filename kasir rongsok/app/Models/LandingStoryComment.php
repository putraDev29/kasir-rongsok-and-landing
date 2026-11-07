<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LandingStoryComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'story_id',
        'user_name',
        'comment',
        'original_comment',
        'detected_language',
        'is_translated',
        'likes_count',
        'is_approved',
    ];

    protected $casts = [
        'likes_count' => 'integer',
        'is_translated' => 'boolean',
        'is_approved' => 'boolean',
    ];

    public function story(): BelongsTo
    {
        return $this->belongsTo(LandingStory::class, 'story_id');
    }
}

