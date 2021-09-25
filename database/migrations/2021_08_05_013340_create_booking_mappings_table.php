<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookingMappingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('booking_mappings', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->enum('client', array('Ktown'))->nullable();
			$table->enum('type', array('hotel','roomcategory'))->nullable();
			$table->enum('source_type', array('int','str'))->nullable();
			$table->string('source', 100)->nullable();
			$table->integer('destination')->nullable();
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
		Schema::drop('booking_mappings');
	}

}
