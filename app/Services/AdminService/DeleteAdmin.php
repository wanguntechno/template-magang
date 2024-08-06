<?php
namespace App\Services\AdminService;

use App\Models\Admin;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class DeleteAdmin extends DefaultService implements ServiceInterface {

    public function process ($dto) {
        $dto = $this->prepare($dto);

        $admin = Admin::find($dto['admin_id']);

        $this->results['message'] = "Admin successfully deleted";
        $this->results['data'] = $this->activeAndRemoveData($admin, $dto);
    }

    public function prepare ($dto) {
        $dto['admin_id'] = $this->findIdByUuid(Admin::query(), $dto['admin_uuid']);
        return $dto;
    }

    public function rules ($dto) {
        return [
            'admin_uuid' => ['required', 'uuid', new ExistsUuid('admins')]
        ];
    }

}
