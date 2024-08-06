<?php
namespace App\Services\SellingGoodService;

use App\Models\FileStorage;
use App\Models\ItemCategory;
use App\Models\SellingGood;
use App\Models\Tenant;
use App\Rules\ExistsUuid;
use App\Rules\UniqueData;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class StoreSellingGood extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $selling_good = new SellingGood;

        $selling_good->item_category_id = $dto['item_category_id'];
        $selling_good->tenant_id = $dto['tenant_id'];
        $selling_good->photo_id = $dto['file_storage_id'];

        $selling_good->name = $dto['name'];
        $selling_good->code = $dto['code'] ?? null;
        $selling_good->price = $dto['price'];
        $selling_good->available_stock = $dto['available_stock'];
        $selling_good->description = $dto['description'] ?? null;

        $this->prepareAuditActive($selling_good);
        $this->prepareAuditInsert($selling_good);
        $selling_good->save();

        $this->results['data'] = $selling_good;
        $this->results['message'] = "Selling Good successfully stored";
    }

    public function prepare ($dto) {
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
