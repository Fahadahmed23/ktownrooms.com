<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaskPrioritiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('task_priorities', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('TaskPriority', 50);
			$table->softDeletes();
			$table->timestamps();
			$table->string('CreationIP', 50);
			$table->integer('created_by');
			$table->string('CreatedByModule', 100);
			$table->string('UpdationIP', 50)->nullable();
			$table->integer('updated_by')->nullable();
			$table->string('UpdatedByModule', 100)->nullable();
			$table->string('style_class', 50)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('task_priorities');
	}

}
