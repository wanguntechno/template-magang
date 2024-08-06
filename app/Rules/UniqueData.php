<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueData implements ValidationRule
{
    protected $uuid;

    protected $table;

    protected $column;

    public function __construct($table, $column, $uuid = null)
    {
        $this->table = $table;
        $this->column = $column;
        $this->uuid = $uuid;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = DB::table($this->table)->where($this->column, $value)->where('deleted_at', null);
        $this->uuid != null ? $query->where('uuid', '!=', $this->uuid) : null;
        $result = empty($query->first()) ? true : false;
        
        if($result == false){
            $fail('Atribut :attribute sudah digunakan.');
        }
    }
}
