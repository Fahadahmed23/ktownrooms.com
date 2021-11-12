<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roles', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 573)->nullable();
			$table->string('display_name', 573)->nullable();
			$table->string('landing_page', 573)->nullable();
			$table->string('description', 573)->nullable();
			$table->integer('preference')->nullable()->default(1);
			$table->boolean('is_system')->nullable();
			$table->timestamps();
			$table->integer('created_by')->nullable()->index('created_by');
			$table->integer('updated_by')->nullable()->index('updated_by');
			$table->string('created_by_ip', 150)->nullable();
			$table->string('updated_by_ip', 150)->nullable();
			$table->text('create_data', 65535)->nullable();
			$table->text('update_data', 65535)->nullable();
			$table->string('created_by_module', 300)->nullable();
			$table->string('updated_by_module', 300)->nullable();
			$table->boolean('has_discount_priviledge')->nullable()->default(0);
			$table->boolean('has_multiple_hotels')->nullable()->default(0);
			$table->boolean('self_manipulated_entries')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('roles');
	}

}
