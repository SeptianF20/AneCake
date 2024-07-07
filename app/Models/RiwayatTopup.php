<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatTopup extends Model
{
    use HasFactory, Uuids;

    protected $fillable = ['order_id','transaction_status','gross_amount', 'payment_type', ];

    protected $table = 'riwayattopup';
}
