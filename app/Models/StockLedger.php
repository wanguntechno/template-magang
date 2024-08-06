<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLedger extends Model
{
    use HasFactory;

    protected $table = 'stock_ledgers';

    protected $hidden = [
        'id',
        'selling_good_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'updated_at',
        'deleted_at',
        'is_active',
        'version'
    ];

    public $timestamps = false;

    public function sellingGood () {
        return $this->belongsTo(SellingGood::class, 'selling_good_id');
    }
}
