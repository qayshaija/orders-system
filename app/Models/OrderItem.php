<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model {


  public $timestamps = FALSE;

  protected $fillable = ['product_title', 'product_price', 'is_primary', 'index'];

}
