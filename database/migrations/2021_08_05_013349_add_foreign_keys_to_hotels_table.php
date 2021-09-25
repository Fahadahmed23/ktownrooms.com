<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToHotelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('hotels', function(Blueprint $table)
		{
			$table->foreign('city_id', 'hotels_city_ibfk_1')->references('id')->on('cities')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('company_id', 'hotels_ibfk_2')->references('id')->on('companies')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('hotels', function(Blueprint $table)
		{
			$table->dropForeign('hotels_ibfk_1');
			$table->dropForeign('hotels_ibfk_2');
		});
	}

}
