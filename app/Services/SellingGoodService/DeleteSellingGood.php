<?php
namespace App\Services\SellingGoodService;

use App\Models\SellingGood;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class DeleteSellingGood extends DefaultService implements ServiceInterface {

    public function process ($dto) {
        $dto = $this->prepare($dto);

        $selling_good = SellingGood::find($dto['selling_good_id']);

        $this->results['message'] = "Selling Good successfully deleted";
        $this->results['data'] = $this->activeAndRemoveData($selling_good, $dto);
    }

    public function prepare ($dto) {
        $dto['selling_good_id'] = $this->findIdByUuid(SellingGood::query(), $dto['selling_good_uuid']);
        return $dto;
    }

    public function rules ($dto) {
        return [
            'selling_good_uuid' => ['required', 'uuid', new ExistsUuid('selling_goods')]
        ];
    }

}
