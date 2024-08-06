<?php

namespace App\Services\UserService;

use App\Models\Role;
use App\Models\User;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class GetUser extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto['per_page'] = $dto['per_page'] ?? 10;
        $dto['page'] = $dto['page'] ?? 1;

        $model = User::where('deleted_at',null)
        ->with('userRole.role');

        if (isset($dto['search_param']) and $dto['search_param'] != null) {
            $model->where(function ($q) use ($dto) {
                $q->where('username','ILIKE','%'.$dto['search_param'].'%');
            });
        }

        if (isset($dto['role_id_not_in'])) {
            $model->whereHas('userRole', function ($q) use ($dto) {
                $q->whereNotIn('role_id',$dto['role_id_not_in']);
            });
        }

        if (isset($dto['role_id_in'])) {
            $model->whereHas('userRole', function ($q) use ($dto) {
                $q->whereIn('role_id',$dto['role_id_in']);
            });
        }

        if (isset($dto['role_uuid']) and $dto['search_param'] != null) {
            $model->whereHas('userRole', function ($q) use ($dto) {
                $role_id = $this->findIdByUuid(Role::query(), $dto['role_uuid']);
                $q->where('role_id', $role_id);
            });
        }

        if (isset($dto['user_uuid']) and $dto['user_uuid'] != '') {
            $model->where('uuid', $dto['user_uuid']);
            $data = $model->first();
        } else {

            if (isset($dto['with_pagination'])) {
                $this->results['pagination'] = $this->paginationDetail($dto['per_page'], $dto['page'], $model->count());
                $model = $this->paginateData($model, $dto['per_page'], $dto['page']);
            }

            $data = $model->get();
        }


        $this->results['message'] = "User successfully fetched";
        $this->results['data'] = $data;
    }

    public function rules ($dto) {
        return [
            'user_uuid' => ['nullable', 'uuid', new ExistsUuid('users')]
        ];
    }

}
