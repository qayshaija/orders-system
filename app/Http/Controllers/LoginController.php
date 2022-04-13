<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller {

  public function login(LoginRequest $request): JsonResponse {
    $username = $request->get('username');
    $user     = User::query()
                    ?->firstWhere('username', $username);
    return $this->handleAuthentication($user, $request);
  }

  public function userInfo(Request $request): JsonResponse {
    $user          = $request->user();
    $responseArray = [
      'username' => $user->username,
      'level'    => $user->level,
    ];
    return response()->json($responseArray);
  }

  public function logout() {
    Auth::user()?->currentAccessToken()?->delete();
  }

  private function generateToken(User|Model $user): string {
    $username = $user->username;
    $user->tokens()->delete();
    return $user->createToken($username)->plainTextToken;
  }

  private function isAuthenticated(Model|User $user, LoginRequest $request): bool {
    $username = $request->get('username');
    $password = $request->get('password');
    if ($user->username === $username && Hash::check($password, $user->password)) {
      return TRUE;
    }
    return FALSE;
  }

  private function handleAuthentication(Model|User|null $user, LoginRequest $request): JsonResponse {
    if (!!$user && $this->isAuthenticated($user, $request)) {
      $response = $this->generateToken($user);
      return response()->json([
        'token' => $response,
      ]);
    }
    return response()->json(['error' => "Invalid Credentials"]);
  }

}
