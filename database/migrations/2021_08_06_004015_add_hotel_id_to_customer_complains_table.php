<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHotelIdToCustomerComplainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_complains', function (Blueprint $table) {
            $table->integer('hotel_id')->nullable()->index('hotel_id');
            $table->foreign('hotel_id', 'hotels_customer_ibfk_1')->references('id')->on('hotels')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_complains', function (Blueprint $table) {
            $table->dropForeign('hotels_ibfk_1');
        });
    }
}
