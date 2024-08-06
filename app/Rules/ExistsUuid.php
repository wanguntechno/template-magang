<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class ExistsUuid implements ValidationRule
{
    protected $table, $cols, $vals;

    public function __construct($table, $cols = null, $vals = null)
    {
        $this->table = $table;
        $this->cols = $cols;
        $this->vals = $vals;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strpos($value, ',') !== false) {
            $splittedValue = explode(',', $value);
            $query = DB::table($this->table)->whereIn('uuid', $splittedValue)->where('deleted_at', null);
        } else {
            $query = DB::table($this->table)->where('uuid', $value)->where('deleted_at', null);
        }

        $this->cols != null and $this->vals != null ? $query->where($this->cols, $this->vals) : '';
        $result = !empty($query->first()) ? true : false;

        if($result == false){
            $fail('UUID tidak ditemukan.');
        }
    }
}
