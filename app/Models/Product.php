<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, Uuids;

    protected $guarded = [];

    public function categories()
    {
        return $this->belongsTo(ProductCategory::class);
    }


    public function users()
    {
        return $this->belongsTo(User::class);
    }


    public function order()
    {
        return $this->hasMany(Order::class);
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }
}
