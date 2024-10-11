<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $table = 'sale';

    protected $fillable = [
        'customer_id',
        'bill_no',
        'bill_date',
        'gst_no',
        'place',
        'state_code',
        'transport_no',
        'transport_gst_tin_no',
        'parcel',
        'grand_total'
    ];

    public function customer()
    {
        return $this->belongsTo(Customers::class, 'customer_name');
    }

    public function items()
    {
        return $this->hasMany(Sales_Items::class, 'sale_id');
    }

}
