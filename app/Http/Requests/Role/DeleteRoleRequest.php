<?php

namespace App\Http\Requests\Role;

use App\Helpers\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeleteRoleRequest extends FormRequest
{
    /**
     * Determine if the role is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return have_permission('role_delete');
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