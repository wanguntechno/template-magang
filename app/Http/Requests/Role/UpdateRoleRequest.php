<?php

namespace App\Http\Requests\Role;

use App\Helpers\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRoleRequest extends FormRequest
{
    /**
     * Determine if the role is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return have_permission('role_edit');
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
            'role_name' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'role_name.required' => 'Nama Role harus diisi'
        ];
    }
}
