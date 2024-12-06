<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Slide extends Model implements HasMedia
{
    use InteractsWithMedia , SoftDeletes;

    protected $fillable = ['name', 'description', 'ordering', 'slider_id', 'link', 'extra_data'];

    protected $casts = [
        'extra_data' => 'object'
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('image');
    }
}
