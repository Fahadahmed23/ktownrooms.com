<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModuleReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('module_reports', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('module_id')->nullable()->index('module_id');
			$table->string('role_ids')->nullable();
			$table->string('name')->nullable();
			$table->text('description')->nullable();
			$table->string('report_name')->nullable();
			$table->longText('columns')->nullable();
			$table->longText('criteria')->nullable();
			$table->longText('grouped_columns')->nullable();
			$table->timestamps();
			$table->integer('created_by')->nullable()->index('created_by');
			$table->integer('updated_by')->nullable()->index('updated_by');
			$table->string('created_by_ip', 150)->nullable();
			$table->string('updated_by_ip', 150)->nullable();
			$table->longText('create_data')->nullable();
			$table->longText('update_data')->nullable();
			$table->string('created_by_module')->nullable();
			$table->string('updated_by_module')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('module_reports');
	}

}
