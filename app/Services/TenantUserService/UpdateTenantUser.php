<?php
namespace App\Services\TenantUserService;

use App\Models\Tenant;
use App\Services\DefaultService;
use App\Services\ServiceInterface;
use App\Models\TenantUser;
use App\Models\User;
use App\Rules\ExistsUuid;
use App\Rules\UniqueData;

class UpdateTenantUser extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto = $this->prepare($dto);
        $tenant_user = TenantUser::find($dto['tenant_user_id']);

        $tenant_user->tenant_id = $dto['tenant_id'] ?? $tenant_user->tenant_id;
        $tenant_user->user_id = $dto['user_id'] ?? $tenant_user->user_id;
        $tenant_user->name = $dto['name'] ?? $tenant_user->name;
        $tenant_user->phone_number = $dto['phone_number'] ?? $tenant_user->phone_number;
        $tenant_user->address = $dto['address'] ?? $tenant_user->address;
        $tenant_user->employee_number = $dto['employee_number'] ?? $tenant_user->employee_number;

        $this->prepareAuditUpdate($tenant_user);
        $tenant_user->save();

        $this->results['data'] = $tenant_user;
        $this->results['message'] = "Tenant User successfully updated";
    }

    public function prepare ($dto) {
        if (isset($dto['tenant_user_uuid']))
        $dto['tenant_user_id'] = $this->findIdByUuid(TenantUser::query(), $dto['tenant_user_uuid']);

        if (isset($dto['tenant_uuid']))
        $dto['tenant_id'] = $this->findIdByUuid(Tenant::query(), $dto['tenant_uuid']);

        if (isset($dto['user_uuid']))
        $dto['user_id'] = $this->findIdByUuid(User::query(), $dto['user_uuid']);

        return $dto;
    }

    public function rules ($dto) {
        return [
            'tenant_user_uuid' => ['required', 'uuid', new ExistsUuid('tenant_users')],
            'tenant_uuid' => ['required', 'uuid', new ExistsUuid('tenant_users')],
            'user_uuid' => ['required', 'uuid', new ExistsUuid('users')],
            'name' => ['required'],
            'phone_number' => ['required', 'numeric', new UniqueData('tenant_users','phone_number')],
            'adddress' => ['nullable'],
            'employee_number' => ['required', new UniqueData('tenant_users','employee_number')]
        ];
    }

}
