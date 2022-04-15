<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmployeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employees', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('EmployeeNumber', 25);
			$table->integer('HotelCode');
			$table->integer('DepartmentCode');
			$table->integer('DesignationCode');
			$table->string('FirstName', 100);
			$table->string('LastName', 100);
			$table->string('CNIC', 100);
			$table->string('Address', 150);
			$table->string('ContactNumber1', 25);
			$table->string('ContactNumber2', 25);
			$table->string('Email', 100);
			$table->dateTime('DateOfBirth');
			$table->char('Gender', 1);
			$table->integer('MaritalStatusCode');
			$table->integer('CountryCode');
			$table->integer('StateCode');
			$table->integer('CityCode');
			$table->string('ZipCode', 10);
			$table->boolean('IsActive', 1);
			$table->softDeletes();
			$table->timestamps();
			$table->string('CreationIP', 50);
			$table->integer('created_by');
			$table->string('CreatedByModule', 100);
			$table->string('UpdationIP', 50)->nullable();
			$table->integer('updated_by')->nullable();
			$table->string('UpdatedByModule', 100)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('employees');
	}

}
