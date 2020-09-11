<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $attributes = ['price_unit'];
    public function getPriceUnitAttribute(){
    	return $this->price.' '.$this->currency;
    }
}
