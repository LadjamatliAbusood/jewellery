<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerLayawayInfo extends Model
{
    protected $table = 'customer_layaway_info';
    protected $primaryKey = 'id';

    protected $fillable = [
        'customer_number',
        'fullname',
        'customer_cn',
        'layaway_info',
        'sellingprice',
        'downpayment',
        'plan',
        'description'

    ];

    public function storage() {
        return $this->hasOne(CustomerStorage::class, 'layaway_id');
    }
    public function customerpayments() {
        return $this->hasMany(Customerpayment::class, 'layaway_id');
    }


    use HasFactory;

}
