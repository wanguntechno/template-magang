<?php
namespace App\Services\AdminService;

use App\Models\Admin;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class GetAdmin extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto['per_page'] = $dto['per_page'] ?? 10;
        $dto['page'] = $dto['page'] ?? 1;

        $model = Admin::where('deleted_at',null);

        if (isset($dto['admin_uuid']) and $dto['admin_uuid'] != '') {
            $model->where('uuid', $dto['admin_uuid']);
            $data = $model->first();
        } else {
            if (isset($dto['with_pagination'])) {
                $this->results['pagination'] = $this->paginationDetail($dto['per_page'], $dto['page'], $model->count());
                $model = $this->paginateData($model, $dto['per_page'], $dto['page']);
            }
            $data = $model->get();
        }

        $this->results['message'] = "Admin successfully fetched";
        $this->results['data'] = $data;
    }

}
