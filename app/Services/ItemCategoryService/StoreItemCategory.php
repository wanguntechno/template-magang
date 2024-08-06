<?php
namespace App\Services\ItemCategoryService;

use App\Models\ItemCategory;
use App\Rules\UniqueData;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class StoreItemCategory extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $item_category = new ItemCategory;

        $item_category->name = $dto['name'];
        $item_category->code = $dto['code'] ?? null;
        $item_category->description = $dto['description'] ?? null;

        $this->prepareAuditActive($item_category);
        $this->prepareAuditInsert($item_category);
        $item_category->save();

        $this->results['data'] = $item_category;
        $this->results['message'] = "Item Category successfully stored";
    }

    public function prepare ($dto) {

        return $dto;
    }

    public function rules ($dto) {
        return [
            'name' => ['required', new UniqueData('item_categories','name')],
            'code' => ['nullable', new UniqueData('item_categories','code')],
            'description' => ['nullable']
        ];
    }

}
