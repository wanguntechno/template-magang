<?php
namespace App\Services\StockLedgerService;

use App\Models\StockLedger;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class DeleteStockLedger extends DefaultService implements ServiceInterface {

    public function process ($dto) {
        $dto = $this->prepare($dto);

        $stock_ledger = StockLedger::find($dto['stock_ledger_id']);

        $this->results['message'] = "Stock Ledger successfully deleted";
        $this->results['data'] = $this->activeAndRemoveData($stock_ledger, $dto);
    }

    public function prepare ($dto) {
        $dto['stock_ledger_id'] = $this->findIdByUuid(StockLedger::query(), $dto['stock_ledger_uuid']);
        return $dto;
    }

    public function rules ($dto) {
        return [
            'stock_ledger_uuid' => ['required', 'uuid', new ExistsUuid('stock_ledgers')]
        ];
    }

}
