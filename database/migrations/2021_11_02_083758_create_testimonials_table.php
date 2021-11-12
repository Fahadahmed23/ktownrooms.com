<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTestimonialsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('testimonials', function(Blueprint $table)
		{
			$table->bigInteger('TestimonialID');
			$table->string('Testimonial', 600);
			$table->string('testimonial-title', 100);
			$table->string('Name', 100);
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
		Schema::drop('testimonials');
	}

}
