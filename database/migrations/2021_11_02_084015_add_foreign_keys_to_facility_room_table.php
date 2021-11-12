<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToFacilityRoomTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('facility_room', function(Blueprint $table)
		{
			$table->foreign('room_id', 'facility_room_ibfk_1')->references('id')->on('rooms')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('facility_id', 'facility_room_ibfk_2')->references('id')->on('facilities')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('facility_room', function(Blueprint $table)
		{
			$table->dropForeign('facility_room_ibfk_1');
			$table->dropForeign('facility_room_ibfk_2');
		});
	}

}
