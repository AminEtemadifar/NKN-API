<?php

namespace App\Models;

use App\Http\Enums\GenderEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Doctor extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $appends = ['full_name'];

    protected $fillable = [
        'first_name',
        'last_name',
        'code',
        'sub_title',
        'short_description',
        'redirect',
        'description',
        'gender',
        'hospital_id',
        'status'
    ];


    // Mutator
    public function setGenderAttribute($value)
    {
        if ($value == 'male') {
            $this->attributes['gender'] = GenderEnum::MALE->value;
        } elseif ($value == 'female') {
            $this->attributes['gender'] = GenderEnum::FEMALE->value;
        } else {
            $this->attributes['gender'] = null;
            //TODO Exception
        }
    }

    // Define an accessor for the full_name attribute
    public function getFullNameAttribute()
    {
        return 'دکتر ' . $this->first_name . ' ' . $this->last_name;
    }

    // Accessor
    public function getGenderAttribute($value)
    {
        return
            $value == GenderEnum::MALE->value ? 'male' :
                ($value == GenderEnum::FEMALE->value ? 'female' : null);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('image');
        $this->addMediaConversion('portfolio');
    }

    /**
     * The roles that belong to the user.
     */
    public function terms(): BelongsToMany
    {
        return $this->belongsToMany(Term::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }

    public function getDefaultMedia(): object
    {
        return (object)([
            'id' => 0,
            'file_name' => 'default.png',
            'preview_url' => env('APP_URL') . '/Images/Doctors/default.png',
            'original_url' => env('APP_URL') . '/Images/Doctors/default.png',
            'extension' => 'image/png',
            'size' => '122',
        ]);
    }
}
