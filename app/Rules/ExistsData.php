<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class ExistsData implements ValidationRule
{
    protected $table, $cols;

    public function __construct($table, $cols = null)
    {
        $this->table = $table;
        $this->cols = $cols;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = DB::table($this->table)->where($this->cols, $value)->where('deleted_at', null);
        $result = !empty($query->first()) ? true : false;

        if($result == false){
            $fail(':attribute sudah ada.');
        }
    }
}
