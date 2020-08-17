<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectorateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directorate_meetings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('meeting_id')->unsigned();
            $table->bigInteger('directorate_id')->unsigned();
            $table->bigInteger('secretary_id')->unsigned()->nullable();
            $table->time('meeting_time')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->foreign('meeting_id')->references('id')->on('meetings');
            $table->foreign('directorate_id')->references('id')->on('directorates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('directorate_meetings');
    }
}
