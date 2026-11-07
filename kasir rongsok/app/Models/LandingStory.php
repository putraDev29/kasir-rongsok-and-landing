<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LandingStory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'tag',
        'image_path',
        'caption',
        'likes_count',
        'order',
        'is_active',
    ];

    protected $casts = [
        'likes_count' => 'integer',
        'order' => 'integer',
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'image_url',
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(LandingStoryComment::class, 'story_id')
            ->where('is_approved', true)
            ->orderBy('id', 'desc');
    }

    public function getImageUrlAttribute(): string
    {
        if (empty($this->image_path)) {
            return 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=1200&auto=format&fit=crop';
        }

        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }

        return asset($this->image_path);
    }
}

