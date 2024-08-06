<?php
namespace App\Services\AreaService;

use App\Models\Area;
use App\Rules\UniqueData;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class StoreArea extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $area = new Area;

        $area->name = $dto['name'];
        $area->code = $dto['code'] ?? null;
        $area->description = $dto['description'] ?? null;

        $this->prepareAuditActive($area);
        $this->prepareAuditInsert($area);
        $area->save();

        $this->results['data'] = $area;
        $this->results['message'] = "Area successfully stored";
    }

    public function prepare ($dto) {

        return $dto;
    }

    public function rules ($dto) {
        return [
            'name' => ['required', new UniqueData('areas','name')],
            'code' => ['nullable', new UniqueData('areas','code')],
            'description' => ['nullable']
        ];
    }

}
