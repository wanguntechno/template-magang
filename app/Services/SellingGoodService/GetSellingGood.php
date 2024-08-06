<?php
namespace App\Services\SellingGoodService;

use App\Models\SellingGood;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class GetSellingGood extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto['per_page'] = $dto['per_page'] ?? 10;
        $dto['page'] = $dto['page'] ?? 1;

        $model = SellingGood::where('deleted_at',null);

        if (isset($dto['selling_good_uuid']) and $dto['selling_good_uuid'] != '') {
            $model->where('uuid', $dto['selling_good_uuid']);
            $data = $model->first();
        } else {
            if (isset($dto['with_pagination'])) {
                $this->results['pagination'] = $this->paginationDetail($dto['per_page'], $dto['page'], $model->count());
                $model = $this->paginateData($model, $dto['per_page'], $dto['page']);
            }
            $data = $model->get();
        }

        $this->results['message'] = "Selling Good successfully fetched";
        $this->results['data'] = $data;
    }

}
