<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = 'sales';
    protected $primarykey = 'id';
    protected $fillable =[
        'total','pay','balance',
    ];
    public function salesDetails(){
        return $this->hasMany(SalesDetails::class,'sales_id');
    }
    use HasFactory;
}
