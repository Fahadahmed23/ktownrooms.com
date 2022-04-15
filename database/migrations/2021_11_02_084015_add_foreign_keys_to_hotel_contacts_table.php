<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToHotelContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('hotel_contacts', function(Blueprint $table)
		{
			$table->foreign('hotel_id', 'hotel_contacts_ibfk_1')->references('id')->on('hotels')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('contact_type_id', 'hotel_contacts_ibfk_2')->references('id')->on('contact_types')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('hotel_contacts', function(Blueprint $table)
		{
			$table->dropForeign('hotel_contacts_ibfk_1');
			$table->dropForeign('hotel_contacts_ibfk_2');
		});
	}

}
