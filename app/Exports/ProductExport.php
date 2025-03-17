<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all([
            'productcode',
            'supplier_id',
            'gold_type',
            'productname',
            'quantity',
            'cost_per_gram',
            'price_per_gram',
            'grams',
            'cost',
            'price',
        ]);
    }
    public function headings(): array
    {
        return [
            '#',
            'Product Code',
            'Supplier',
            'Gold Type',
            'Product Name',
            'Quantity',
            'Cost Per Gram',
            'Price Per Gram',
            'Grams',
            'Cost Price',
            'Selling Price',
        ];
    }
}
