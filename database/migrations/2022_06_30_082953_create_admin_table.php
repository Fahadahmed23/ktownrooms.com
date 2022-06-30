<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->bigIncrements('AdminID');
            $table->string('FirstName',100)->nullable();
            $table->string('LastName',100)->nullable();
            $table->string('Email',100)->nullable();
            $table->string('Contact',100)->nullable();
            $table->string('ProfilePicture',100)->nullable();
            $table->string('Username',100)->nullable();
            $table->string('Password',100)->nullable();
            $table->dateTime('DateAdded')->nullable();
            $table->dateTime('DateModified')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin');
    }
}
