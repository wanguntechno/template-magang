<?php
namespace App\Services\TenantUserService;

use App\Models\TenantUser;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class DeleteTenantUser extends DefaultService implements ServiceInterface {

    public function process ($dto) {
        $dto = $this->prepare($dto);

        $tenant_user = TenantUser::find($dto['tenant_user_id']);

        $this->results['message'] = "Tenant User successfully deleted";
        $this->results['data'] = $this->activeAndRemoveData($tenant_user, $dto);
    }

    public function prepare ($dto) {
        $dto['tenant_user_id'] = $this->findIdByUuid(TenantUser::query(), $dto['tenant_user_uuid']);
        return $dto;
    }

    public function rules ($dto) {
        return [
            'tenant_user_uuid' => ['required', 'uuid', new ExistsUuid('tenant_users')]
        ];
    }

}
