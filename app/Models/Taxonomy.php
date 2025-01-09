<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Taxonomy extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'key'];

    public function terms(): HasMany
    {
        return $this->hasMany(Term::class , 'taxonomy_id' , 'id');
    }
    public function scopeExpertise()
    {
        return $this->where('key' , 'expertise');
    }
    public function scopeDegreeLevel()
    {
        return $this->where('key' , 'degreeLevel');
    }

}
