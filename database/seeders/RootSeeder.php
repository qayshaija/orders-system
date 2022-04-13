<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class RootSeeder extends Seeder {

  public function run() {
    $createdUser = User::query()->firstOrNew([
      'username' => env('ROOT_USERNAME'),
      'password' => bcrypt(env('ROOT_PASSWORD')),
      'level'    => 1,
    ]);
    $createdUser->save();
  }

}
