<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpeningShiftHandoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opening_shift_handovers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->nullable()->index('user_id');
            $table->integer('shift_handover_id')->nullable()->index('shift_handover_id');
            $table->double('opening_balance');
            $table->tinyInteger('is_closed')->default(0);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('shift_handover_id')->references('id')->on('shift_handovers')->onDelete('CASCADE');

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
        Schema::dropIfExists('opening_shift_handovers');
    }
}
