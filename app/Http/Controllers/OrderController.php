<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Report;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller {

  public function storeExternal(Request $request): JsonResponse {
    $orderItems = $request->get('orderItems');
    $targetKeys = array_filter([
      'full_name' => $request->get('fullName'),
      'phone1'    => $request->get('phone1'),
      'phone2'    => $request->get('phone2'),
      'address'   => $request->get('address'),
      'amount'    => floatval($request->get('amount')),
      'source'    => 'external',
      'comments'  => $request->get('comments'),
      'store_id'  => $request->get('storeId'),
    ], fn($el) => !!$el || is_numeric($el));
    $order = Order::query()->create($targetKeys);
    if ($request->has('orderItems') && count($orderItems)) {
      $this->updateOrderItems($order, $orderItems);
    }
    return response()->json([]);
  }


  private function updateOrderItems(Model|Order $order, array $orderItems) {
    $existedIds = [];
    foreach ($orderItems as $index => $orderItem) {
      $createdItem  = $order->orderItems()->updateOrCreate(['index' => $index], [
        'product_title' => $orderItem['title'],
        'product_price' => $orderItem['price'],
        'is_primary'    => $orderItem['isPrimary'],
      ]);
      $existedIds[] = $createdItem->refresh()->id;
    }
    $order->orderItems()->whereNotIn('id', $existedIds)->delete();
  }

  public function index(): JsonResponse {
    $orders = Order::query()->with('orderItems')->orderByDesc('id')->take(500)->get();
    return response()->json(OrderResource::collection($orders));
  }

  public function reportOrders(Report $report): JsonResponse {
    $orders = $report->orders()->with('orderItems')->orderByDesc('id')->get();
    return response()->json(OrderResource::collection($orders));
  }

  public function bulkUpdate(Request $request): JsonResponse {
    $orderIds   = $request->get('orderIds');
    $targetKeys = array_filter([
      'report_id' => $request->get('reportId'),
      'status'    => $request->get('status'),
    ]);
    if ($request->has('reportId')) {
      $targetKeys['report_id'] = $request->get('reportId');
    }
    $targetedOrders = Order::query()->whereIn('id', $orderIds);
    $targetedOrders->update($targetKeys);
    return response()->json(OrderResource::collection($targetedOrders->get()));
  }

  public function bulkDelete(Request $request): JsonResponse {
    $orderIds  = $request->get('orderIds');
    $isDeleted = Order::query()->whereIn('id', $orderIds)->delete();
    return response()->json(['success' => !!$isDeleted]);
  }

  public function storeOrUpdate(Request $request, Order $order = NULL): JsonResponse {
    $orderItems = $request->get('orderItems');
    $targetKeys = array_filter([
      'full_name' => $request->get('fullName'),
      'phone1'    => $request->get('phone1'),
      'phone2'    => $request->get('phone2'),
      'address'   => $request->get('address'),
      'amount'    => floatval($request->get('amount')),
      'source'    => 'manual',
      'comments'  => $request->get('comments'),
      'store_id'  => $request->get('storeId'),
      'report_id' => $request->get('reportId'),
      'status'    => $request->get('status'),
    ], fn($el) => !!$el || is_numeric($el));

    if (!$order) {
      $order = Order::query()->create($targetKeys);
    }
    else {
      $order->update($targetKeys);
    }

    if ($request->has('orderItems') && count($orderItems)) {
      $this->updateOrderItems($order, $orderItems);
    }
    return response()->json(new OrderResource($order));
  }

  public function destroy(Order $order): JsonResponse {
    return response()->json(['success' => !!$order->delete()]);
  }

}
