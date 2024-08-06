<?php
namespace App\Services\TenantService;

use App\Models\Tenant;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class DeleteTenant extends DefaultService implements ServiceInterface {

    public function process ($dto) {
        $dto = $this->prepare($dto);

        $tenant = Tenant::find($dto['tenant_id']);

        $this->results['message'] = "Tenant successfully deleted";
        $this->results['data'] = $this->activeAndRemoveData($tenant, $dto);
    }

    public function prepare ($dto) {
        $dto['tenant_id'] = $this->findIdByUuid(Tenant::query(), $dto['tenant_uuid']);
        return $dto;
    }

    public function rules ($dto) {
        return [
            'tenant_uuid' => ['required', 'uuid', new ExistsUuid('tenants')]
        ];
    }

}
