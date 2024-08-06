<?php
namespace App\Services\RoleService;

use App\Models\Role;
use App\Rules\UniqueData;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class StoreRole extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $role = new Role;

        $role->name = $dto['name'];
        $role->code = $dto['code'] ?? null;
        $role->description = $dto['description'] ?? null;

        $this->prepareAuditActive($role);
        $this->prepareAuditInsert($role);
        $role->save();

        $this->results['data'] = $role;
        $this->results['message'] = "Role successfully stored";
    }

    public function prepare ($dto) {

        return $dto;
    }

    public function rules ($dto) {
        return [
            'name' => ['required', new UniqueData('roles','name')],
            'code' => ['nullable', new UniqueData('roles','code')],
            'description' => ['nullable']
        ];
    }

}
