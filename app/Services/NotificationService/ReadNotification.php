<?php
namespace App\Services\NotificationService;

use App\Models\Notification;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class ReadNotification extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $notification = Notification::find($dto['notification_id']);
        $notification->is_read = 1;
        $this->prepareAuditUpdate($notification);
        $notification->save();

        $this->results['data'] = $notification;
        $this->results['message'] = "Notification successfully read";
    }

    public function prepare ($dto) {
        $dto['notification_id'] = $this->findIdByUuid(Notification::query(), $dto['notification_uuid']);
       return $dto;
    }

    public function rules ($dto) {
        return [
            'notification_uuid' => ['uuid','required', new ExistsUuid('notifications')],
        ];
    }

}
