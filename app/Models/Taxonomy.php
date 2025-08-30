<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use function PHPUnit\Framework\matches;

class Taxonomy extends Model
{
    use SoftDeletes;

    // Define constants for each key
    const EXPERTISE_KEY = 'expertise';
    const DEGREE_LEVEL_KEY = 'degreeLevel';
    const HOSPITAL_KEY = 'hospital';

    protected $fillable = ['title', 'key'];

    public function terms(): HasMany
    {
        return $this->hasMany(Term::class , 'taxonomy_id' , 'id');
    }
    public function scopeExpertise(Builder $query): Builder
    {
        return $query->where('key' , 'expertise');
    }
    public function scopeDegreeLevel(Builder $query): Builder
    {
        return $query->where('key' , 'degreeLevel');
    }


    public static function getTaxonomyIdByKey($key)
    {
        $taxonomy = self::where('key', $key)->first();
        return $taxonomy ? $taxonomy->id : null;
    }

}
