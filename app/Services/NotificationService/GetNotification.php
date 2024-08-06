<?php
namespace App\Services\NotificationService;

use App\Models\Notification;
use App\Models\User;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class GetNotification extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto['per_page'] = $dto['per_page'] ?? 10;
        $dto['page'] = $dto['page'] ?? 1;
        $dto['sort_by'] = $dto['sort_by'] ?? 'created_at';
        $dto['sort_type'] = $dto['sort_type'] ?? 'desc';

        $model = Notification::where('deleted_at',null)->with('user');
        $model->orderBy($dto['sort_by'],$dto['sort_type']);
        if (isset($dto['user_uuid'])) {
            $user_id = $this->findIdByUuid(User::query(), $dto['user_uuid']);
            $model->where('users_id', $user_id);
        }

        if (isset($dto['is_read'])) {
            $model->where('is_read', $dto['is_read']);
        }

        if (isset($dto['notification_uuid']) and $dto['notification_uuid'] != '') {
            $model->where('uuid', $dto['notification_uuid']);
            $data = $model->first();
        } else {
            if (isset($dto['with_pagination'])) {
                $this->results['pagination'] = $this->paginationDetail($dto['per_page'], $dto['page'], $model->count());
                $model = $this->paginateData($model, $dto['per_page'], $dto['page']);
            }
            $data = $model->get();
        }

        $this->results['message'] = "Notification successfully fetched";
        $this->results['data'] = $data;
    }

    public function rules ($dto) {
        return [
            'notification_uuid' => ['nullable', 'uuid', new ExistsUuid('notifications')]
        ];
    }

}
