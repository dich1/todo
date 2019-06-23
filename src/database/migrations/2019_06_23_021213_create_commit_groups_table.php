<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommitGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commit_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('commit_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('content');
            $table->integer('priority')->unsigned();
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
        Schema::dropIfExists('commit_groups');
    }
}
