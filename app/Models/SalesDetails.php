<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDetails extends Model
{
    protected $table  = 'productsales';
    protected $primarykey = 'id';
    protected $fillable =[
        'sales_id', 'account', 'productcode','productname','cost','price','qty','grams','total_cost','net_sale',
    ];

    public function sales(){
        return $this->belongsTo(Sales::class, 'sales_id');
    }
    public function product()
{
    return $this->belongsTo(Product::class, 'productcode', 'productcode');
}
    use HasFactory;
}
