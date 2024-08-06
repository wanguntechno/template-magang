<?php
namespace App\Services\AuthService;

use App\Exceptions\CustomException;
use App\Models\FileStorage;
use App\Models\User;
use App\Services\DefaultService;
use App\Services\ServiceInterface;
use Illuminate\Support\Facades\Auth;

class DoLogin extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        if (!Auth::attempt(['username' => $dto['username'], 'password' => $dto['password'], 'is_active' => true, 'deleted_at' => null])) {
            throw new CustomException('Credential not found');
        }
        $user = User::find(auth()->id());

        $this->results['data'] = [
            'user' => [
                'user_uuid' => $user->uuid,
                'user_name' => $user->name,
                'role_uuid' => $user->userRole->role->uuid,
                'role_name' => $user->userRole->role->name,
            ],
            'token' => $user->createToken('MyApp')->accessToken
        ];
        $this->results['message'] = "User successfully logged in";

    }

    public function rules ($dto) {
        return [
            'username' => ['required'],
            'password' => ['required']
        ];
    }

}
