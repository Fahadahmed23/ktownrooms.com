<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountGlMappingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('account_gl_mapping', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->bigInteger('account_gl_id')->nullable()->index('account_gl_id');
			$table->integer('hotel_id')->nullable()->index('hotel_id');
			$table->boolean('is_active')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('account_gl_mapping');
	}

}
