<?php

namespace App\Http\Requests\Tenant;

use App\Helpers\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateTenantRequest extends FormRequest
{
    /**
     * Determine if the tenant is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return have_permission('tenant_edit');
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
            'tenant_name' => ['required'],
            'tenant_phone_number' => ['required'],
            'tenant_bank_account_name' => ['required'],
            'tenant_bank_account_number' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'tenant_name.required' => 'Nama Tenant harus diisi',
            'tenant_phone_number.required' => 'Nomor Telepon Tenant harus diisi',
            'tenant_bank_account_name.required' => 'Nama Pemilik Rekening harus diisi',
            'tenant_bank_account_number.required' => 'Nomor rekening harus diisi'
        ];
    }
}
