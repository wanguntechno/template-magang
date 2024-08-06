<?php
namespace App\Services\StockLedgerService;

use App\Models\Area;
use App\Models\SellingGood;
use App\Services\DefaultService;
use App\Services\ServiceInterface;
use App\Models\StockLedger;
use App\Rules\ExistsUuid;
use App\Rules\UniqueData;

class UpdateStockLedger extends DefaultService implements ServiceInterface {

    public function process($dto)
    {
        $dto = $this->prepare($dto);
        $stock_ledger = StockLedger::find($dto['stock_ledger_id']);

        $stock_ledger->selling_good_id = $dto['selling_good_id'] ?? $stock_ledger->selling_good_id;
        $stock_ledger->reference = $dto['reference'] ?? $stock_ledger->reference;
        $stock_ledger->reference_id = $dto['reference_id'] ?? $stock_ledger->reference_id;
        $stock_ledger->stock_before = $dto['stock_before'] ?? $stock_ledger->stock_before;
        $stock_ledger->amount = $dto['amount'] ?? $stock_ledger->amount;
        $stock_ledger->stock_after = $dto['stock_after'] ?? $stock_ledger->stock_after;
        $stock_ledger->date = $dto['date'] ?? $stock_ledger->date;

        $this->prepareAuditUpdate($stock_ledger);
        $stock_ledger->save();

        $this->results['data'] = $stock_ledger;
        $this->results['message'] = "Stock Ledger successfully updated";
    }

    public function prepare ($dto) {
        if (isset($edto['selling_good_id']))
        $dto['selling_good_id'] = $this->findIdByUuid(SellingGood::query(), $dto['selling_good_id']);

        return $dto;
    }

    public function rules ($dto) {
        return [
            'stock_ledger_uuid' => ['required','uuid', new ExistsUuid('stock_ledgers')],
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
