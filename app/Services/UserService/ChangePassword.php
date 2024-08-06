<?php
namespace App\Services\UserService;

use App\Models\User;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class ChangePassword extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto = $this->prepare($dto);
        
        $new_password = $dto['new_password'];
        $user = User::find($dto['user_id']);

        $user->password = bcrypt($new_password);
        $user->save();

        $this->results['data'] = [];
        $this->results['message'] = "Password change successful";
    }

    public function prepare ($dto) {
        $dto['user_id'] = $this->findIdByUuid(User::query(), $dto['user_uuid']);

        return $dto;
    }

    public function rules ($dto) {
        return [
            'user_uuid' => ['required', 'uuid', new ExistsUuid('users')],
            'new_password' => ['required', 'min:6', 'confirmed']
        ];
    }

}
