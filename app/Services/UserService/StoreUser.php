<?php
namespace App\Services\UserService;

use App\Models\User;
use App\Rules\ExistsUuid;
use App\Rules\UniqueData;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class StoreUser extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $user = new User;
        $user->username = $dto['username'];
        $user->password = $dto['password'];

        $this->prepareAuditActive($user);
        $this->prepareAuditInsert($user);
        $user->save();

        app('AddUserRole')->execute([
            'user_uuid' => $user->uuid,
            'role_uuid' => $dto['role_uuid']
        ], true);

        $this->results['data'] = $user;
        $this->results['message'] = "User information successfully store";
    }

    public function prepare ($dto) {

        if (isset($dto['password'])) {
            $dto['password'] = bcrypt($dto['password']);
        }

        return $dto;
    }

    public function rules ($dto) {
        return [
            'role_uuid' => ['required', 'uuid' , new ExistsUuid('roles')],
            'username' => ['required', new UniqueData('users', 'username')],
            'password' => ['required', 'confirmed'],
        ];
    }

}
