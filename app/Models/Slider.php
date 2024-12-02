<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Slider extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['title', 'description', 'key'];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumbnails');
    }

    public function slides()
    {
        return $this->hasMany(Slide::class , 'slider_id' , 'id');
    }

}
