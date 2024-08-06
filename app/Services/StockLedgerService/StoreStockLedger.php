<?php
namespace App\Services\StockLedgerService;

use App\Models\SellingGood;
use App\Models\StockLedger;
use App\Rules\ExistsUuid;
use App\Rules\UniqueData;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class StoreStockLedger extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $stock_ledger = new StockLedger;

        $stock_ledger->selling_good_id = $dto['selling_good_id'];
        $stock_ledger->reference = $dto['reference'];
        $stock_ledger->reference_id = $dto['reference_id'];
        $stock_ledger->stock_before = $dto['stock_before'];
        $stock_ledger->amount = $dto['amount'];
        $stock_ledger->stock_after = $dto['stock_after'];
        $stock_ledger->date = $dto['date'];

        $this->prepareAuditActive($stock_ledger);
        $this->prepareAuditInsert($stock_ledger);
        $stock_ledger->save();

        $this->results['data'] = $stock_ledger;
        $this->results['message'] = "Stock Ledger successfully stored";
    }

    public function prepare ($dto) {
        if (isset($edto['selling_good_id']))
        $dto['selling_good_id'] = $this->findIdByUuid(SellingGood::query(), $dto['selling_good_id']);

        return $dto;
    }

    public function rules ($dto) {
        return [
            'selling_good_uuid' => ['required','uuid', new ExistsUuid('selling_goods')],
            'reference' => ['required'],
            'reference_id' => ['required', 'numeric'],
            'stock_before' => ['required', 'numeric'],
            'amount' => ['required'],
            'stock_after' => ['required', 'numeric'],
            'date' => ['required', 'date'],
        ];
    }

}
