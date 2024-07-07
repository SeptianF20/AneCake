<?php

namespace App\Models;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detailPemesanan extends Model
{
    use HasFactory, Uuids;

    protected $table = 'detailPemesanan';
    protected $fillable = [
        'pemesanan_id',
        'product_id',
        'product_name',
        'quantity',
        'price',
        'total_price',
    ];

    // public function transaction()
    // {
    //     return $this->belongsTo(pemesanan::class);
    // }
}
