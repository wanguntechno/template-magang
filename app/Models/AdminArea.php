<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminArea extends Model
{
    use HasFactory;

    protected $table = 'admin_areas';

    protected $fillable = [
        'admin_id',
        'area_id'
    ];

    protected $hidden = [
        'admin_id',
        'area_id'
    ];
    public $timestamps = false;

    public function admin () {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function area () {
        return $this->belongsTo(Area::class, 'area_id');
    }
}
