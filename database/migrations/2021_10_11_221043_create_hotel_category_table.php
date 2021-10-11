<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_category', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id')->nullable();
            $table->integer('hotel_category_id')->nullable(); 
            $table->integer('created_by')->nullable()->index('created_by');
			$table->integer('updated_by')->nullable()->index('updated_by');
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
        Schema::dropIfExists('hotel_category');
    }
}
