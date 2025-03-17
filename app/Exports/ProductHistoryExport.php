<?php

namespace App\Exports;

use App\Models\ProductHistory;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductHistoryExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $dateFrom;
    protected $dateTo;

    public function __construct($dateFrom, $dateTo)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }
    public function collection()
    {
        return ProductHistory::whereBetween('created_at', [$this->dateFrom, $this->dateTo])
        ->select('created_at', 'productcode', 'supplier_id', 'productname', 'quantity', 'cost_per_gram', 'price_per_gram', 'grams', 'cost', 'price')
        ->get();

    }

    public function headings(): array
    {
        return ['#', 'Date', 'Product Code', 'Supplier', 'Product Name', 'Quantity', 'Cost Per Gram', 'Price Per Gram', 'Grams', 'Cost Price', 'Selling Price'];
    }
}
