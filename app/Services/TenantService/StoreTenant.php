<?php
namespace App\Services\TenantService;

use App\Models\Area;
use App\Models\Tenant;
use App\Rules\ExistsUuid;
use App\Rules\UniqueData;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class StoreTenant extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $tenant = new Tenant;
        $dto = $this->prepare($dto);

        $tenant->area_id = $dto['area_id'];
        $tenant->name = $dto['name'];
        $tenant->email = $dto['email'];
        $tenant->phone_number = $dto['phone_number'];
        $tenant->bank_account_name = $dto['bank_account_name'];
        $tenant->bank_account_number = $dto['bank_account_number'];

        $this->prepareAuditActive($tenant);
        $this->prepareAuditInsert($tenant);
        $tenant->save();

        $this->results['data'] = $tenant;
        $this->results['message'] = "Tenant successfully stored";
    }

    public function prepare ($dto) {
        // if (isset($dto['area_uuid']))
        $dto['area_id'] = $this->findIdByUuid(Area::query(), $dto['area_uuid']);

        return $dto;
    }

    public function rules ($dto) {
        return [
            'area_uuid' => ['required','uuid', new ExistsUuid('areas')],
            'name' => ['required', new UniqueData('tenants','name')],
            'email' => ['required', 'email', new UniqueData('tenants','email')],
            'phone_number' => ['required', 'numeric', new UniqueData('tenants','phone_number')],
            'bank_account_name' => ['required'],
            'bank_account_number' => ['required'],
        ];
    }

}
