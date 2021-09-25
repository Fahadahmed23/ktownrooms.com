<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function(Blueprint $table)
		{
			$table->bigInteger('PageID', true);
			$table->string('Title')->nullable();
			$table->string('Slug')->nullable();
			$table->text('Content', 65535)->nullable();
			$table->text('MetaTitle', 65535)->nullable();
			$table->text('MetaKeywords', 65535)->nullable();
			$table->text('MetaDescription', 65535)->nullable();
			$table->boolean('MainMenu')->default(0);
			$table->boolean('Status');
			$table->dateTime('DateAdded');
			$table->dateTime('DateModified');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pages');
	}

}
