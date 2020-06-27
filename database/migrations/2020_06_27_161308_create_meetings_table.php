<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('meet_description')->nullable();
            $table->string('meet_title');
            $table->bigInteger('meet_chairman')->unsigned();
            $table->bigInteger('meet_secretary')->unsigned();
            $table->bigInteger('document_id')->unsigned();
            $table->timestamp('created_at')->useCurrent();
            $table->foreign('meet_chairman')->references('id')->on('users');
            $table->foreign('meet_secretary')->references('id')->on('users');
            $table->foreign('document_id')->references('id')->on('documents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meetings');
    }
}
