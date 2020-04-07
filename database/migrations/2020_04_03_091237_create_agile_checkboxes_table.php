<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgileCheckboxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agile_ticket_checkboxes', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('bug_id');
            $table->boolean('in_de_mededeling')->default(false);
            $table->boolean('akkoord_klant')->default(false);
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
        Schema::drop('agile_checkboxes');
    }
}
