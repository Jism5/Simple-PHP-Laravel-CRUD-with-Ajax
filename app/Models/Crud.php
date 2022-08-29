<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crud extends Model
{
    use HasFactory;
    protected $table = 'cruds';
    protected $fillable = [
        'Product_name',
        'Product_brand',
        'Product_price',
        'Product_stock'
    ];
}
