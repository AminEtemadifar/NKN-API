<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Hospital extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['name', 'address', 'address_link', 'website_link', 'fax', 'email'];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('image');
        $this->addMediaConversion('main_thumbnail');
        $this->addMediaConversion('thumbnail');
    }
}
