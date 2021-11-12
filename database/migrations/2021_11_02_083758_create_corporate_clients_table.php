<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCorporateClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('corporate_clients', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('FullName');
			$table->string('EmailAddress', 50);
			$table->string('ContactNo', 20);
			$table->integer('NoOfRooms')->nullable();
			$table->string('Location');
			$table->text('Description', 65535)->nullable();
			$table->boolean('Status');
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
		Schema::drop('corporate_clients');
	}

}
