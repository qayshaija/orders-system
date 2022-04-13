<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int              $id
 * @property string           $username
 * @property string           $password
 * @property \Carbon\Carbon   $created_at
 */
class User extends Authenticatable {

  use HasApiTokens, HasFactory, Notifiable;

  protected string $guard_name = 'sanctum';


  protected $fillable
    = [
      'username',
      'password',
      'level',
    ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array
   */
  protected $hidden
    = [
      'password',
      'remember_token',
    ];

  /**
   * The attributes that should be cast.
   *
   * @var array
   */
  protected $casts
    = [
      'email_verified_at' => 'datetime',
    ];

}
