<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('orders', function (Blueprint $table) {
      $table->id();

      $table->unsignedBigInteger('store_id')->nullable();
      $table->foreign('store_id')->references('id')->on('stores');

      $table->unsignedBigInteger('user_id')->nullable();
      $table->foreign('user_id')->references('id')->on('users');

      $table->unsignedBigInteger('report_id')->nullable();
      $table->foreign('report_id')->references('id')->on('reports');

      $table->string('full_name');
      $table->string('phone1');
      $table->string('phone2')->nullable();
      $table->string('address');
      $table->float('amount');
      $table->string('source');
      $table->text('comments')->nullable();

      $table->integer('status')->default(1);

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('orders');
  }

};
