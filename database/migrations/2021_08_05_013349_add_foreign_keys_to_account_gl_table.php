<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAccountGlTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('account_gl', function(Blueprint $table)
		{
			$table->foreign('account_type_id', 'account_gl_ibfk_1')->references('id')->on('account_types')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('hotel_id', 'account_gl_ibfk_2')->references('id')->on('hotels')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('account_fiscal_years_master_id', 'account_gl_ibfk_3')->references('id')->on('account_fiscalyears_master')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('account_level_id', 'account_gl_ibfk_4')->references('id')->on('account_levels')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('account_gl', function(Blueprint $table)
		{
			$table->dropForeign('account_gl_ibfk_1');
			$table->dropForeign('account_gl_ibfk_2');
			$table->dropForeign('account_gl_ibfk_3');
			$table->dropForeign('account_gl_ibfk_4');
		});
	}

}
