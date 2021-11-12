<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUserAddressesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user_addresses', function(Blueprint $table)
		{
			$table->foreign('state_id', 'user_addresses_ibfk_1')->references('id')->on('states')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('city_id', 'user_addresses_ibfk_2')->references('id')->on('cities')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('user_id', 'user_addresses_ibfk_3')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_addresses', function(Blueprint $table)
		{
			$table->dropForeign('user_addresses_ibfk_1');
			$table->dropForeign('user_addresses_ibfk_2');
			$table->dropForeign('user_addresses_ibfk_3');
		});
	}

}
