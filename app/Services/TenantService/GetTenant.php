<?php
namespace App\Services\TenantService;

use App\Models\Area;
use App\Models\Tenant;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class GetTenant extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto['per_page'] = $dto['per_page'] ?? 10;
        $dto['page'] = $dto['page'] ?? 1;

        $model = Tenant::where('deleted_at',null)->with('area');

        if (isset($dto['search_param']) and $dto['search_param'] != null) {
            $model->where(function ($q) use ($dto) {
                $q->where('name', 'ILIKE', '%' . $dto['search_param'] . '%')
                    ->orwhere('email', 'ILIKE', '%' . $dto['search_param'] . '%')
                    ->orwhere('phone_number', 'ILIKE', '%' . $dto['search_param'] . '%')
                    ->orwhere('bank_account_name', 'ILIKE', '%' . $dto['search_param'] . '%')
                    ->orwhere('bank_account_number', 'ILIKE', '%' . $dto['search_param'] . '%');
            });
        }

        if (isset($dto['area_uuid']) and $dto['area_uuid'] != '') {
            $area_id = $this->findIdByUuid(Area::query(), $dto['area_uuid']);
            $model->where('area_id', $area_id);
        }

        if (isset($dto['tenant_uuid']) and $dto['tenant_uuid'] != '') {
            $model->where('uuid', $dto['tenant_uuid']);
            $data = $model->first();
        } else {
            if (isset($dto['with_pagination'])) {
                $this->results['pagination'] = $this->paginationDetail($dto['per_page'], $dto['page'], $model->count());
                $model = $this->paginateData($model, $dto['per_page'], $dto['page']);
            }
            $data = $model->get();
        }

        $this->results['message'] = "Tenant successfully fetched";
        $this->results['data'] = $data;
    }

}
