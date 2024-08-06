<?php

namespace App\Http\Requests\ItemCategory;

use App\Helpers\FormRequest;
use App\Traits\Identifier;
use Illuminate\Http\Exceptions\HttpResponseException;

class GetItemCategoryRequest extends FormRequest
{
    use Identifier;

    /**
     * Determine if the item category is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return have_permission('item_category_view');
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
            //
        ];
    }
}
