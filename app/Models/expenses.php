<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class expenses extends Model
{
    protected $table = 'expenses';
    protected $primaryKey = 'id';

    protected $fillable = [
        'account',
        'description',
        'total_expenses',
        
    ];
    use HasFactory;
}
