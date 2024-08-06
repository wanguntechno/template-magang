<?php

namespace App\Services\AuthService;

use App\Services\DefaultService;
use App\Services\ServiceInterface;
use App\Exceptions\CustomException;
use App\Models\User;


class DoLogout extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        if (auth()->check()) {
          
        } else {
            throw new CustomException('Unauthorized request', 401);
        }
    }
}
