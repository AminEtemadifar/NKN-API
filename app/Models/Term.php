<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Term extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'is_main',
        'is_filter',
        'is_footer',
        'taxonomy_id',
    ];

    protected $casts = [
        'is_main' => "boolean",
        'is_filter' => "boolean",
        'is_footer' => "boolean",
    ];

    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class, 'taxonomy_id', 'id');
    }

    public function scopeFilterable(Builder $query): Builder
    {
        return $query->where('is_filter', true);
    }

    public function scopeIsMain(Builder $query): Builder
    {
        return $query->where('is_main', true);
    }
}
