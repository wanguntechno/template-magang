<?php
namespace App\Services\AreaService;

use App\Services\DefaultService;
use App\Services\ServiceInterface;
use App\Models\Area;
use App\Rules\ExistsUuid;
use App\Rules\UniqueData;

class UpdateArea extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto = $this->prepare($dto);
        $area = Area::find($dto['area_id']);

        $area->name = $dto['name'] ?? $area->name;
        $area->code = $dto['code'] ?? $area->code;
        $area->description = $dto['description'] ?? $area->description;

        $this->prepareAuditUpdate($area);
        $area->save();

        $this->results['data'] = $area;
        $this->results['message'] = "Area successfully updated";
    }

    public function prepare ($dto) {
        $dto['area_id'] = $this->findIdByUuid(Area::query(), $dto['area_uuid']);
        return $dto;
    }

    public function rules ($dto) {
        return [
            'area_uuid' => ['required','uuid', new ExistsUuid('areas')],
            'name' => ['required', new UniqueData('areas','name',$dto['area_uuid'])],
            'code' => ['nullable', new UniqueData('areas','code',$dto['area_uuid'])],
            'description' => ['nullable']
        ];
    }

}
