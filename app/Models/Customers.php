<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'customer_name',
        'gst_no	',
        'place	',
        'state_code',
        'transport_no',
        'transport_gst_tin_no',
        'parcel',
    ];

    public function sales()
    {
        return $this->hasMany(Sales::class, 'customer_id');
    }

}
