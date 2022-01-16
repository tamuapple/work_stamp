<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('attendances', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('user_id');
      $table->date('date');
      $table->boolean('is_absence')->default(false)->comment('欠勤かどうか');
      $table->double('break_time');
      $table->string('memo')->nullable();
      $table->timestamps();
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('attendances');
  }
}
