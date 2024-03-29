<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUserReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user_reports', function(Blueprint $table)
		{
			$table->foreign('user_id', 'user_reports_ibfk_1')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('created_by', 'user_reports_ibfk_2')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('updated_by', 'user_reports_ibfk_3')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_reports', function(Blueprint $table)
		{
			$table->dropForeign('user_reports_ibfk_1');
			$table->dropForeign('user_reports_ibfk_2');
			$table->dropForeign('user_reports_ibfk_3');
		});
	}

}
