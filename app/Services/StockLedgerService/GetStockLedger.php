<?php
namespace App\Services\StockLedgerService;

use App\Models\StockLedger;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class GetStockLedger extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto['per_page'] = $dto['per_page'] ?? 10;
        $dto['page'] = $dto['page'] ?? 1;

        $model = StockLedger::where('deleted_at',null);

        if (isset($dto['stock_ledger_uuid']) and $dto['stock_ledger_uuid'] != '') {
            $model->where('uuid', $dto['stock_ledger_uuid']);
            $data = $model->first();
        } else {
            if (isset($dto['with_pagination'])) {
                $this->results['pagination'] = $this->paginationDetail($dto['per_page'], $dto['page'], $model->count());
                $model = $this->paginateData($model, $dto['per_page'], $dto['page']);
            }
            $data = $model->get();
        }

        $this->results['message'] = "Stock Ledger successfully fetched";
        $this->results['data'] = $data;
    }

}
