<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales_Items extends Model
{
    use HasFactory;

    protected $table = 'sale_item';

    protected $fillable = [
        'sale_id',
        'unit',
        'quantity',
        'item_name',
        'item_detail',
        'price',
        'hsn_code',
        'tax_type',
        'tax',
        'total'
    ];
}
