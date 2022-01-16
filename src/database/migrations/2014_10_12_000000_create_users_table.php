<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('line_id')->nullable();
      $table->string('google_id')->nullable();
      $table->string('twitter_id')->nullable();
      $table->string('facebook_id')->nullable();
      $table->string('image')->nullable();
      $table->string('username', 60);
      $table->string('email', 255)->nullable()->unique();
      $table->string('password', 255)->nullable();
      $table->integer('role')->default(10);
      $table->datetime('login_time')->default(DB::raw('CURRENT_TIMESTAMP'));
      $table->rememberToken();
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('users');
  }
}
