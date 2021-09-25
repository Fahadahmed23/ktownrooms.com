<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAccountGlMappingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('account_gl_mapping', function(Blueprint $table)
		{
			$table->foreign('account_gl_id', 'account_gl_mapping_ibfk_1')->references('id')->on('account_gl')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('hotel_id', 'account_gl_mapping_ibfk_2')->references('id')->on('hotels')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('account_gl_mapping', function(Blueprint $table)
		{
			$table->dropForeign('account_gl_mapping_ibfk_1');
			$table->dropForeign('account_gl_mapping_ibfk_2');
		});
	}

}
