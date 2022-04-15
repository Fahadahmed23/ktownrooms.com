<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmployeetaskmastersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employeetaskmasters', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('EmployeeCode');
			$table->integer('PriorityCode');
			$table->integer('TaskAssignedBy');
			$table->integer('StatusCode');
			$table->dateTime('AssignedDateTime');
			$table->string('Comments', 200);
			$table->softDeletes();
			$table->timestamps();
			$table->string('CreationIP', 50);
			$table->integer('created_by');
			$table->string('CreatedByModule', 100);
			$table->string('UpdationIP', 50)->nullable();
			$table->integer('updated_by')->nullable();
			$table->string('UpdatedByModule', 100)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('employeetaskmasters');
	}

}
