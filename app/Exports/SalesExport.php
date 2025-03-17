<?php

namespace App\Exports;

use App\Models\SalesDetails;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class SalesExport implements FromCollection
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
        return DB::table('productsales as ps')
            ->join('products as p', 'ps.productcode', '=', 'p.productcode')
            ->whereBetween('ps.created_at', [$this->dateFrom, $this->dateTo])
            ->select(
                'ps.id as sales_id',
                'ps.productcode as sales_productcode',
                'ps.account',
                'p.productname',
                'p.grams',
                'ps.cost',
                'ps.price',
                'ps.qty',
                'ps.total_cost',
                'ps.net_sale'
            )
            ->get();
    }
}
