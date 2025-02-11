<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Blog extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'title',
        'sub_title',
        'description',
        'duration',
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('main_image');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
