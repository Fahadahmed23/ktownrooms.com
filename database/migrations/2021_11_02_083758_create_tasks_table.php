<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tasks', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('booking_id')->nullable();
			$table->string('booking_no', 100)->nullable();
			$table->integer('room_id')->nullable();
			$table->string('room_title', 100)->nullable();
			$table->integer('service_id')->nullable();
			$table->string('service', 150)->nullable();
			$table->enum('status', array('todo','inprogress','completed'))->nullable();
			$table->enum('priority', array('Low','Normal','High'))->nullable();
			$table->string('description', 250)->nullable();
			$table->integer('department_id')->nullable();
			$table->string('department', 150)->nullable();
			$table->time('performing_time')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('hotel_id')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tasks');
	}

}
