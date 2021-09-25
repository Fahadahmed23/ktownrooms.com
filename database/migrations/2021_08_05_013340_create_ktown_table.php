<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateKtownTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ktown', function(Blueprint $table)
		{
			$table->string('COL 1', 14)->nullable();
			$table->string('COL 2', 11)->nullable();
			$table->string('COL 3', 14)->nullable();
			$table->string('COL 4', 12)->nullable();
			$table->string('COL 5', 13)->nullable();
			$table->string('COL 6', 13)->nullable();
			$table->string('COL 7', 15)->nullable();
			$table->string('COL 8', 15)->nullable();
			$table->string('COL 9', 13)->nullable();
			$table->string('COL 10', 15)->nullable();
			$table->string('COL 11', 15)->nullable();
			$table->string('COL 12', 15)->nullable();
			$table->string('COL 13', 13)->nullable();
			$table->string('COL 14', 15)->nullable();
			$table->string('COL 15', 15)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ktown');
	}

}
