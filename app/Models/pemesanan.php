<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pemesanan extends Model
{
    use HasFactory, Uuids;

    protected $table = 'pemesanan';
    protected $fillable = [
        'order_id',
        'transaction_status',
        'gross_amount',
        'payment_type',
        'transaction_time',
    ];

    // public function items()
    // {
    //     return $this->hasMany(detailPemesanan::class);
    // }
}
