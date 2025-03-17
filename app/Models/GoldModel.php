<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoldModel extends Model
{
    protected $table = 'gold';
    protected $primarykey = 'id';
    protected $fillable = [
        'gold_type',
        'gold_cost',
        'gold_price',
        'status'
    ];

    public function products(){
        return $this->hasMany(Product::class,'gold_type','gold_type');
    }
    use HasFactory;
}
