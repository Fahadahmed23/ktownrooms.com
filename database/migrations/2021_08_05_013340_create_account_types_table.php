<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('account_types', function(Blueprint $table)
		{
			$table->smallInteger('id', true);
			$table->string('title', 100)->nullable()->unique('title');
			$table->string('initial_state', 25)->nullable();
			$table->string('interval', 25)->nullable();
			$table->string('description', 300)->nullable();
			$table->enum('posting_type', array('BS','PL'))->nullable();
			$table->dateTime('CreationDate')->nullable()->default(\DB::raw('CURRENT_TIMESTAMP'));
			$table->string('CreationIP', 50)->nullable();
			$table->integer('created_by')->nullable();
			$table->string('CreatedByModule', 100)->nullable();
			$table->string('UpdationIP', 50)->nullable();
			$table->integer('UpdatedByUser')->nullable();
			$table->string('UpdatedByModule', 100)->nullable();
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
		Schema::drop('account_types');
	}

}
