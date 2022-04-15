<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('emails', function(Blueprint $table)
		{
			$table->integer('EmailID');
			$table->string('SignupEmail')->nullable();
			$table->string('ResetPassword')->nullable();
			$table->string('BookingEmail')->nullable();
			$table->string('SupportEmail')->nullable();
			$table->string('AdminEmail')->nullable();
			$table->dateTime('DateModified')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('emails');
	}

}
