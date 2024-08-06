<?php
namespace App\Services\ItemCategoryService;

use App\Models\ItemCategory;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class DeleteItemCategory extends DefaultService implements ServiceInterface {

    public function process ($dto) {
        $dto = $this->prepare($dto);

        $item_category = ItemCategory::find($dto['item_category_id']);

        $this->results['message'] = "Item Category successfully deleted";
        $this->results['data'] = $this->activeAndRemoveData($item_category, $dto);
    }

    public function prepare ($dto) {
        $dto['item_category_id'] = $this->findIdByUuid(ItemCategory::query(), $dto['item_category_uuid']);
        return $dto;
    }

    public function rules ($dto) {
        return [
            'item_category_uuid' => ['required', 'uuid', new ExistsUuid('item_categories')]
        ];
    }

}
