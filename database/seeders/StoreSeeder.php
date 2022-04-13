<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    $stores = ['Store X11', 'DBS Store', 'IE Market'];

    for ($i = 0; $i < count($stores) ; $i++) {
      $createdStore = Store::query()->firstOrNew([
        'name' => $stores[$i],
      ]);
      $createdStore->save();
    }
  }

}
