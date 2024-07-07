<?php

namespace App\Models;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    use HasFactory, Uuids;

    protected $fillable = ['id','member_id','card_id', 'saldo'];

    protected $table = 'saldo';

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
