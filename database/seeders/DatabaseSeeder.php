<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

  public function run() {
    $this->call(RootSeeder::class);
    $this->call(StoreSeeder::class);
  }

}
