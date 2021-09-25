<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountFiscalyearsMasterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('account_fiscalyears_master', function(Blueprint $table)
		{
			$table->smallInteger('id', true);
			$table->string('title', 100)->nullable();
			$table->string('description', 200)->nullable();
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
			$table->enum('status', array('active','inactive','closed'))->nullable();
			$table->integer('CreatedByUser')->nullable();
			$table->dateTime('CreationDate')->nullable();
			$table->string('CreationIP', 50)->nullable();
			$table->string('CreatedByModule', 50)->nullable();
			$table->dateTime('UpdationDate')->nullable();
			$table->string('UpdationIP', 50)->nullable();
			$table->integer('UpdatedByUser')->nullable();
			$table->string('UpdatedByModule', 50)->nullable();
			$table->boolean('IsDeleted')->nullable()->default(1);
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
		Schema::drop('account_fiscalyears_master');
	}

}
