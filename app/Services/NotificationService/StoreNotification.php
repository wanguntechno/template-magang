<?php
namespace App\Services\NotificationService;

use App\Models\Notification;
use App\Models\User;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class StoreNotification extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $notification =  new Notification;

        $notification->user_id = $dto['user_id'] ?? null;
        $notification->title = $dto['title'];
        $notification->relation_key = $dto['relation_key'];
        $notification->text = $dto['text'];
        $notification->url = $dto['url'] ?? null;
        $notification->is_read = 0;
        $notification->notification_time = $dto['notification_time'];

        $this->prepareAuditActive($notification);
        $this->prepareAuditInsert($notification);
        $notification->save();

        $this->results['data'] = [];
        $this->results['message'] = "Notification successfully stored";
    }

    public function prepare ($dto) {
        $dto['user_id'] = $this->findIdByUuid(User::query(), $dto['user_uuid']);
        return $dto;
    }

    public function rules ($dto) {
        return [
            'user_uuid' => ['nullable', 'uuid', new ExistsUuid('users')],
            'relation_key' => ['required'],
            'title' => ['required'],
            'text' => ['required'],
            'url' => ['nullable'],
            'notification_time' => ['required']
        ];
    }

}
