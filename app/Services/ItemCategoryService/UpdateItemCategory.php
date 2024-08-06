<?php
namespace App\Services\ItemCategoryService;

use App\Services\DefaultService;
use App\Services\ServiceInterface;
use App\Models\ItemCategory;
use App\Rules\ExistsUuid;
use App\Rules\UniqueData;

class UpdateItemCategory extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto = $this->prepare($dto);
        $item_category = ItemCategory::find($dto['item_category_id']);

        $item_category->name = $dto['name'] ?? $item_category->name;
        $item_category->code = $dto['code'] ?? $item_category->code;
        $item_category->description = $dto['description'] ?? $item_category->description;

        $this->prepareAuditUpdate($item_category);
        $item_category->save();

        $this->results['data'] = $item_category;
        $this->results['message'] = "Item Category successfully updated";
    }

    public function prepare ($dto) {
        $dto['item_category_id'] = $this->findIdByUuid(ItemCategory::query(), $dto['item_category_uuid']);
        return $dto;
    }

    public function rules ($dto) {
        return [
            'item_category_uuid' => ['required','uuid', new ExistsUuid('item_categories')],
            'name' => ['required', new UniqueData('item_categories','name',$dto['item_category_uuid'])],
            'code' => ['nullable', new UniqueData('item_categories','code',$dto['item_category_uuid'])],
            'description' => ['nullable']
        ];
    }

}
