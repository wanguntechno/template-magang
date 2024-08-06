<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellingGood extends Model
{
    use HasFactory;

    protected $table = 'selling_goods';

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
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function photo () {
        return $this->belongsTo(FileStorage::class, 'file_storage_id');
    }

    public function itemCategory () {
        return $this->belongsTo(ItemCategory::class, 'item_category_id');
    }
}
