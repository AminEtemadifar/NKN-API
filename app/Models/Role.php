<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['key', 'name' , 'editable'];

    protected $casts = [
        'editable ' => 'boolean'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
