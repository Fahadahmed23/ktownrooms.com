<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserExperiencesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_experiences', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id')->index('user_id');
			$table->string('no_of_years', 10)->nullable();
			$table->string('organization_name')->nullable();
			$table->string('role', 100)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('created_by')->nullable()->index('created_by');
			$table->integer('updated_by')->nullable()->index('updated_by');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_experiences');
	}

}
