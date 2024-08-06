<?php
namespace App\Services\AdminService;

use App\Models\Admin;
use App\Models\User;
use App\Rules\ExistsUuid;
use App\Rules\UniqueData;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class StoreAdmin extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $admin = new Admin;

        $admin->user_id = $dto['user_id'];
        $admin->name = $dto['name'];
        $admin->phone_number = $dto['phone_number'];
        $admin->address = $dto['address'] ?? null;
        $admin->employee_number = $dto['employee_number'];

        $this->prepareAuditActive($admin);
        $this->prepareAuditInsert($admin);
        $admin->save();

        $this->results['data'] = $admin;
        $this->results['message'] = "Admin successfully stored";
    }

    public function prepare ($dto) {
        if (isset($dto['user_uuid']))
        $dto['user_id'] = $this->findIdByUuid(User::query(), $dto['user_uuid']);

        return $dto;
    }

    public function rules ($dto) {
        return [
            'user_uuid' => ['required', 'uuid', new ExistsUuid('users')],
            'name' => ['required'],
            'phone_number' => ['required', 'numeric', new UniqueData('admins','phone_number')],
            'adddress' => ['nullable'],
            'employee_number' => ['required', new UniqueData('admins','employee_number')]
        ];
    }

}
