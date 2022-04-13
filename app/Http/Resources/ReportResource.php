<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource {

  public function toArray($request) {
    return [
      'id'           => $this->id,
      'name'         => $this->name,
      'cashReceived' => $this->cash_received,
      'status'       => $this->status,
      'ordersCount'       => $this->orders_count,
      'comments'     => $this->comments,
    ];
  }

}
