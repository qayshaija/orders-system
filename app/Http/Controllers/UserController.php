<?php

namespace App\Http\Controllers;


use App\Http\Resources\UserResource;
use App\Http\Resources\UsersCollection;
use App\Models\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller {

  public function index(): JsonResponse {
    $users = User::query()->where('level', 2)->get()->flatten();
    return response()->json(new UsersCollection($users));
  }

  public function store(Request $request): JsonResponse {
    $username        = $request->get('username');
    $password        = bcrypt($request->get('password'));

    $createdUser = User::query()->create([
      'username'        => $username,
      'password'        => $password,
      'level'         => 2,
    ]);
    return response()->json(!!$createdUser ? new UserResource($createdUser) : []);
  }

  public function update(User $user, Request $request): JsonResponse {
    $username        = $request->get('username');
    $password        = bcrypt($request->get('password'));
    $updatedFields = [
      'username'        => $username,
      'password'        => $password,
    ];
    $isUpdated     = $user->update(array_filter($updatedFields));
    return response()->json($isUpdated ? new UserResource($user) : []);
  }

  public function destroy(User $user, Request $request): JsonResponse {
    $isDeleted = $user->delete();
    return response()->json(['success' => $isDeleted]);
  }

}
