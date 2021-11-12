<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOpeningShiftHandoversTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('opening_shift_handovers', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('shift_handover_id')->nullable();
			$table->integer('user_id')->nullable();
			$table->decimal('opening_balance', 11)->nullable();
			$table->boolean('is_closed')->nullable()->default(0);
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
		Schema::drop('opening_shift_handovers');
	}

}
