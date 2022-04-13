<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UsersCollection extends ResourceCollection {

  public function toArray($request) {
    return UserResource::collection($this->collection);
  }

}
