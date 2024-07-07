<?php

namespace App\Helpers;

use App\Models\Product;

class ProductHelper
{
    public static function getLowStockProducts($threshold = 10)
    {
        return Product::where('stock', '<', $threshold)->get();
    }
}
