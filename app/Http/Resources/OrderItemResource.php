<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource {

  public function toArray($request) {
    return [
      'id'        => $this->id,
      'title'     => $this->product_title,
      'price'     => $this->product_price,
      'isPrimary' => $this->is_primary,
    ];
  }

}
