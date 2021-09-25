<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLeavesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('leaves', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id');
			$table->date('LeaveRequestFrom');
			$table->date('LeaveRequestTo');
			$table->enum('status', array('pending','approved','rejected'));
			$table->enum('type', array('sick leave','maternity/paternity','casual leave','personal leave'))->nullable();
			$table->string('reason', 500)->nullable();
			$table->string('rejected_reason', 500)->nullable();
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
		Schema::drop('leaves');
	}

}
