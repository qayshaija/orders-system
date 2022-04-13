<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoreController extends Controller {

  public function index(): JsonResponse {
    $stores = Store::all();
    return response()->json($stores);
  }

  public function storeOrUpdate(Request $request, Store $store = NULL): JsonResponse {
    $name = $request->get('name');
    if ($store) {
      $store->update(['name' => $name]);
    }
    else {
      $store = Store::query()->create(['name' => $name]);
    }
    return response()->json($store);
  }

  public function destroy(Store $store): JsonResponse {
    return response()->json(['success' => !!$store->delete()]);
  }

}
