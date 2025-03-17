<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layawaycode extends Model
{
    protected $table = 'editlayawaycode';
    protected $primaryKey = 'id';

    protected $fillable = [
        'layaway_code',
        'Iseen'
    ];

    use HasFactory;
}
