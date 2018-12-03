<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['sku', 'title', 'price', 'description', 'availability', 'color', 'diminsions'];
}
