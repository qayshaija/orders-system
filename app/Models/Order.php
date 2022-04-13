<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model {

  protected $fillable
    = [
      'full_name',
      'full_name',
      'phone1',
      'phone2',
      'address',
      'amount',
      'source',
      'comments',
      'store_id',
      'report_id',
      'status',
    ];

  public function orderItems(): HasMany {
    return $this->hasMany(OrderItem::class);
  }

}
