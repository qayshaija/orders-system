<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin  \App\Models\User
 */
class UserResource extends JsonResource {

  /**
   * Transform the resource into an array.
   *
   * @param   \Illuminate\Http\Request  $request
   *
   * @return array
   */
  public function toArray($request) {
    return [
      'id'            => $this->id,
      'username'      => $this->username,
      'reportGroupId' => $this->report_group_id,
      'dashboardId'   => $this->dashboard_id,
      'createdAt'     => $this->created_at->toDateTimeString(),
    ];
  }

}
