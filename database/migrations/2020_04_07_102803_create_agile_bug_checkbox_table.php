<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgileBugCheckboxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agile_bug_checkbox', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('bug_id');
            $table->integer('checkbox_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('agile_bug_checkbox');
    }
}
