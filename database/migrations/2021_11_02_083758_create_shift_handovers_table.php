<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShiftHandoversTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shift_handovers', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->decimal('cash_receive', 18)->nullable();
			$table->decimal('cash_paid', 18)->nullable();
			$table->integer('hand_over_to')->nullable();
			$table->integer('hand_over_by')->nullable();
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
		Schema::drop('shift_handovers');
	}

}
