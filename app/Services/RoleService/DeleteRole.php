<?php
namespace App\Services\RoleService;

use App\Models\Role;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class DeleteRole extends DefaultService implements ServiceInterface {

    public function process ($dto) {
        $dto = $this->prepare($dto);

        $role = Role::find($dto['role_id']);

        $this->results['message'] = "Role successfully deleted";
        $this->results['data'] = $this->activeAndRemoveData($role, $dto);
    }

    public function prepare ($dto) {
        $dto['role_id'] = $this->findIdByUuid(Role::query(), $dto['role_uuid']);
        return $dto;
    }

    public function rules ($dto) {
        return [
            'role_uuid' => ['required', 'uuid', new ExistsUuid('roles')]
        ];
    }

}
