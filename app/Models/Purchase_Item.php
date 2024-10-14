<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase_Item extends Model
{
    use HasFactory;

    protected $table ='purchase_item';

    protected $fillable =[
        'purchase_id',
        'unit',
        'quantity',
        'item_name',
        'item_details',
        'cost',
        'hsn_code',
        'tax_type',
        'tax',
        'total',
    ];
}
