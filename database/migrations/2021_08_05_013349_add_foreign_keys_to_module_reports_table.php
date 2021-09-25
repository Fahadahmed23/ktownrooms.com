<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToModuleReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('module_reports', function(Blueprint $table)
		{
			$table->foreign('module_id', 'module_reports_ibfk_1')->references('id')->on('modules')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('module_reports', function(Blueprint $table)
		{
			$table->dropForeign('module_reports_ibfk_1');
		});
	}

}
