<?php
namespace App\Services\AreaService;

use App\Models\Area;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class DeleteArea extends DefaultService implements ServiceInterface {

    public function process ($dto) {
        $dto = $this->prepare($dto);

        $area = Area::find($dto['area_id']);

        $this->results['message'] = "Area successfully deleted";
        $this->results['data'] = $this->activeAndRemoveData($area, $dto);
    }

    public function prepare ($dto) {
        $dto['area_id'] = $this->findIdByUuid(Area::query(), $dto['area_uuid']);
        return $dto;
    }

    public function rules ($dto) {
        return [
            'area_uuid' => ['required', 'uuid', new ExistsUuid('areas')]
        ];
    }

}
