<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';

    protected $fillable = [];

    protected $hidden = [
        'id',
        'created_by',
        'updated_by',
        'deleted_by',
        'updated_at',
        'deleted_at',
        'is_active',
        'version'
    ];

    public $timestamps = false;

    public static function listActiveRole (Array $role_id = [1]) {
        return Role::whereNotIn('id',$role_id)->where('is_active',1)->where('deleted_at',null)->orderBy('name','asc')->get();
    }

    public function userRole () {
        return $this->hasMany(UserRole::class, 'role_id');
    }

    public function rolePermission () {
        return $this->hasMany(RolePermission::class, 'role_id');
    }
}
