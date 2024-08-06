<?php

namespace App\Http\Requests\Area;

use App\Helpers\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditAreaRequest extends FormRequest
{
    /**
     * Determine if the area is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return have_permission('area_edit');
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
        return [];
    }

    public function messages()
    {
        return [];
    }
}
