<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSlidersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sliders', function(Blueprint $table)
		{
			$table->bigInteger('SlideID');
			$table->string('Title')->nullable();
			$table->text('Description', 65535)->nullable();
			$table->string('Image');
			$table->boolean('Status');
			$table->dateTime('DateAdded');
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
		Schema::drop('sliders');
	}

}
