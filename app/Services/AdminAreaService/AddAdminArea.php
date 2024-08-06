<?php
namespace App\Services\AdminAreaService;

use App\Models\Area;
use App\Models\Admin;
use App\Models\AdminArea;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class AddAdminArea extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto = $this->prepare($dto);

        AdminArea::insert([
            'admin_id' => $dto['admin_id'],
            'area_id' => $dto['area_id']
        ]);

        $this->results['data'] = [];
        $this->results['message'] = "Admin successfully added to area";
    }

    public function prepare ($dto) {
        $dto['admin_id'] = $this->findIdByUuid(Admin::query(), $dto['admin_uuid']);
        $dto['area_id'] = $this->findIdByUuid(Area::query(), $dto['area_uuid']);
        return $dto;
    }

    public function rules ($dto) {
        return [
            'admin_uuid' => ['required','uuid', new ExistsUuid('admins')],
            'area_uuid' => ['required','uuid', new ExistsUuid('areas')],
        ];
    }

}
