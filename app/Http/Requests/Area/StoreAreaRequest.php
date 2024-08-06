<?php

namespace App\Http\Requests\Area;

use App\Helpers\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAreaRequest extends FormRequest
{
    /**
     * Determine if the area is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return have_permission('area_create');
    }
    
    protected function failedAuthorization()
    {
        throw new HttpResponseException(response()->view('errors.403', [], 403));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'area_name' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'area_name.required' => 'Nama Area harus diisi'
        ];
    }
}
