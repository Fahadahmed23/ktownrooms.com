<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCategoryFacilitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('category_facilities', function(Blueprint $table)
		{
			$table->foreign('room_category_id', 'category_facilities_ibfk_1')->references('id')->on('room_categories')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('facility_id', 'category_facilities_ibfk_2')->references('id')->on('facilities')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('category_facilities', function(Blueprint $table)
		{
			$table->dropForeign('category_facilities_ibfk_1');
			$table->dropForeign('category_facilities_ibfk_2');
		});
	}

}
