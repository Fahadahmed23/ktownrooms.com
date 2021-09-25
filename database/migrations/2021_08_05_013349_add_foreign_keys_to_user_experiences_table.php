<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUserExperiencesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user_experiences', function(Blueprint $table)
		{
			$table->foreign('user_id', 'user_experiences_ibfk_1')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_experiences', function(Blueprint $table)
		{
			$table->dropForeign('user_experiences_ibfk_1');
		});
	}

}
