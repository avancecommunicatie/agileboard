<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agile_stories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->string('subject');
            $table->text('content');
            $table->timestamps();
        });

        Schema::create('agile_projectgroups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('agile_projectgroups_projects', function (Blueprint $table) {
            $table->integer('projectgroup_id')->unsigned();
            $table->integer('project_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('agile_stories');
        Schema::drop('agile_projectgroups');
        Schema::drop('agile_projectgroups_projects');
    }
}
