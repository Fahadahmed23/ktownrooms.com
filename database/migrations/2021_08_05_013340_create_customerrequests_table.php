<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerrequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customerrequests', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('customer_id');
			$table->integer('department_id');
			$table->integer('StatusCode');
			$table->string('RequestNumber', 15);
			$table->dateTime('RequestTime');
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
		Schema::drop('customerrequests');
	}

}
