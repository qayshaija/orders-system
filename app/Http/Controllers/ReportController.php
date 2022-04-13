<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReportResource;
use App\Models\Order;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller {

  public function index(): JsonResponse {
    $reports = Report::query()->withCount('orders')->orderByDesc('id')->take(100)->get();
    return response()->json(ReportResource::collection($reports));
  }

  public function storeOrUpdate(Request $request, Report $report = NULL): JsonResponse {
    $requestFields = array_filter([
      'name'          => $request->get('name'),
      'status'        => $request->get('status'),
      'comments'      => $request->get('comments'),
      'cash_received' => $request->get('cashReceived'),
    ]);
    if ($report) {
      $report->update($requestFields);
    }
    else {
      $report = Report::query()->create($requestFields);
    }
    return response()->json(new ReportResource($report->refresh()));
  }

  public function destroy(Report $report): JsonResponse {
    Order::query()->where('report_id', $report->id)->update(['report_id' => NULL]);
    return response()->json(['success' => !!$report->delete()]);
  }

}
