<?php
namespace App\Services\EndpointLogService;

use App\Models\EndpointLog;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class GetEndpointLog extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto['per_page'] = $dto['per_page'] ?? 10;
        $dto['page'] = $dto['page'] ?? 1;

        $model = EndpointLog::where('deleted_at',null);

        if (isset($dto['endpoint_log_uuid']) and $dto['endpoint_log_uuid'] != '') {
            $model->where('uuid', $dto['endpoint_log_uuid']);
            $data = $model->first();
        } else {
            if (isset($dto['with_pagination'])) {
                $this->results['pagination'] = $this->paginationDetail($dto['per_page'], $dto['page'], $model->count());
                $model = $this->paginateData($model, $dto['per_page'], $dto['page']);
            }
            $data = $model->get();
        }

        $this->results['message'] = "Endpoint Log successfully fetched";
        $this->results['data'] = $data;
    }

}
