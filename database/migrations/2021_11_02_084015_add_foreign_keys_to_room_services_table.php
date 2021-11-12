<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToRoomServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('room_services', function(Blueprint $table)
		{
			$table->foreign('room_id', 'room_services_ibfk_1')->references('id')->on('rooms')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('service_id', 'room_services_ibfk_2')->references('id')->on('services')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('room_services', function(Blueprint $table)
		{
			$table->dropForeign('room_services_ibfk_1');
			$table->dropForeign('room_services_ibfk_2');
		});
	}

}
