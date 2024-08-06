<?php
namespace App\Services\SellingGoodService;

use App\Models\Area;
use App\Models\FileStorage;
use App\Models\ItemCategory;
use App\Services\DefaultService;
use App\Services\ServiceInterface;
use App\Models\SellingGood;
use App\Models\Tenant;
use App\Rules\ExistsUuid;
use App\Rules\UniqueData;

class UpdateSellingGood extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto = $this->prepare($dto);
        $selling_good = SellingGood::find($dto['selling_good_id']);

        $selling_good->item_category_id = $dto['item_category_id'] ?? $selling_good->item_category_id;
        $selling_good->tenant_id = $dto['tenant_id'] ?? $selling_good->tenant_id;
        $selling_good->photo_id = $dto['file_storage_id'] ?? $selling_good->photo_id;

        $selling_good->name = $dto['name'] ?? $selling_good->name;
        $selling_good->code = $dto['code'] ?? $selling_good->code;
        $selling_good->price = $dto['price'] ?? $selling_good->price;
        $selling_good->available_stock = $dto['available_stock'] ?? $selling_good->available_stock;
        $selling_good->description = $dto['description'] ?? $selling_good->description;

        $this->prepareAuditUpdate($selling_good);
        $selling_good->save();

        $this->results['data'] = $selling_good;
        $this->results['message'] = "Selling Good successfully updated";
    }

    public function prepare ($dto) {
        if (isset($edto['selling_good_uuid']))
        $dto['selling_good_id'] = $this->findIdByUuid(SellingGood::query(), $dto['selling_good_uuid']);

        if (isset($edto['item_category_uuid']))
        $dto['item_category_id'] = $this->findIdByUuid(ItemCategory::query(), $dto['item_category_uuid']);

        if (isset($edto['tenant_uuid']))
        $dto['tenant_id'] = $this->findIdByUuid(Tenant::query(), $dto['tenant_uuid']);

        if (isset($edto['file_storage_uuid']))
        $dto['file_storage_id'] = $this->findIdByUuid(FileStorage::query(), $dto['file_storage_uuid']);

        return $dto;
    }

    public function rules ($dto) {
        return [
            'selling_good_uuid' => ['required','uuid', new ExistsUuid('selling_goods')],
            'item_category_uuid' => ['required','uuid', new ExistsUuid('item_categories')],
            'tenant_uuid' => ['required','uuid', new ExistsUuid('tenants')],
            'file_storage_uuid' => ['required','uuid', new ExistsUuid('file_storages')],

            'name' => ['required', new UniqueData('selling_goods','name')],
            'code' => ['nullable'],
            'price' => ['required', 'numeric'],
            'available_stock' => ['required','numeric'],
            'description' => ['nullable'],
        ];
    }

}
