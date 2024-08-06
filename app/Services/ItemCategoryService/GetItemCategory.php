<?php
namespace App\Services\ItemCategoryService;

use App\Models\ItemCategory;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class GetItemCategory extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto['per_page'] = $dto['per_page'] ?? 10;
        $dto['page'] = $dto['page'] ?? 1;

        $model = ItemCategory::where('deleted_at',null);

        if (isset($dto['item_category_uuid']) and $dto['item_category_uuid'] != '') {
            $model->where('uuid', $dto['item_category_uuid']);
            $data = $model->first();
        } else {
            if (isset($dto['with_pagination'])) {
                $this->results['pagination'] = $this->paginationDetail($dto['per_page'], $dto['page'], $model->count());
                $model = $this->paginateData($model, $dto['per_page'], $dto['page']);
            }
            $data = $model->get();
        }

        $this->results['message'] = "Item Category successfully fetched";
        $this->results['data'] = $data;
    }

}