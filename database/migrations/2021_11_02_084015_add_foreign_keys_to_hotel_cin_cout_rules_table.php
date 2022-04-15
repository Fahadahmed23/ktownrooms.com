<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToHotelCinCoutRulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('hotel_cin_cout_rules', function(Blueprint $table)
		{
			$table->foreign('cin_cout_rule_id', 'cin_cout_rule_ibfk_1')->references('id')->on('cin_cout_rules')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('hotel_id', 'hotel_ibfk_1')->references('id')->on('hotels')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('hotel_cin_cout_rules', function(Blueprint $table)
		{
			$table->dropForeign('cin_cout_rule_ibfk_1');
			$table->dropForeign('hotel_ibfk_1');
		});
	}

}
