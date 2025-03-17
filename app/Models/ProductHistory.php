<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHistory extends Model
{
    protected $table = 'producthistory';
    protected $primaryKey = 'id';
    protected $fillable = [
        'product_id',
        'supplier_id',
        'gold_type',
        'productcode',
        'productname',
        'quantity',
        'cost_per_gram',
        'price_per_gram',
        'grams',
        'cost',
        'price',
    ];
    use HasFactory;

    public function Supplier(){
        return $this->belongsTo(supplier::class,'supplier_id');
    }
}
