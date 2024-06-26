<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusColumnToCustomersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('customers', function (Blueprint $table) {
      $table->enum('status', ['active', 'inactive', 'pending'])->default('pending')->after('image');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('customers', function (Blueprint $table) {
      $table->dropColumn('status');
    });
  }
}
