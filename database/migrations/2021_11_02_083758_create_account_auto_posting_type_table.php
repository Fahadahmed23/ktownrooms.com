<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountAutoPostingTypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('account_auto_posting_type', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('title', 100);
			$table->string('description', 150)->nullable();
			$table->boolean('is_active')->nullable()->default(1);
			$table->bigInteger('CreatedBy')->nullable();
			$table->dateTime('CreatedOn')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('account_auto_posting_type');
	}

}
