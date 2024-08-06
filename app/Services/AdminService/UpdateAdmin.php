<?php
namespace App\Services\AdminService;

use App\Services\DefaultService;
use App\Services\ServiceInterface;
use App\Models\Admin;
use App\Models\User;
use App\Rules\ExistsUuid;
use App\Rules\UniqueData;

class UpdateAdmin extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto = $this->prepare($dto);
        $admin = Admin::find($dto['area_id']);

        $admin->user_id = $dto['user_id'] ?? $admin->user_id;
        $admin->name = $dto['name'] ?? $admin->name;
        $admin->phone_number = $dto['phone_number'] ?? $admin->phone_number;
        $admin->address = $dto['address'] ?? $admin->address;
        $admin->employee_number = $dto['employee_number'] ?? $admin->employee_number;

        $this->prepareAuditUpdate($admin);
        $admin->save();

        $this->results['data'] = $admin;
        $this->results['message'] = "Admin successfully updated";
    }

    public function prepare ($dto) {
        if (isset($dto['area_uuid']))
        $dto['area_id'] = $this->findIdByUuid(Admin::query(), $dto['area_uuid']);

        if (isset($dto['user_uuid']))
        $dto['user_id'] = $this->findIdByUuid(User::query(), $dto['user_uuid']);

        return $dto;
    }

    public function rules ($dto) {
        return [
            'admin_uuid' => ['required', 'uuid', new ExistsUuid('admins')],
            'user_uuid' => ['required', 'uuid', new ExistsUuid('users')],
            'name' => ['required'],
            'phone_number' => ['required', 'numeric', new UniqueData('admins','phone_number')],
            'adddress' => ['nullable'],
            'employee_number' => ['required', new UniqueData('admins','employee_number')]
        ];
    }

}
