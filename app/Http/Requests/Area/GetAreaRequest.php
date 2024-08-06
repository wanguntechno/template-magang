<?php

namespace App\Http\Requests\Area;

use App\Helpers\FormRequest;
use App\Traits\Identifier;
use Illuminate\Http\Exceptions\HttpResponseException;

class GetAreaRequest extends FormRequest
{
    use Identifier;

    /**
     * Determine if the area is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return have_permission('area_view');
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
