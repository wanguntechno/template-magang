<?php
namespace App\Services\TenantUserService;

use App\Models\TenantUser;
use App\Models\Tenant;
use App\Models\User;
use App\Rules\ExistsUuid;
use App\Rules\UniqueData;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class StoreTenantUser extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $tenant_user = new TenantUser;
        $dto = $this->prepare($dto);

        $tenant_user->user_id = $dto['user_id'];
        $tenant_user->tenant_id = $dto['tenant_id'];
        $tenant_user->name = $dto['name'];
        $tenant_user->phone_number = $dto['phone_number'];
        $tenant_user->address = $dto['address'] ?? null;
        $tenant_user->employee_number = $dto['employee_number'];

        $this->prepareAuditActive($tenant_user);
        $this->prepareAuditInsert($tenant_user);
        $tenant_user->save();

        $this->results['data'] = $tenant_user;
        $this->results['message'] = "Tenant User successfully stored";
    }

    public function prepare ($dto) {
        if (isset($dto['user_uuid']))
        $dto['user_id'] = $this->findIdByUuid(User::query(), $dto['user_uuid']);

        if (isset($dto['tenant_uuid']))
        $dto['tenant_id'] = $this->findIdByUuid(Tenant::query(), $dto['tenant_uuid']);

        return $dto;
    }

    public function rules ($dto) {
        return [
            'user_uuid' => ['required', 'uuid', new ExistsUuid('users')],
            'tenant_uuid' => ['required', 'uuid', new ExistsUuid('tenants')],
            'name' => ['required'],
            'phone_number' => ['required', 'numeric', new UniqueData('admins','phone_number')],
            'adddress' => ['nullable'],
            'employee_number' => ['required', new UniqueData('admins','employee_number')]
        ];
    }

}
