<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RFID extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'card_id'];
    protected $table = 'card_temporary';
}
