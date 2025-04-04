<?php

namespace App\Models;

use App\Http\Enums\GenderEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Blog extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'sub_title',
        'description',
        'duration',
        'published_at',
    ];
    //protected $hidden = ['description'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Mutator
    public function setPublishAttribute($value)
    {
        if ($value) {
            $this->attributes['published_at'] = Carbon::now()->toDateTime();
        } else {
            $this->attributes['published_at'] = null;
        }
    }
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('main_image');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
