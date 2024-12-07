<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'phone',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }


    // Check if user has a specific role
    public function hasRole($role)
    {
        return $this->roles->contains('key', $role);
    }

    // Many-to-many relationship with Role
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Assign a role to the user.
     */
    public function assignRole($role)
    {
        // Find the role by name, or fail if not found
        $roleInstance = Role::where('key', $role)->first();

        if ($roleInstance) {
            // Attach the role to the user
            $this->roles()->attach($roleInstance);
        } else {
            throw new \Exception("Role '{$role}' not found.");
        }
    }

    /**
     * Remove a role from the user.
     */
    public function removeRole($role)
    {
        // Find the role by name, or fail if not found
        $roleInstance = Role::where('name', $role)->first();

        if ($roleInstance) {
            // Detach the role from the user
            $this->roles()->detach($roleInstance);
        } else {
            throw new \Exception("Role '{$role}' not found.");
        }
    }
}
