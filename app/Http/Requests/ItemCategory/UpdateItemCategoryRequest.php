<?php

namespace App\Http\Requests\ItemCategory;

use App\Helpers\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateItemCategoryRequest extends FormRequest
{
    /**
     * Determine if the item category is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return have_permission('item_category_edit');
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
            'item_category_name' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'item_category_name.required' => 'Nama Item Category harus diisi',
        ];
    }
}
