<?php

namespace App\Http\Requests\Tenant\TenantUser;

use App\Helpers\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateTenantUserRequest extends FormRequest
{
    /**
     * Determine if the tenant user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return have_permission('tenant_user_edit');
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
            'tenant_user_name' => ['required'],
            'tenant_user_employee_number' => ['required'],
            'tenant_user_phone_number' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'tenant_user_name.required' => 'Nama Karyawan harus diisi',
            'tenant_user_employee_number.required' => 'Nomor Induk Karyawan harus diisi',
            'tenant_user_phone_number.required' => 'Nomor Telepon Karyawan harus diisi',
        ];
    }
}
