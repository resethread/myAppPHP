<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('poster')->nullable();
            $table->string('path');
            $table->string('duration')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('nb_total_rate')->default(0);
            $table->integer('nb_users_rating')->default(0);
            $table->float('rate')->default(0);
            $table->integer('nb_views')->default(0);
            $table->integer('nb_favorited')->default(0);
            $table->integer('nb_comments')->default(0);
            $table->boolean('validated')->default(false);
            $table->rememberToken();
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
        Schema::drop('videos');
    }
}
