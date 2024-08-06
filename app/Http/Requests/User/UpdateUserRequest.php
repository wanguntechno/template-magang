<?php

namespace App\Http\Requests\User;

use App\Helpers\FormRequest;
use App\Rules\ExistsUuid;
use App\Rules\UniqueData;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ('');
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
        // $user_uuid = request()->route()->parameter('user');
        return [
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
