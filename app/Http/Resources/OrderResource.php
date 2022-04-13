<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource {

  public function toArray($request) {
    return [
      'id'         => $this->id,
      'fullName'   => $this->full_name,
      'phone1'     => $this->phone1,
      'phone2'     => $this->phone2,
      'address'    => $this->address,
      'amount'     => $this->amount,
      'source'     => $this->source,
      'comments'   => $this->comments,
      'reportId'   => $this->report_id,
      'storeId'    => $this->store_id,
      'status'     => $this->status,
      'orderItems' => OrderItemResource::collection($this->orderItems),
    ];
  }

}
