<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles;
    /** 
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int,string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships

     public function roles()
{       
     // belongsToMany(RelatedModel::class, pivot_table_name, foreign_key_on_pivot_for_this_model, foreign_key_on_pivot_for_related_model)
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
      //  return $this->belongsToMany(Role::class,'role_user');
    }

    // Helper methods for roles and permissions
    public function hasRole($role)
    {
       // print_r($role);
        //die;
       if (in_array($role, ['admin', 'teacher', 'student'])) {
    return true;
} else {
    return false;
} 

    }

    public function hasPermission($permission)
    {
        foreach ($this->roles as $role) {
            if ($role->hasPermission($permission)) {
                return true;
            }
        }
        
        return false;
    }

    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }
        
        if ($role && !$this->hasRole($role)) {
            $this->roles()->attach($role);
        }
        
        return $this;
    }

    // In your User model, you can add a getter
public function getRoleName() {
    if ($this->role === 1) {
        return 'admin';
    } elseif ($this->role === 2) {
        return 'teacher';
    } else {
        return 'student';
    }
}

    public function removeRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }
        
        if ($role) {
            $this->roles()->detach($role);
        }
        
        return $this;
    }

    public function isAdmin(): bool
    { 
     return $this->hasRole('admin');
    }

    public function isTeacher(): bool
    {
     return $this->hasRole('teacher');
    }

    public function isStudent(): bool
    {
        return $this->hasRole('student');
    }
     public function isHeadMaster()
    {
        return $this->hasRole('HeadMaster');
    }
}
