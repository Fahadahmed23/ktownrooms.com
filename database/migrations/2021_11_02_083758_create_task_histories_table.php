<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaskHistoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('task_histories', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('task_id')->nullable();
			$table->string('status', 25)->nullable();
			$table->time('time')->nullable()->default('00:00:00');
			$table->timestamps();
			$table->dateTime('deleted_at')->default('0000-00-00 00:00:00');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('task_histories');
	}

}
