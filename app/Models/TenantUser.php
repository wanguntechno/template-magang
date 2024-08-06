<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantUser extends Model
{
    use HasFactory;

    protected $table = 'tenant_users';

    protected $hidden = [
        'id',
        'user_id',
        'tenant_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'updated_at',
        'deleted_at',
        'is_active',
        'version'
    ];

    public $timestamps = false;

    public function tenant () {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function user () {
        return $this->belongsTo(User::class, 'user_id');
    }
}
