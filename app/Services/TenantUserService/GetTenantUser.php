<?php
namespace App\Services\TenantUserService;

use App\Models\Tenant;
use App\Models\TenantUser;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class GetTenantUser extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto['per_page'] = $dto['per_page'] ?? 10;
        $dto['page'] = $dto['page'] ?? 1;

        $model = TenantUser::where('deleted_at',null)->with('tenant');

        if (isset($dto['search_param']) and $dto['search_param'] != null) {
            $model->where(function ($q) use ($dto) {
                $q->where('name', 'ILIKE', '%' . $dto['search_param'] . '%')
                    ->orwhere('name', 'ILIKE', '%' . $dto['search_param'] . '%')
                    ->orwhere('employee_number', 'ILIKE', '%' . $dto['search_param'] . '%')
                    ->orwhere('phone_number', 'ILIKE', '%' . $dto['search_param'] . '%')
                    ->orwhere('address', 'ILIKE', '%' . $dto['search_param'] . '%');
            });
        }

        if (isset($dto['tenant_uuid']) and $dto['tenant_uuid'] != '') {
            $tenant_id = $this->findIdByUuid(Tenant::query(), $dto['tenant_uuid']);
            $model->where('tenant_id', $tenant_id);
        }

        if (isset($dto['tenant_user_uuid']) and $dto['tenant_user_uuid'] != '') {
            $model->where('uuid', $dto['tenant_user_uuid']);
            $data = $model->first();
        } else {
            if (isset($dto['with_pagination'])) {
                $this->results['pagination'] = $this->paginationDetail($dto['per_page'], $dto['page'], $model->count());
                $model = $this->paginateData($model, $dto['per_page'], $dto['page']);
            }
            $data = $model->get();
        }

        $this->results['message'] = "Tenant User successfully fetched";
        $this->results['data'] = $data;
    }

}
