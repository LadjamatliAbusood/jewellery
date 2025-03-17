<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customerpayment extends Model
{
    protected $table = 'customerpayment';
    protected $primaryKey = 'id';
    protected $fillable = [
        'layaway_id',
        'amount',
        'balance'
      

    ];

    public function layaway() {
        return $this->belongsTo(CustomerLayawayInfo::class, 'layaway_id');
    }
    use HasFactory;
}
