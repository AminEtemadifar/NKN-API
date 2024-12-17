<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Taxonomy extends Model
{
    use SoftDeletes;
    protected $fillable = ['title', 'key'];

    /**
     * Scope a query to only services taxonomy.
     */
    public function scopeServices(Builder $query): void
    {
        $query->where('key', 'services');
    }

    public function terms(): HasMany
    {
        return $this->hasMany(Term::class , 'taxonomy_id' , 'id');
    }
}
