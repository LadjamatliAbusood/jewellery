<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $fillable = [
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

    public function Supplier(){
        return $this->belongsTo(supplier::class,'supplier_id');
    }

    public function Gold(){
        return $this->belongsTo(GoldModel::class,'gold_type','gold_type');
    }

    public function salesDetails()
    {
        return $this->hasMany(SalesDetails::class, 'productcode', 'productcode');
    }
    public function productHistory()
    {
        return $this->hasMany(ProductHistory::class);
    }
    use HasFactory;
}
