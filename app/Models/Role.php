<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    // Relationships
    public function users()
    {  
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
       //return $this->belongsToMany(\App\Models\User::class, 'role_user', 'role_id', 'user_id');
        //return $this->belongsToMany(User::class);
    }

   /* public function permissions()
    {
    //return $this->belongsToMany(Permission::class);
     return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id');
    } */
public function permissions()
{
    return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id');
}

    // Helper methods
    public function hasPermission($permission)
    {
        if (is_string($permission)) {
            return $this->permissions->contains('name', $permission);
        }
        
        return $this->permissions->contains($permission);
    }

    public function givePermissionTo($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->first();
        }
        
        if ($permission && !$this->hasPermission($permission)) {
            $this->permissions()->attach($permission);
        }
        
        return $this;
    }

    public function revokePermissionTo($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->first();
        }
        
        if ($permission) {
            $this->permissions()->detach($permission);
        }
        
        return $this;
    }
}
