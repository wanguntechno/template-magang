<?php
namespace App\Services\EndpointLogService;

use App\Models\EndpointLog;
use App\Models\User;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class StoreEndpointLog extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $log = new EndpointLog;

        $log->user_id = $dto['user_id'] ?? null;
        $log->ip_address = $dto['ip_address'];
        $log->endpoint = $dto['endpoint'];
        $log->datetime = $dto['datetime'];

        $this->prepareAuditActive($log);
        $this->prepareAuditInsert($log);
        $log->save();

        $this->results['data'] = $log;
        $this->results['message'] = "Endpoint Log successfully stored";
    }

    public function prepare ($dto) {
        if (isset($dto['user_uuid']))
        $dto['user_id'] = $this->findIdByUuid(User::query(), $dto['user_uuid']);

        return $dto;
    }

    public function rules ($dto) {
        return [
            'user_uuid' => ['required', 'uuid', new ExistsUuid('users')],
            'ip_address' => ['required'],
            'endpoint' => ['required'],
            'datetime' => ['required'],
        ];
    }

}
