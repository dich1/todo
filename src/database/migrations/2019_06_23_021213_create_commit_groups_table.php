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
            $table->string('content');
            $table->boolean('status')->default(false);
            $table->integer('priority')->unsigned();
            $table->timestamps();

            $table->foreign('commit_id')
                ->references('id')
                ->on('commits')
                ->onDelete('cascade');
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
