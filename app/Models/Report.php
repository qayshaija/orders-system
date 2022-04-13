<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model {

  protected $fillable = ['name', 'status', 'cash_received', 'comments'];

  public function orders(): HasMany {
    return $this->hasMany(Order::class);
  }

}
