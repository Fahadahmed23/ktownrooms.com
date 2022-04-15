<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_reports', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->index('FK_user_reports_users');
			$table->string('description', 5000);
			$table->string('name', 500);
			$table->string('module', 100);
			$table->string('report_name', 100);
			$table->text('criteria', 65535);
			$table->text('columns', 65535);
			$table->text('grouped_columns', 65535);
			$table->timestamps();
			$table->integer('created_by')->index('FK_user_reports_users_1');
			$table->integer('updated_by')->index('FK_user_reports_users_2');
			$table->string('created_by_ip', 50);
			$table->string('updated_by_ip', 50);
			$table->text('create_data', 65535);
			$table->text('update_data', 65535);
			$table->string('created_by_module', 100);
			$table->string('updated_by_module', 100);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_reports');
	}

}
