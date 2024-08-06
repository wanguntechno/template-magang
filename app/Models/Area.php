<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Area extends Model
{
    use HasFactory;

    protected $table = 'areas';

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

    public function tenant () {
        return $this->hasMany(Tenant::class, 'area_id');
    }

    public function admin () : HasManyThrough{
        return $this->hasManyThrough(Admin::class, AdminArea::class);
    }
}
