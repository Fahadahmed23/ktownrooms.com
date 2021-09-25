<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToHotelRoomCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('hotel_room_category', function(Blueprint $table)
		{
			$table->foreign('hotel_id', 'hotel_room_category_ibfk_1')->references('id')->on('hotels')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('room_category_id', 'hotel_room_category_ibfk_2')->references('id')->on('room_categories')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('hotel_room_category', function(Blueprint $table)
		{
			$table->dropForeign('hotel_room_category_ibfk_1');
			$table->dropForeign('hotel_room_category_ibfk_2');
		});
	}

}
