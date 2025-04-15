<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Taxonomy extends Model
{
    use SoftDeletes;

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

}
