<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountAutoPostingTable extends Migration {
	
	// comment kt-new 
	/**
	 * Run the migrations.
	 * 
	 * @return void
	 */
	public function up()
	{
		Schema::create('account_auto_posting', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->boolean('auto_posting_type_id');
			$table->string('account_gl_code', 50);
			$table->string('account_gl_name', 100)->nullable();
			$table->boolean('account_level')->nullable()->default(4);
			$table->boolean('is_dr');
			$table->boolean('is_cr');
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
		Schema::drop('account_auto_posting');
	}

}
