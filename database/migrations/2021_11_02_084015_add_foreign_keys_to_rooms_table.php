<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToRoomsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('rooms', function(Blueprint $table)
		{
			$table->foreign('hotel_id', 'rooms_ibfk_1')->references('id')->on('hotels')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('room_type_id', 'rooms_ibfk_2')->references('id')->on('room_types')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('room_category_id', 'rooms_ibfk_3')->references('id')->on('room_categories')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('tax_rate_id', 'rooms_ibfk_4')->references('id')->on('tax_rates')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('rooms', function(Blueprint $table)
		{
			$table->dropForeign('rooms_ibfk_1');
			$table->dropForeign('rooms_ibfk_2');
			$table->dropForeign('rooms_ibfk_3');
			$table->dropForeign('rooms_ibfk_4');
		});
	}

}
