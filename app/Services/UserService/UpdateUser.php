<?php
namespace App\Services\UserService;

use App\Models\User;
use App\Rules\ExistsUuid;
use App\Rules\UniqueData;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class UpdateUser extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto = $this->prepare($dto);
        $user = User::find($dto['user_id']);

        $user->username = $dto['username'] ?? $user->username;
        $user->password = $dto['password'] ?? $user->password;

        if (isset($dto['role_uuid'])) {
            app('RemoveUserRole')->execute([
                'user_uuid' => $user->uuid,
                'role_uuid' => $user->userRole->role->uuid
            ], true);
            app('AddUserRole')->execute([
                'user_uuid' => $user->uuid,
                'role_uuid' => $dto['role_uuid']
            ], true);
        }

        $this->prepareAuditUpdate($user);
        $user->save();

        $this->results['data'] = $user;
        $this->results['message'] = "User information successfully updated";
    }

    public function prepare ($dto) {
        $dto['user_id'] = $this->findIdByUuid(User::query(), $dto['user_uuid']);

        if (isset($dto['password'])) {
            $dto['password'] = bcrypt($dto['password']);
        }

        return $dto;
    }

    public function rules ($dto) {
        return [
            'user_uuid' => ['required', 'uuid', new ExistsUuid('users')],
            'username' => ['nullable', new UniqueData('users', 'username', $dto['user_uuid'])],
            'role_uuid' => ['nullable','uuid', new ExistsUuid('roles')],
            'password' => ['nullable', 'confirmed'],
        ];
    }

}
