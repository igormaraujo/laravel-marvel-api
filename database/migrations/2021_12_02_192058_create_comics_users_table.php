<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComicsUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('comic_user', function (Blueprint $table) {
      $table->primary(['comic_id', 'user_id']);
      $table->foreignId('comic_id')->constrained();
      $table->foreignId('user_id')->constrained();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('comic_user');
  }
}
