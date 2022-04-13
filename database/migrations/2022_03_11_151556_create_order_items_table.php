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
    Schema::create('order_items', function (Blueprint $table) {
      $table->id();

      $table->unsignedBigInteger('order_id');
      $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();

      $table->string('product_title');
      $table->float('product_price')->default(0);

      $table->boolean('is_primary')->default(TRUE);

      $table->integer('index')->default(0);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('order_items');
  }

};
