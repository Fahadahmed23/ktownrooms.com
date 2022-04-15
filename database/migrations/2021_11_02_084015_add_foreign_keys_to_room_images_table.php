<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToRoomImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('room_images', function(Blueprint $table)
		{
			$table->foreign('room_id', 'room_images_ibfk_1')->references('id')->on('rooms')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('created_by', 'room_images_ibfk_2')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('updated_by', 'room_images_ibfk_3')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('room_images', function(Blueprint $table)
		{
			$table->dropForeign('room_images_ibfk_1');
			$table->dropForeign('room_images_ibfk_2');
			$table->dropForeign('room_images_ibfk_3');
		});
	}

}
