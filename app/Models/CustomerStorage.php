<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerStorage extends Model
{
    protected $table = 'customerstorage';
    protected $primaryKey = 'id';

    protected $fillable = [
        'account',
        'layaway_id',
        'customername',
        'sellingprice',
        'downpayment',
        'balance',
        'status'
        
    ];

    public function layaway() {
        return $this->belongsTo(CustomerLayawayInfo::class, 'layaway_id');
    }
    use HasFactory;
}
