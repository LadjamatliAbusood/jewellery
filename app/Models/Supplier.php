<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';
    protected $primarykey = 'id';
    protected $fillable = [
        'supplier_fullname',
        'status'
    ];

    public function products(){
        return $this->hasMany(Product::class,'supplier_id');
    }
    public function productsHistory(){
        return $this->hasMany(Product::class,'supplier_id');
    }
    use HasFactory;
}
